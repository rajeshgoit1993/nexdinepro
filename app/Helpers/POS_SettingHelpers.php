<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Crypt;
use DB;
use Sentinel;
use App\Models\FoodMenuCategory;
use App\Models\AssignFoodMenuCategoryToBrands;
use App\Models\FanchiseRegistration;
use App\Models\PosOrderTables;
use App\Models\FranchiseFoodMenuPrice;
use App\Models\FoodMenu;
use App\Helpers\CustomHelpers;
use App\Models\MasterGst;
use Carbon\Carbon;
use App\Models\RegionSetting;
use App\Models\AssignFoodMenuToBrands;
class POS_SettingHelpers 
{
  
 public static function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

  public static function get_charge_value($percentage,$total_gross_amount,$total_overall_discount)
  {
    if($total_overall_discount=='')
   {
    $total_overall_discount=0;
   }

  $tmp = explode('%',$percentage);
    if(isset($tmp[1])){

        $percentage_value  = $tmp[0];
        $percentage_amount=($total_gross_amount-$total_overall_discount)*$percentage_value/100;
        return number_format((float)($percentage_amount),2, '.', '');
     
       
    }else{
      return number_format((float)($tmp[0]),2, '.', '');
     
       
    }
  }
  public static function get_region_ids($region)
  {
    $region_data=RegionSetting::find($region);   
           $previous_id=[];
           $outlet_ids=unserialize($region_data->assign_outlet);
             foreach($outlet_ids as $d):
                $previous_id[]=$d;
             endforeach;
            $previous_ids=array_unique($previous_id);

            return $previous_ids;

  }
  public static function get_food_menu_cp($food_menu_id)
  {
   
   $ingredients=DB::table('assign_food_menu_ingredients')->where('food_menu_id',$food_menu_id)->get();

   $total=0;
   $total_gst=0;
   $total_without_gst=0;
   foreach($ingredients as $ingredient)
   {
    $ingredient_id=$ingredient->ingredient_id;
    $consumption=$ingredient->consumption;
    $rate_data=DB::table('master_products')->where('id',$ingredient_id)->first();
    
    if($rate_data!='' && $rate_data->franchise_rate!='' && (float)$rate_data->franchise_rate!='0')
    {
        if($rate_data->gst_id!=''):
          $gst_data=MasterGst::find($rate_data->gst_id);
          if($gst_data!=''):
           $gst_value=$gst_data->gst_value;
           if($gst_value!='' && $gst_value!='0'):
            $gst=((float)$consumption*(float)$rate_data->franchise_rate*(float)$gst_value/100);
            $total_gst=(float)$total_gst+(float)$gst;
            $total_without_gst=(float)$total_without_gst+((float)$consumption*$rate_data->franchise_rate);
            $total=$total+((float)$consumption*(float)$rate_data->franchise_rate)+(float)$gst;   
           else:
          
            $total_without_gst=$total_without_gst+((float)$consumption*(float)$rate_data->franchise_rate);
            $total=$total+((float)$consumption*(float)$rate_data->franchise_rate);   
           endif;
           
          else:
           $total_without_gst=$total_without_gst+((float)$consumption*(float)$rate_data->franchise_rate);
            $total=$total+((float)$consumption*(float)$rate_data->franchise_rate);
          endif;
                 
      else:
        $total_without_gst=$total_without_gst+((float)$consumption*(float)$rate_data->franchise_rate);
        $total=$total+((float)$consumption*(float)$rate_data->franchise_rate);
      endif;  
   
    }
   }

$output=['cp_without_gst'=>round($total_without_gst, 2),'cp_gst'=>round($total_gst, 2),'cp_total'=>round($total, 2),'sync'=>date('d-m-Y h:i:sa')];

   return $output;
  
  }
  public static function get_food_menu_sp($food_menu_id)
  {
   

   $food_menu=DB::table('food_menus')->where('id',$food_menu_id)->first();
   $total=0;
   $total_gst=0;
   $total_without_gst=0;
   if($food_menu!=''):
   $gst=json_decode($food_menu->tax_information);
   $gst_id=$gst[0]->tax_field_id;
   $gst_data=MasterGst::find($gst_id);
   
          if($gst_data!=''):
           $gst_value=$gst_data->gst_value;
            if($gst_value!='' && $gst_value!='0'):
            $gst=((float)$food_menu->sale_price*(float)$gst_value/100);
            $total_gst=(float)$total_gst+(float)$gst;
            $total_without_gst=(float)$total_without_gst+(float)($food_menu->sale_price);
            $total=$total+((float)$food_menu->sale_price)+(float)$gst;   
           else:
          
           $total_without_gst=(float)$total_without_gst+(float)($food_menu->sale_price);
            $total=$total+((float)$food_menu->sale_price);   
           endif;
           
          else:
            $total_without_gst=(float)$total_without_gst+(float)($food_menu->sale_price);
            $total=$total+((float)$food_menu->sale_price);  
          endif;

   endif;

  
  $output=['cp_without_gst'=>round($total_without_gst, 2),'cp_gst'=>round($total_gst, 2),'cp_total'=>round($total, 2)];

   return $output;
  
  }
  public static function update_pre_pos_data($outlet_id,$outlet_brand_id)
  {

   $add_food_menues=FoodMenu::all();
 
     foreach($add_food_menues as $food_menu):
        
     $gst_data=json_decode($food_menu->tax_information);
     $gst_id=$gst_data[0]->tax_field_id;
     $tax_information = array();
      $gst_data=MasterGst::find((int)$gst_id);
          if($gst_data!='')
          {
           $gst=$gst_data->gst_value;
          }
          else
          {
            $gst=0;
          }
      $single_info = array(
                        'tax_field_id' => $gst_id,
                        'tax_field_company_id' => 1,
                        'tax_field_name' => 'GST',
                        'tax_field_percentage' =>$gst
                    );
         array_push($tax_information,$single_info);
      $tax_information = json_encode($tax_information);
      $new_data=FoodMenu::find((int)$food_menu->id);
      $new_data->tax_information=$tax_information;
      $new_data->save();
     endforeach;
       $all_assigned_food=DB::table('assign_food_menu_to_brands')->get();
       foreach($all_assigned_food as $all_assigned) 
       {
        $food_menu_id=$all_assigned->menu_category_id;
        $check_available_food_menu=FoodMenu::find($food_menu_id);
        if($check_available_food_menu=='')
        {
       AssignFoodMenuToBrands::destroy($all_assigned->id);
        }
       }
       //price update
     $assign_food_menus=DB::table('assign_food_menu_to_brands')->where('brand_id', '=',(int)$outlet_brand_id)->get();
  
       foreach($assign_food_menus as $d):
        $check_food_menu=DB::table('franchise_food_menu_prices')->where([['outlet_id','=',(int)$outlet_id],['food_menu_id','=',$d->menu_category_id]])->first();

        if($check_food_menu==''):
            $sale_price=POS_SettingHelpers::get_food_menu_price($d->menu_category_id);
            $tax=POS_SettingHelpers::get_food_menu_tax($d->menu_category_id);
            $category_id=POS_SettingHelpers::get_food_menu_category_id($d->menu_category_id);

            
         $new_menu=new FranchiseFoodMenuPrice;
         $new_menu->outlet_id=(int)$outlet_id;
         $new_menu->food_menu_id=$d->menu_category_id;
         $new_menu->sale_price=$sale_price;
         $new_menu->category_id=$category_id;
         $new_menu->tax_information=$tax;
         $new_menu->save();
       
       elseif($check_food_menu->tax_information=='' || $check_food_menu->category_id==''):
         $check_tax=FranchiseFoodMenuPrice::find((int)$check_food_menu->id);
         $tax=POS_SettingHelpers::get_food_menu_tax($check_tax->food_menu_id);
            $category_id=POS_SettingHelpers::get_food_menu_category_id($check_tax->food_menu_id);
         $check_tax->category_id=$category_id;
         $check_tax->tax_information=$tax;
         $check_tax->save();
       elseif($check_food_menu->category_id==0):
        $category_id=POS_SettingHelpers::get_food_menu_category_id($check_tax->food_menu_id);
        if($category_id==0):
          FranchiseFoodMenuPrice::destroy((int)$check_food_menu->id);
        else:
        $check_tax=FranchiseFoodMenuPrice::find((int)$check_food_menu->id);
         $tax=POS_SettingHelpers::get_food_menu_tax($check_tax->food_menu_id);
            

         $check_tax->category_id=$category_id;
         $check_tax->tax_information=$tax;
         $check_tax->save();
       endif;
       elseif($check_food_menu->tax_information!='' && $check_food_menu->tax_information!=0): 
       $check_tax=FranchiseFoodMenuPrice::find((int)$check_food_menu->id);
        $gst_data=json_decode($check_tax->tax_information);
       $gst_id=$gst_data[0]->tax_field_id;
       $tax_information = array();
      $gst_data=MasterGst::find((int)$gst_id);
          if($gst_data!='')
          {
           $gst=$gst_data->gst_value;
          }
          else
          {
            $gst=0;
          }
      $single_info = array(
                        'tax_field_id' => $gst_id,
                        'tax_field_company_id' => 1,
                        'tax_field_name' => 'GST',
                        'tax_field_percentage' =>$gst
                    );
         array_push($tax_information,$single_info);
      $tax_information = json_encode($tax_information);
     
      $check_tax->tax_information=$tax_information;
      $check_tax->save();


        endif;
       endforeach;
      //price update
      //   //
      //    $assign_food_menus=DB::table('franchise_food_menu_prices')->where('outlet_id', '=', (int)$outlet_id)->get();
      //  foreach($assign_food_menus as $d):
      //   $check_tax=FranchiseFoodMenuPrice::find((int)$d->id);
      //   if($check_tax->tax_information=='' || $check_tax->category_id==''):
      //       $tax=POS_SettingHelpers::get_food_menu_tax($check_tax->food_menu_id);
      //       $category_id=POS_SettingHelpers::get_food_menu_category_id($check_tax->food_menu_id);
      //    $check_tax->category_id=$category_id;
      //    $check_tax->tax_information=$tax;
      //    $check_tax->save();
      //   elseif($check_tax->tax_information!='' && $check_tax->tax_information!=0):
      //       $gst_data=json_decode($check_tax->tax_information);
      //  $gst_id=$gst_data[0]->tax_field_id;
      //  $tax_information = array();
      // $gst_data=MasterGst::find((int)$gst_id);
      //     if($gst_data!='')
      //     {
      //      $gst=$gst_data->gst_value;
      //     }
      //     else
      //     {
      //       $gst=0;
      //     }
      // $single_info = array(
      //                   'tax_field_id' => $gst_id,
      //                   'tax_field_company_id' => 1,
      //                   'tax_field_name' => 'GST',
      //                   'tax_field_percentage' =>$gst
      //               );
      //    array_push($tax_information,$single_info);
      // $tax_information = json_encode($tax_information);
     
      // $check_tax->tax_information=$tax_information;
      // $check_tax->save();
      //   endif;
      //   //
      


      //  endforeach;
   
  }

  public static function update_outlet_menues($outlet_id,$outlet_brand_id)
  {

   
   $data=DB::table('franchise_food_menu_prices')->where('outlet_id','=',$outlet_id)->get();
   foreach($data as $d)
   {

   
    $food_menu_id=$d->food_menu_id;
    $menu_data=DB::table('food_menus')->where('id',(int)$food_menu_id)->first();

    if($menu_data!='' && $menu_data->category_id!=''):
    $new_data=FranchiseFoodMenuPrice::find((int)$d->id);
    $new_data->category_id=$menu_data->category_id;
    $new_data->save();
    endif;

    $check_data=DB::table('assign_food_menu_to_brands')->where([['menu_category_id','=',(int)$food_menu_id],['brand_id','=',$outlet_brand_id]])->first();
     if($check_data=='')
     {
      FranchiseFoodMenuPrice::destroy($d->id);
     }
    $check_exist_food_menu=DB::table('food_menus')->where('id',$food_menu_id)->first();
    if($check_exist_food_menu=='')
     {
      FranchiseFoodMenuPrice::destroy($d->id);
     }

   }
  }

  public static function get_food_menu_assign_brands_status($category_id,$brand_id)
  {

   $status=DB::table('assign_food_menu_category_to_brands')->where([['food_menu_category_id','=',$category_id],['brand_id','=',$brand_id]])->first();
   if($status!='')
   {
    return 1;
   }
   else
   {
    return 0;
   }
  }
  public static function get_foodmenu_assign_brands_status($category_id,$brand_id)
  {

   $status=DB::table('assign_food_menu_to_brands')->where([['menu_category_id','=',$category_id],['brand_id','=',$brand_id]])->first();
   if($status!='')
   {
    return 1;
   }
   else
   {
    return 0;
   }
  }
  public static function getTablesByOutletId($outlet_id) {
   
        $result=DB::table('franchise_table_settings')->where('outlet_id','=',$outlet_id)->get();

        if($result != false){
          return $result;
        }else{
          return false;
        }
    }
     public static function get_food_menu_price($food_menu_id) {
    
        $result=DB::table('food_menus')->where('id','=',$food_menu_id)->first();
        if($result==''):
         return 0;
        else:
          return $result->sale_price;
        endif;
         
    }
     public static function get_food_menu_tax($food_menu_id) {
    
        $result=DB::table('food_menus')->where('id','=',$food_menu_id)->first();
        if($result==''):
         return 0;
        else:
          return $result->tax_information;
        endif;
         
    }
    public static function get_food_menu_category_id($food_menu_id) {
    
        $result=DB::table('food_menus')->where('id','=',$food_menu_id)->first();
        if($result==''):
         return 0;
        else:
          return $result->category_id;
        endif;
         
    }
    public static function get_franchise_food_price($food_menu_id,$outlet_id) {
    
        $result=DB::table('franchise_food_menu_prices')->where([['outlet_id','=',$outlet_id],['food_menu_id',$food_menu_id]])->first();
        if($result==''):
         return 0;
        else:
          return $result->sale_price;
        endif;
         
    }
    public static function get_franchise_tax($food_menu_id,$outlet_id) {
    
        $result=DB::table('franchise_food_menu_prices')->where([['outlet_id','=',$outlet_id],['food_menu_id',$food_menu_id]])->first();
        if($result==''):
         return 0;
        else:
          return $result->tax_information;
        endif;
         
    }
    public static function get_food_category_name($category_id) {
    
        $result=DB::table('food_menu_categories')->where('id','=',$category_id)->first();
        if($result==''):
         return 0;
        else:
          return $result->category_name;
        endif;
         
    }
  public static function getOrdersOfTableByTableId($table_id)
    {

      $result=DB::table('pos_order_tables')->where([["table_id", $table_id],["del_status", "Live"]])->get();

        if($result != false){
          return $result;
        }else{
          return false;
        }
    }
    public static function get_brand_id()
    {
      $outlet_id=Sentinel::getUser()->parent_id;
      $data=FanchiseRegistration::where('fanchise_id',(int)$outlet_id)->first();
      return $data->brands;
    }
    public static function get_brand_by_admin_id($outlet_id)
    {
      
      $data=FanchiseRegistration::where('fanchise_id',(int)$outlet_id)->first();
      return $data->brands;
    }
    public static function getFoodMenuCategories($outlet_id) 
    {
      
     
      // $result = DB::table('assign_food_menu_category_to_brands')
      //          ->join('food_menu_categories','assign_food_menu_category_to_brands.food_menu_category_id' , '=', 'food_menu_categories.id')
              
      //         ->where('assign_food_menu_category_to_brands.brand_id' , '=', (int)$brand_id)->get();
     $result = DB::table('food_menu_categories')
              
              ->where('outlet_id' , '=', (int)$outlet_id)->get();

           if($result != false){
          return $result;
        }else{
          return false;
        }   
              
              

       
    }
    public static function getAllFoodMenus(){
      $outlet_id =Sentinel::getUser()->parent_id;
      $outlet_brand_id=POS_SettingHelpers::get_brand_id();
    
     // $assign_food_menu_ids = DB::table('assign_food_menu_to_brands')->where('brand_id',$outlet_brand_id)->pluck('menu_category_id');
    $outlet_brand_id=POS_SettingHelpers::get_brand_id();
    // $assign_food_menu_category_ids = DB::table('assign_food_menu_category_to_brands')->where('brand_id',$outlet_brand_id)->pluck('food_menu_category_id');
     
    //  $assign_food_menu_ids=DB::table('franchise_food_menu_prices')->where([['outlet_id',$outlet_id],['status','=',1]])->whereIn('category_id',$assign_food_menu_category_ids)->pluck('food_menu_id');

     // $assign_food_menu_ids = DB::table('assign_food_menu_category_to_brands')
     //       ->join('franchise_food_menu_prices','franchise_food_menu_prices.category_id' , '=', 'assign_food_menu_category_to_brands.food_menu_category_id')
     //       ->where([['assign_food_menu_category_to_brands.brand_id',$outlet_brand_id],['outlet_id',$outlet_id],['status','=',1]])->pluck('franchise_food_menu_prices.food_menu_id');

     // $assign_food_menu_ids = DB::table('assign_food_menu_to_brands')
     //       ->join('franchise_food_menu_prices','franchise_food_menu_prices.food_menu_id' , '=', 'assign_food_menu_to_brands.menu_category_id')
     //       ->where([['assign_food_menu_to_brands.brand_id',$outlet_brand_id],['franchise_food_menu_prices.outlet_id',$outlet_id],['status','=',1]])->pluck('franchise_food_menu_prices.food_menu_id');      
     $assign_food_menu_ids = DB::table('franchise_food_menu_prices')->where([['outlet_id',$outlet_id],['status','=',1]])->pluck('food_menu_id');

        // $result = DB::table('franchise_food_menu_prices')
        //        ->join('food_menus','franchise_food_menu_prices.food_menu_id' , '=', 'food_menus.id')
        //       ->leftJoin('food_menu_categories', 'food_menu_categories.id', '=', 'food_menus.category_id')
              
        //       ->select('food_menus.*', 'food_menu_categories.category_name', 'franchise_food_menu_prices.sale_price','franchise_food_menu_prices.tax_information')
        //       ->where([['franchise_food_menu_prices.outlet_id', '=', (int)$outlet_id],['franchise_food_menu_prices.status', '=',1]])
        //       ->whereNotNull('food_menu_categories.category_name')
        //       ->whereIn('food_menus.id',$assign_food_menu_ids)
        //     ->orderBy('category_name')
        //     ->get();

       
   $result = DB::table('food_menus')
              
              ->leftJoin('food_menu_categories', 'food_menu_categories.id', '=', 'food_menus.category_id')
              
              ->select('food_menus.*', 'food_menu_categories.category_name')
              ->where('food_menus.outlet_id', '=', (int)$outlet_id)
              ->whereNotNull('food_menu_categories.category_name')
            
            ->orderBy('category_name')
            ->get();

      
      if($result != false){
        return $result;
      }else{
        return false;
      }

    }

    public static function getAllMenuCategories(){
      $outlet_brand_id=POS_SettingHelpers::get_brand_id();
      
         // $result = DB::table('assign_food_menu_category_to_brands')
         //       ->join('food_menu_categories','assign_food_menu_category_to_brands.food_menu_category_id' , '=', 'food_menu_categories.id')
              
         //    ->where('assign_food_menu_category_to_brands.brand_id' , '=', (int)$outlet_brand_id)->get();

  $outlet_id =Sentinel::getUser()->parent_id;
  $assign_food_menu_categories_id = DB::table('franchise_food_menu_prices')->where([['outlet_id',$outlet_id],['status','=',1]])->pluck('category_id');
          
          $result = DB::table('food_menu_categories')->where('outlet_id' ,$outlet_id)->get();

        if($result != false){
          return $result;
        }else{
          return false;
        }
    }

    public static function getAllMenuModifiers(){


      $outlet_id =Sentinel::getUser()->parent_id;
      $result = DB::table('franchise_food_menus_modifiers')
               ->leftJoin('franchise_modifiers','franchise_modifiers.id' , '=', 'franchise_food_menus_modifiers.modifier_id')
               ->select('franchise_food_menus_modifiers.*', 'franchise_modifiers.name', 'franchise_modifiers.price')
            ->where([["franchise_food_menus_modifiers.outlet_id", $outlet_id],["franchise_food_menus_modifiers.del_status", 'Live']])->orderBy('id', 'ASC')->get();
      if($result != false){
        return $result;
      }else{
        return false;
      }
    }

   public static function getWaitersForThisCompany($outlet_id){
      $role = Sentinel::findRoleById(20);
        
        $all_users = $role->users()->where([['parent_id',$outlet_id],['status',1]])->get();

        return $all_users;
    }
  public static function getNewOrders($outlet_id){
        $today_date = date('Y-m-d');
        $user_id = Sentinel::getUser()->id;
    
       $outlet_id =Sentinel::getUser()->parent_id;
        if(Sentinel::getUser()->inRole('waiter')):
         $is_waiter = 'Yes';
       $result = DB::table('franchise_sales')
               ->leftJoin('franchise_table_settings','franchise_table_settings.id' , '=', 'franchise_sales.table_id')
               ->leftJoin('users','users.id' , '=', 'franchise_sales.waiter_id')
               ->leftJoin('franchise_customers','franchise_customers.id' , '=', 'franchise_sales.customer_id')
               ->select('franchise_sales.*', 'franchise_sales.id as sale_id','franchise_customers.*', 'franchise_customers.name as customer_name','users.name as waiter_name','franchise_table_settings.name as table_name')
            ->where([["franchise_sales.outlet_id", $outlet_id],["franchise_sales.del_status",'Live'],["franchise_sales.waiter_id", $user_id]])
            ->whereIn("franchise_sales.order_status",[1,2])
            ->whereIn("franchise_sales.future_sale_status",[1,3])
            ->orderBy('franchise_sales.id', 'ASC')->get();
        else:
          $is_waiter = 'No';
          $result = DB::table('franchise_sales')
               ->leftJoin('franchise_table_settings','franchise_table_settings.id' , '=', 'franchise_sales.table_id')
               ->leftJoin('users','users.id' , '=', 'franchise_sales.waiter_id')
               ->leftJoin('franchise_customers','franchise_customers.id' , '=', 'franchise_sales.customer_id')
               ->select('franchise_sales.*', 'franchise_sales.id as sale_id','franchise_customers.*', 'franchise_customers.name as customer_name','users.name as waiter_name','franchise_table_settings.name as table_name')
            ->where([["franchise_sales.outlet_id", $outlet_id],["franchise_sales.del_status",'Live']])
            ->whereIn("franchise_sales.order_status",[1,2])
            ->whereIn("franchise_sales.future_sale_status",[1,3])
            ->orderBy('franchise_sales.id', 'ASC')->get();
        endif;
        
        if($result != false){
          return $result;
        }else{
          return false;
        }

    }
    public static function getSaleBySaleId($sales_id){
     

     // $result = DB::table('franchise_sales')
     //           ->leftJoin('franchise_customers','franchise_customers.id' , '=', 'franchise_sales.customer_id')
     //           ->leftJoin('users','users.id' , '=', 'franchise_sales.user_id')
     //           ->leftJoin('franchise_table_settings','franchise_table_settings.id' , '=', 'franchise_sales.table_id')
     //           ->leftJoin('fanchise_registrations','fanchise_registrations.fanchise_id' , '=', 'franchise_sales.outlet_id')
     //           ->leftJoin('users as w','w.id' , '=', 'franchise_sales.waiter_id')
     //           ->select('franchise_sales.*','w.name as waiter_name', 'franchise_customers.name as customer_name','franchise_customers.phone as phone','franchise_customers.address as customer_address', 'franchise_customers.name as customer_name','users.name as user_name','franchise_table_settings.name as table_name','fanchise_registrations.brands as invoice_footer')
     //        ->where("franchise_sales.id",$sales_id)
           
     //        ->orderBy('franchise_sales.id', 'ASC')->get();
   $result = DB::table('franchise_sales')
               ->leftJoin('franchise_customers','franchise_customers.id' , '=', 'franchise_sales.customer_id')
               ->leftJoin('users','users.id' , '=', 'franchise_sales.user_id')
               ->leftJoin('pos_order_tables','pos_order_tables.sale_id' , '=', 'franchise_sales.id')
               ->leftJoin('franchise_table_settings','franchise_table_settings.id' , '=', 'pos_order_tables.table_id')
               ->leftJoin('fanchise_registrations','fanchise_registrations.fanchise_id' , '=', 'franchise_sales.outlet_id')
               ->leftJoin('users as w','w.id' , '=', 'franchise_sales.waiter_id')
               ->select('franchise_sales.*','w.name as waiter_name', 'franchise_customers.name as customer_name','franchise_customers.phone as phone','franchise_customers.address as customer_address', 'franchise_customers.name as customer_name','users.name as user_name','franchise_table_settings.name as table_name','fanchise_registrations.brands as invoice_footer')
            ->where("franchise_sales.id",$sales_id)
           
            ->orderBy('franchise_sales.id', 'ASC')->get();
     

        if($result != false){
          return $result;
        }else{
          return false;
        }
    }
    public static function getAllItemsFromSalesDetailBySalesId($sales_id){

     $result = DB::table('franchise_sales_details')
               ->leftJoin('food_menus','food_menus.id' , '=', 'franchise_sales_details.food_menu_id')
               ->select('franchise_sales_details.*','franchise_sales_details.id as sales_details_id', 'food_menus.code as code')
            ->where("sales_id", $sales_id)->orderBy('franchise_sales_details.id', 'ASC')->get();

        if($result != false){
          return $result;
        }else{
          return false;
        }
    }
   public static function getModifiersBySaleAndSaleDetailsId($sales_id,$sale_details_id){

    $result = DB::table('franchise_sale_details_modifiers')
               ->leftJoin('franchise_modifiers','franchise_modifiers.id' , '=', 'franchise_sale_details_modifiers.modifier_id')
               ->select('franchise_sale_details_modifiers.*','franchise_modifiers.name')
            ->where([["franchise_sale_details_modifiers.sales_id", $sales_id],["franchise_sale_details_modifiers.sales_details_id", $sale_details_id]])->orderBy('franchise_sale_details_modifiers.id', 'ASC')->get();

        if($result != false){
          return $result;
        }else{
          return false;
        }
    }
    public static function get_total_kitchen_type_items($sale_id)
    {

      $result=DB::table('franchise_sales_details')->where("sales_id", $sale_id)->get();
       
        return count($result);
    }
    public static function get_total_kitchen_type_done_items($sale_id)
    {
      $result=DB::table('franchise_sales_details')->where([["sales_id", $sale_id],["cooking_status", "Done"]])->get();
        return count($result);
    }
    public static function get_total_kitchen_type_started_cooking_items($sale_id)
    {
      $result=DB::table('franchise_sales_details')->where([["sales_id", $sale_id],["cooking_status", "Started Cooking"]])->get();
        return count($result);
       
    }
    public static function get_all_tables_of_a_sale_items($sale_id)
    {
    $result = DB::table('pos_order_tables')
               ->leftJoin('franchise_table_settings','franchise_table_settings.id' , '=', 'pos_order_tables.table_id')
               ->select('franchise_table_settings.name as table_name')
            ->where("sale_id", $sale_id)->get();

        if($result != false){
          return $result;
        }else{
          return false;
        }

    }
     public static function getAllPaymentMethods()
    {
      $outlet_id =Sentinel::getUser()->parent_id;
      // $result=DB::table('franchise_payment_options')->where([["outlet_id",$outlet_id],["del_status", 'Live']])->get();
      $result=DB::table('outlet_payment_methods')->where("status",1)->get();

        if($result != false){
          return $result;
        }else{
          return false;
        }
    }
    public static function getNotificationByOutletId($outlet_id)
    {
      $result=DB::table('franchise_notifications')->where("outlet_id", $outlet_id)->orderBy('id', 'ASC')->get();
      
        if($result != false){
          return $result;
        }else{
          return false;
        }
    }
    public static function getAmtP($amount) {
    if(!is_numeric($amount)){
        $amount = 0;
    }
   
    $precision = 2;
    $str_amount = (number_format(isset($amount) && $amount?$amount:0,$precision,'.',''));
    return $str_amount;
   }
   public static function getAmt($amount) {
    if(!is_numeric($amount)){
        $amount = 0;
    }
    
  
    $currency = '₹';
    $precision =2;
    $str_amount = '';
    $str_amount = $currency.(number_format(isset($amount) && $amount?$amount:0,$precision,'.',''));
    return $str_amount;
}
   public static function escape_output($string){
    if($string){
        return htmlentities($string, ENT_QUOTES, 'UTF-8');
    }else{
        return '';
    }

   }
   public static function getTableAvailability($outlet_id)
    {
      $result=DB::table('pos_order_tables')->where([["outlet_id", $outlet_id],["del_status", "Live"]])->select(DB::raw('SUM(persons) as persons_number'),'table_id')->groupBy('table_id')->get();

  

        if($result != false){
          return $result;
        }else{
          return false;
        }
    }
   public static function getCustomerInfoById($customer_id)
    {
      $result=DB::table('franchise_customers')->where("id",$customer_id)->first();
     
      return $result;
    }
    public static function getItemType($item_id)
    {
      $result=DB::table('food_menus')->where("id",$item_id)->select('nonveg as item_type')->first();
     
      return $result;
    }
    public static function get_temp_kot($id)
    {
      $result=DB::table('franchise_temp_kots')->where("id",$id)->first();
      
      return $result;
    }
    public static function getNumberOfHoldsByUserAndOutletId($outlet_id,$user_id)
    {
      $result=DB::table('franchise_table_holds')->where([["outlet_id",$outlet_id],["user_id", $user_id]])->select('id')->get();
      
     
      return count($result);
    }
    public static function getHoldsByOutletAndUserId($outlet_id,$user_id){
     
     $result = DB::table('franchise_table_holds')
               ->leftJoin('franchise_customers','franchise_customers.id' , '=', 'franchise_table_holds.customer_id')
               ->leftJoin('franchise_table_settings','franchise_table_settings.id' , '=', 'franchise_table_holds.table_id')
               ->select('franchise_table_holds.*','franchise_customers.name as customer_name','franchise_table_settings.name as table_name','franchise_customers.phone')
            ->where([["franchise_table_holds.outlet_id", $outlet_id],["franchise_table_holds.user_id", $user_id],["franchise_table_holds.del_status", "Live"]])->orderBy('franchise_table_holds.id', 'ASC')->get();


        if($result != false){
          return $result;
        }else{
          return false;
        }
    }
    public static function get_all_tables_of_a_hold_items($hold_id)
    {
      $result = DB::table('franchise_hold_tables')
               ->leftJoin('franchise_table_settings','franchise_table_settings.id' , '=', 'franchise_hold_tables.table_id')
             
               ->select('franchise_hold_tables.*','franchise_table_settings.name as table_name')
            ->where("hold_id", $hold_id)->get();

 
        if($result != false){
          return $result;
        }else{
          return false;
        }

    }
    public static function get_hold_info_by_hold_id($hold_id)
    {
      $result = DB::table('franchise_table_holds')
               ->leftJoin('franchise_customers','franchise_customers.id' , '=', 'franchise_table_holds.customer_id')
              ->leftJoin('users','users.id' , '=', 'franchise_table_holds.waiter_id')
              ->leftJoin('franchise_table_settings','franchise_table_settings.id' , '=', 'franchise_table_holds.table_id')
               ->select('franchise_table_holds.*','users.name as waiter_name','franchise_customers.name as customer_name','franchise_table_settings.name as table_name')
            ->where("franchise_table_holds.id", $hold_id)->orderBy('franchise_table_holds.id', 'ASC')->get();

  

        if($result != false){
          return $result;
        }else{
          return false;
        }
    }
    public static function getAllItemsFromHoldsDetailByHoldsId($hold_id)
    {
      
       $result = DB::table('franchise_table_hold_details')
               ->leftJoin('food_menus','food_menus.id' , '=', 'franchise_table_hold_details.food_menu_id')
             
               ->select('franchise_table_hold_details.*','franchise_table_hold_details.id as holds_details_id')
            ->where("holds_id", $hold_id)->orderBy('franchise_table_hold_details.id', 'ASC')->get();



        if($result != false){
          return $result;
        }else{
          return false;
        }
    }
    public static function getModifiersByHoldAndHoldsDetailsId($hold_id,$holds_details_id)
    {
      $result = DB::table('franchise_table_hold_details_modifiers')
               ->leftJoin('franchise_modifiers','franchise_modifiers.id' , '=', 'franchise_table_hold_details_modifiers.modifier_id')
             
               ->select('franchise_table_hold_details_modifiers.*','franchise_modifiers.name')
            ->where([["franchise_table_hold_details_modifiers.holds_id", $hold_id],["franchise_table_hold_details_modifiers.holds_details_id", $holds_details_id]])->orderBy('franchise_table_hold_details_modifiers.id', 'ASC')->get();


        if($result != false){
          return $result;
        }else{
          return false;
        }
    }
    public static function get_outlet_details($outlet_id)
    {
      $result = DB::table('users')
               ->leftJoin('fanchise_registrations','fanchise_registrations.fanchise_id' , '=', 'users.id')
             
            
            ->where('users.id',$outlet_id)->first();


        if($result != false){
          return $result;
        }else{
          return false;
        }
    }
    public static function getPlanTextOrP($percentage) {
    $tmp = explode('%',$percentage);
    if(isset($tmp[1])){
        $total_amount  = $percentage;
        return $total_amount;
    }else{
        return isset($tmp[0]) && $tmp[0]?POS_SettingHelpers::getAmt($tmp[0]):POS_SettingHelpers::getAmt(0);
    }
   }
   public static function getLastTenSalesByOutletAndUserId($outlet_id){

     $result = DB::table('franchise_sales')
               ->leftJoin('franchise_customers','franchise_customers.id' , '=', 'franchise_sales.customer_id')
               ->leftJoin('franchise_table_settings','franchise_table_settings.id' , '=', 'franchise_sales.table_id')
            
            ->where([["franchise_sales.outlet_id", $outlet_id],["franchise_sales.del_status", "Live"]])
            ->whereIn('order_status',[2,3])
            ->whereDate('franchise_sales.created_at', Carbon::today())
             ->select('franchise_sales.*','franchise_customers.name as customer_name','franchise_table_settings.name as table_name','franchise_customers.phone')
             ->orderBy('franchise_sales.id', 'ASC')->get();


        if($result != false){
          return $result;
        }else{
          return false;
        }
    }

    public static function get_all_tables_of_a_last_sale($sale_id)
    {

       $result = DB::table('pos_order_tables')
               ->leftJoin('franchise_table_settings','franchise_table_settings.id' , '=', 'pos_order_tables.table_id')
            ->where("sale_id", $sale_id)
             ->select('franchise_table_settings.name as table_name')
             ->get();



        if($result != false){
          return $result;
        }else{
          return false;
        }

    }
     public static function future_sales($outlet_id){
        $today_date = date('Y-m-d');

         $result = DB::table('franchise_sales')
               ->leftJoin('franchise_customers','franchise_customers.id' , '=', 'franchise_sales.customer_id')
               ->leftJoin('franchise_table_settings','franchise_table_settings.id' , '=', 'franchise_sales.table_id')
            ->where([["franchise_sales.outlet_id", $outlet_id],["franchise_sales.del_status", "Live"],['future_sale_status','!=',1]])
            ->whereIn('order_status',[2,3])
             ->select('franchise_sales.*','franchise_customers.name as customer_name','franchise_table_settings.name as table_name','franchise_customers.phone')
             ->orderBy('franchise_sales.id', 'DESC')
             ->get();

        
        if($result != false){
            return $result;
        }else{
            return false;
        }

    }
    public static function delete_status_orders_table($sale_id)
    {
      $data = array();
        $data['del_status'] = 'Deleted';
      PosOrderTables::where('sale_id',$sale_id)->update($data);
       
    }

}