<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Sentinel;
use App\Helpers\CustomHelpers;
use App\Helpers\POS_SettingHelpers;
use App\Helpers\POSCommonHelpers;
use Image;
use App\Models\ItemImages;
use App\Models\MasterGst;
use App\Models\SupplyCart;
use App\Models\OrderPayment;
use App\Models\Brands;
use App\Models\Unit;
use App\Models\User;
use App\Models\Role;
use App\Models\StoreDetails;
use App\Models\Stores;
use App\Models\StoreAssignUser;
use App\Models\StoreProduct;
use App\Models\AssignProductFactoryVendor;
use App\Models\OrderItemDetails;
use App\Models\StoreSetting;
use App\Models\BrandWiseProduct;
use App\Models\FactoryIngredients;
use DB;
use Validator;
use App\Models\FoodMenuCategory;
use App\Models\FoodMenu;
use App\Models\AssignFoodMenuCategoryToBrands;
use App\Models\FranchiseCustomers;
use App\Models\FranchiseSale;
use App\Models\FranchiseFoodMenusModifiers;
use App\Models\FranchiseModifiers;
use App\Models\FranchiseNotificationBarKitchenPanel;
use App\Models\FranchiseNotification;
use App\Models\FranchisePaymentOption;
use App\Models\FranchiseSaleConsuptions;
use App\Models\FranchiseSaleConsuptionsOfMenu;
use App\Models\FranchiseSaleConsuptionsOfModifiersOfMenu;
use App\Models\FranchiseSaleDetailsModifier;
use App\Models\FranchiseSalesDetails;
use App\Models\FranchiseTableSetting;
use App\Models\PosOrderTables;
use App\Models\AssignFoodMenuIngredient;
use App\Models\FranchiseTempKot;
use App\Models\FranchiseTableHold;
use App\Models\FranchiseTableHoldDetails;
use App\Models\FranchiseTableHoldDetailsModifiers;
use App\Models\FranchiseHoldTable;
use App\Models\FranchiseStockStatus;
use App\Models\FranchiseFoodMenuPrice;
use App\Models\OutletSetting;
use App\Models\AssignFoodMenuToBrands;
use Carbon\Carbon;


class POSController extends Controller
{

   
   public function excel_uploads()
    {
     
     //For food menu category
     //  $csv=url("public/uploads/food_menu_category.csv");
     //  $rows=array();
     //  $rows=file($csv);
     //  $data_size=sizeof($rows);
     //   foreach($rows as $row):
     //  $data_array=explode(",",$row);
     //  if($data_array['0']!=''):
     //  $data=new FoodMenuCategory;   
     //  $data->id=$data_array['0'];
     //  $data->category_name=$data_array['1'];
     //  $data->description=$data_array['2'];
     //  $data->create_by_id=1;
     //  $data->save(); 
     //     endif;
     // endforeach;
   
   
   //for food menu
  //      $csv=url("public/uploads/food_menu.csv");
  //     $rows=array();
  //     $rows=file($csv);
  //     $data_size=sizeof($rows);
  //       foreach($rows as $row):
  //       $data_array=explode(",",$row);
  //        if($data_array['0']!=''):
    
  //      $data=new FoodMenu;
  //       $data->id=$data_array['0'];
  //       $data->code=$data_array['1'];
  //       $data->name=$data_array['2'];
        
  //       $data->category_id=$data_array['3'];
  //       $data->sale_price=$data_array['4'];
      
       
        
  //       $data->veg_item=$data_array['5'];
  //       $data->non_veg_item=$data_array['6'];
  //       $data->beverage_item=$data_array['7'];
        
  //       $data->making_time_in_min=$data_array['8'];

  //        $data->tax_information='[{"tax_field_id":"3","tax_field_company_id":1,"tax_field_name":"GST","tax_field_percentage":"5%"}]';

  //       $data->photo='no_image.jpg';
  //       $data->create_by_id=Sentinel::getUser()->id;
  //           $data->save();
 
  // endif;  
  //    endforeach;
            //For Assign food menu to brands
     //  $csv=url("public/uploads/assign_food_menu_to_brands.csv");
     //  $rows=array();
     //  $rows=file($csv);
     //  $data_size=sizeof($rows);
     //   foreach($rows as $row):
     //  $data_array=explode(",",$row);
     //  if($data_array['0']!=''):
     //  $data=new AssignFoodMenuToBrands;   
     //  $data->id=$data_array['0'];
     //  $data->menu_category_id=$data_array['1'];
     //  $data->brand_id=$data_array['2'];
     
     //  $data->save(); 
     //     endif;
     // endforeach;
    //For Assign Products to brands
 //      $csv=url("public/uploads/brand_wise_products.csv");
 //      $rows=array();
 //      $rows=file($csv);
 //      $data_size=sizeof($rows);
 //       foreach($rows as $row):
 //      $data_array=explode(",",$row);
    
 //      if($data_array['0']!=''):
 //      $data=new BrandWiseProduct;   
 //      // $data->id=$data_array['0'];
 //      $data->product_id=$data_array['0'];
 //      $data->brand_id=$data_array['1'];
 //      $data->initial_qty=$data_array['2'];
 //      $data->threshold_qty=$data_array['3'];
 //      $data->initial_qty=$data_array['4'];
 //      $data->save();
 //         endif;
 //     endforeach;
 //    echo "hi";
 // dd($csv);
    }

    public function index()
    {
     $outlet_id=Sentinel::getUser()->parent_id;
     $outlet_brand_id=POS_SettingHelpers::get_brand_id();

     // $update_pre_pos_data = POS_SettingHelpers::update_pre_pos_data($outlet_id,$outlet_brand_id);

       $stock_status=$this->check_status();
       if($stock_status!='success'):
        $data=['error'=>$stock_status];
      return view('outlet.error',compact('data'));
       else:

      
        //
   
        //
       $update_menues = POS_SettingHelpers::update_outlet_menues($outlet_id,$outlet_brand_id);
       //
       $data = array();
       $tables = POS_SettingHelpers::getTablesByOutletId($outlet_id);
       $data['tables'] = $this->getTablesDetails($tables);
       $data['categories'] = POS_SettingHelpers::getFoodMenuCategories($outlet_id);
       $data['customers'] = POSCommonHelpers::getAllByCompanyIdForDropdown($outlet_id, 'franchise_customers');
    
       $data['food_menus'] =  POS_SettingHelpers::getAllFoodMenus();  //missed item sold  

       $data['menu_categories'] = POS_SettingHelpers::getAllMenuCategories();
     
       $data['menu_modifiers'] = POS_SettingHelpers::getAllMenuModifiers();
       $data['waiters'] = POS_SettingHelpers::getWaitersForThisCompany($outlet_id);
       $data['new_orders'] = $this->get_new_orders();
       $data['outlet_information'] = User::find($outlet_id);
       $data['payment_methods'] = POS_SettingHelpers::getAllPaymentMethods();
       $data['notifications'] = $this->get_new_notification();
       // echo count($data['food_menus']);
       //   echo "<pre>";
       // var_dump($data['new_orders']);
       //  echo "<pre>";
       //  die();
      
       return view('outlet.pos.billing.index',compact('data'));
     endif;
    }
    public function check_status()
    {

        $outlet_id =Sentinel::getUser()->parent_id;
       
        //
       
       $stock_status=FoodMenu::where('outlet_id',$outlet_id)->first();
       if($stock_status==''):
         return 'Add Food Menu';
       else:
         return 'success';
       endif;

    }
     public function getTablesDetails($tables){
        foreach($tables as $table){
            $table->orders_table = POS_SettingHelpers::getOrdersOfTableByTableId($table->id);
            foreach($table->orders_table as $order_table){

                $to_time = strtotime(date('Y-m-d H:i:s'));
                $from_time = strtotime($order_table->booking_time);
                $minutes = floor(abs($to_time - $from_time) / 60);
                $seconds = abs($to_time - $from_time) % 60;

                $order_table->booked_in_minute = $minutes;
            }
        }
        return $tables;
    }

     public function get_new_orders(){
        $outlet_id =Sentinel::getUser()->parent_id;
       
        $data1 = POS_SettingHelpers::getNewOrders($outlet_id);
        
        
        $i = 0;
        for($i;$i<count($data1);$i++){
            $data1[$i]->total_kitchen_type_items = POS_SettingHelpers::get_total_kitchen_type_items($data1[$i]->sale_id);
            $data1[$i]->total_kitchen_type_done_items =POS_SettingHelpers::get_total_kitchen_type_done_items($data1[$i]->sale_id);
            $data1[$i]->total_kitchen_type_started_cooking_items = POS_SettingHelpers::get_total_kitchen_type_started_cooking_items($data1[$i]->sale_id);
            $data1[$i]->tables_booked = POS_SettingHelpers::get_all_tables_of_a_sale_items($data1[$i]->sale_id);

            $to_time = strtotime(date('Y-m-d H:i:s'));
            $from_time = strtotime($data1[$i]->date_time);
            $minutes = floor(abs($to_time - $from_time) / 60);
            $seconds = abs($to_time - $from_time) % 60;

            $data1[$i]->minute_difference = str_pad(floor($minutes), 2, "0", STR_PAD_LEFT);
            $data1[$i]->second_difference = str_pad(floor($seconds), 2, "0", STR_PAD_LEFT);
        }
        return $data1;
    }
    public function get_new_notification()
    {
        $outlet_id = Sentinel::getUser()->parent_id;
        $notifications = POS_SettingHelpers::getNotificationByOutletId($outlet_id);
     
        return $notifications;
    }
      public function get_all_tables_with_new_status_ajax(){
        $outlet_id = Sentinel::getUser()->parent_id;
        $tables = POS_SettingHelpers::getTablesByOutletId($outlet_id);
        $data1 = new \stdClass();
        $data1->table_details = $this->getTablesDetails($tables);
        $data1->table_availability = POS_SettingHelpers::getTableAvailability($outlet_id);
        echo json_encode($data1);
    }
     public function add_customer_by_ajax(Request $request){
        
        $customer_id =strip_tags($request->customer_id);
        $data['name'] =strip_tags($request->customer_name);
        $data['phone'] =strip_tags($request->customer_phone);
        $data['email'] =strip_tags($request->customer_email);
        if(strip_tags($request->customer_dob))
        {
            $data['date_of_birth'] = date('Y-m-d',strtotime(strip_tags($request->customer_dob)));
        }
        if(strip_tags($request->customer_doa)){
            $data['date_of_anniversary'] = date('Y-m-d',strtotime(strip_tags($request->customer_doa)));
        }
        $data['address'] =strip_tags($request->customer_delivery_address);
        $data['gst_number'] =strip_tags($request->customer_gst_number);
        $data['user_id'] = Sentinel::getUser()->id;
        $data['outlet_id'] = (int)Sentinel::getUser()->parent_id;
        $id_return = 0;

        if($customer_id>0 && $customer_id!=""){
           
             FranchiseCustomers::where('id',$customer_id)->update($data);
             $id_return =  $customer_id;
        }else{
             $data=FranchiseCustomers::create($data);
          $id_return =  $data->id;
        }
        echo $id_return ;
    }
    public function get_all_customers_for_this_user(){
        $outlet_id = (int)Sentinel::getUser()->parent_id;
        $data1 = FranchiseCustomers::where('outlet_id',$outlet_id)->get(); 
        echo json_encode($data1);
    }
   public function remove_notication_ajax(Request $request)
    {
        $notification_id =$request->notification_id;
        FranchiseNotification::where('id',$notification_id)->delete();
        echo escape_output($notification_id);
    }
    public function get_customer_ajax(Request $request)
    {
        $customer_id =$request->customer_id;
        $customer_info = POS_SettingHelpers::getCustomerInfoById($customer_id);
        echo json_encode($customer_info);
    }
    public function add_sale_by_ajax(Request $request){
        $order_details = json_decode(json_decode($request->order));
        // dd($order_details);
        //this id will be 0 when there is new order, but will be greater then 0 when there is modification
        //on previous order
        

        $sale_id = $request->sale_id;

        $data = array();
        $data['customer_id'] = trim($order_details->customer_id);
        $data['total_items'] = trim($order_details->total_items_in_cart);
        $data['sub_total'] = trim($order_details->sub_total);
        $data['charge_type'] = trim($order_details->charge_type);
        $data['gst'] = trim($order_details->total_vat);
        $data['total_payable'] = trim($order_details->total_payable);
        $data['total_item_discount_amount'] = trim($order_details->total_item_discount_amount);
        $data['sub_total_with_discount'] = trim($order_details->sub_total_with_discount);
        $data['sub_total_discount_amount'] = trim($order_details->sub_total_discount_amount);
        $data['total_discount_amount'] = trim($order_details->total_discount_amount);
        $data['delivery_charge'] = trim($order_details->delivery_charge);
        // $data['delivery_charge_actual_charge'] = trim($order_details->delivery_charge_actual_charge);
        $data['sub_total_discount_value'] = trim($order_details->sub_total_discount_value);
        $data['sub_total_discount_type'] = trim($order_details->sub_total_discount_type);
        $data['user_id'] = Sentinel::getUser()->id;
      
        if((int)$order_details->waiter_id!='0'):
        $data['waiter_id'] = trim($order_details->waiter_id);
        endif;
        $data['outlet_id'] = (int)Sentinel::getUser()->parent_id;
        $data['company_id'] = 1;
        // $data['sale_date'] = trim(isset($order_details->open_invoice_date_hidden) && $order_details->open_invoice_date_hidden?$order_details->open_invoice_date_hidden:date('Y-m-d'));
        $data['sale_date'] = date('Y-m-d');
        $data['date_time'] = date('Y-m-d H:i:s');
        $data['order_time'] = date("H:i:s");
        $data['order_status'] = trim($order_details->order_status);
        $today_ = date('Y-m-d');
        if($today_<$data['sale_date']){
            //1 is runny sale, 2 is future sales, 3 is future status null
            $data['future_sale_status'] = 2;
        }
      
        $total_tax = 0;
        if(isset($order_details->sale_vat_objects) && $order_details->sale_vat_objects){
            foreach ($order_details->sale_vat_objects as $keys=>$val){
                $total_tax+=$val->tax_field_amount;
            }
        }
        $data['gst'] = $total_tax;
        $data['sale_vat_objects'] = json_encode($order_details->sale_vat_objects);
        $data['order_type'] = trim($order_details->order_type);
        
        

        // $this->db->trans_begin();
        try
        {
     DB::beginTransaction();

        if($sale_id>0){
            $data['modified'] = 'Yes';
            FranchiseSale::where('id',$sale_id)->update($data);
           
            //this section sends notification to bar/kitchen panel if there is any modification
            $single_table_information = $this->get_all_information_of_a_sale($sale_id);
            $order_number = '';
            if($single_table_information->order_type==1){
                $order_number = 'A '.$single_table_information->sale_no;
            }else if($single_table_information->order_type==2){
                $order_number = 'B '.$single_table_information->sale_no;
            }else if($single_table_information->order_type==3){
                $order_number = 'C '.$single_table_information->sale_no;
            }
            $notification_message = 'Order:'.$order_number.' has been modified';
            $bar_kitchen_notification_data = array();
            $bar_kitchen_notification_data['notification'] = $notification_message;
            $bar_kitchen_notification_data['outlet_id'] = (int)Sentinel::getUser()->parent_id;

             $query=FranchiseNotificationBarKitchenPanel::create($bar_kitchen_notification_data);
           
            //end of send notification process
            FranchiseSalesDetails::where('sales_id',$sale_id)->delete();
            FranchiseSaleDetailsModifier::where('sales_id',$sale_id)->delete();
            FranchiseSaleConsuptions::where('sale_id',$sale_id)->delete();
            FranchiseSaleConsuptionsOfMenu::where('sales_id',$sale_id)->delete();
            FranchiseSaleConsuptionsOfModifiersOfMenu::where('sales_id',$sale_id)->delete();
           
            $sales_id = $sale_id;
            $sale_no = str_pad($sales_id, 6, '0', STR_PAD_LEFT);
        }else{
          

          $last_invoice_number=FranchiseSale::where('outlet_id',(int)Sentinel::getUser()->parent_id)->whereNotNull('invoice_number')->orderBy('invoice_number', 'desc')->first();
      
        if($last_invoice_number!=''):
          $last_id=$last_invoice_number->invoice_number;
         
          $new_id_no=(int)$last_id+1;
          $new_id=sprintf('%06d',$new_id_no);
        else:
            $last_total=FranchiseSale::where('outlet_id',(int)Sentinel::getUser()->parent_id)->get();
           $new=(int)count($last_total)+1; 
           $new_id=sprintf('%06d',$new);  
         endif;
            //
         $last_token_number=FranchiseSale::where('outlet_id',(int)Sentinel::getUser()->parent_id)->whereDate('created_at',Carbon::today())->whereNotNull('token_number')->orderBy('token_number', 'desc')->first();
      
        if($last_token_number!=''):
          $last_token_number=$last_token_number->token_number;
         
          $new_token_number=(int)$last_token_number+1;
          $new_token=sprintf('%03d',$new_token_number);
        else:
           $new_token=1; 
           $new_token=sprintf('%03d',$new_token);  
         endif;
    
            $data['invoice_number'] =$new_id;
            $data['token_number'] = $new_token;
            $sale_no=$new_id;
            $query=FranchiseSale::create($data);
            $sales_id =  $query->id;
            // $sale_no = str_pad($sales_id, 6, '0', STR_PAD_LEFT);
            $sale_no_update_array = array('sale_no' => $sale_no);
            FranchiseSale::where('id',$sales_id)->update($sale_no_update_array);
        }

        foreach($order_details->orders_table as $single_order_table){
            $order_table_info = array();
            $order_table_info['persons'] = $single_order_table->persons;
            $order_table_info['booking_time'] = date('Y-m-d H:i:s');
            $order_table_info['sale_id'] = $sales_id;
            $order_table_info['sale_no'] = $sale_no;
            $order_table_info['outlet_id'] = (int)Sentinel::getUser()->parent_id;
            $order_table_info['table_id'] = $single_order_table->table_id;
           
            PosOrderTables::create($order_table_info);
        }
        $consumptions_setting=OutletSetting::where('outlet_id','=',(int)Sentinel::getUser()->parent_id)->first(); 
        if($consumptions_setting!='' && $consumptions_setting->inventory_manage==1):
        $data_sale_consumptions = array();
        $data_sale_consumptions['sale_id'] = $sales_id;
        $data_sale_consumptions['user_id'] = Sentinel::getUser()->id;
        $data_sale_consumptions['outlet_id'] = (int)Sentinel::getUser()->parent_id;
        $data_sale_consumptions['del_status'] = 'Live';
        $query = FranchiseSaleConsuptions::create($data_sale_consumptions);
       
        $sale_consumption_id = $query->id;
         endif;


        if($sales_id>0 && count($order_details->items)>0){
            foreach($order_details->items as $item){
                $tmp_var_111 = isset($item->p_qty) && $item->p_qty && $item->p_qty!='undefined'?$item->p_qty:0;
                $tmp = $item->item_quantity-$tmp_var_111;
                $tmp_var = 0;
                if($tmp>0){
                    $tmp_var = $tmp;
                }

                $item_date = array();
                $item_data['food_menu_id'] = $item->item_id;
                $item_data['menu_name'] = $item->item_name;
                $item_data['qty'] = $item->item_quantity;
                // $item_data['tmp_qty'] = $tmp_var;
                $item_data['tmp_qty'] = $tmp_var;
                $item_data['menu_price_without_discount'] = $item->item_price_without_discount;
                $item_data['menu_price_with_discount'] = $item->item_price_with_discount;
                $item_data['menu_unit_price'] = $item->item_unit_price;
                $item_data['menu_taxes'] = json_encode($item->item_vat);
                $item_data['menu_discount_value'] = $item->item_discount;
                $item_data['discount_type'] = $item->discount_type;
                $item_data['menu_note'] = $item->item_note;
                $item_data['discount_amount'] = $item->item_discount_amount;
                $item_data['item_type'] ="Kitchen Item";
                $item_data['cooking_status'] = ($item->item_cooking_status=="")?NULL:$item->item_cooking_status;
                $item_data['cooking_start_time'] = ($item->item_cooking_start_time=="" || $item->item_cooking_start_time=="1970-01-01 00:00:00")?'1970-01-01 00:00:00':date('Y-m-d H:i:s',strtotime($item->item_cooking_start_time));
                $item_data['cooking_done_time'] = ($item->item_cooking_done_time=="" || $item->item_cooking_done_time=="1970-01-01 00:00:00")?'1970-01-01 00:00:00':date('Y-m-d H:i:s',strtotime($item->item_cooking_done_time));
                $item_data['previous_id'] = ($item->item_previous_id=="")?0:$item->item_previous_id;
                $item_data['sales_id'] = $sales_id;
                $item_data['user_id'] = Sentinel::getUser()->id;
                $item_data['outlet_id'] = (int)Sentinel::getUser()->parent_id;
                $item_data['del_status'] = 'Live';
                $query = FranchiseSalesDetails::create($item_data);
                $sales_details_id = $query->id; 
                
               
                if($item->item_previous_id==""){
                    $previous_id_update_array = array('previous_id' => $sales_details_id);
                   
                    FranchiseSalesDetails::where('id',$sales_details_id)->update($previous_id_update_array);
                }
           if($data['order_type']==1)
           {
$food_menu_ingredients=AssignFoodMenuIngredient::where('food_menu_id',$item->item_id)->whereIn('use_for',[1,2,6,7])->get();
           }
           elseif($data['order_type']==2)
           {
$food_menu_ingredients=AssignFoodMenuIngredient::where('food_menu_id',$item->item_id)->whereIn('use_for',[1,3,5,6])->get();
           }
           elseif($data['order_type']==3)
           {
$food_menu_ingredients=AssignFoodMenuIngredient::where('food_menu_id',$item->item_id)->whereIn('use_for',[1,4,5,7])->get();
           }
                
               
             if($consumptions_setting!='' && $consumptions_setting->inventory_manage==1):
                foreach($food_menu_ingredients as $single_ingredient){
                   
                    $data_sale_consumptions_detail = array();
                    $data_sale_consumptions_detail['ingredient_id'] = $single_ingredient->ingredient_code;
                    $data_sale_consumptions_detail['consumption'] = (float)$item->item_quantity*(float)$single_ingredient->consumption;
                    $data_sale_consumptions_detail['sale_consumption_id'] = $sale_consumption_id;
                    $data_sale_consumptions_detail['sales_id'] = $sales_id;
                    $data_sale_consumptions_detail['food_menu_id'] = $item->item_id;
                    $data_sale_consumptions_detail['user_id'] = Sentinel::getUser()->id;
                    $data_sale_consumptions_detail['outlet_id'] =(int)Sentinel::getUser()->parent_id;
                    $data_sale_consumptions_detail['del_status'] = 'Live';
                    $query = FranchiseSaleConsuptionsOfMenu::create($data_sale_consumptions_detail);
                   
                }
               endif;
                $modifier_id_array = ($item->modifiers_id!="")?explode(",",$item->modifiers_id):null;
                $modifier_price_array = ($item->modifiers_price!="")?explode(",",$item->modifiers_price):null;
                $modifier_vat_array = (isset($item->modifier_vat) && $item->modifier_vat!="")?explode("|||",$item->modifier_vat):null;
                if(!empty($modifier_id_array)>0){
                    $i = 0;
                    foreach($modifier_id_array as $key1=>$single_modifier_id){
                        $modifier_data = array();
                        $modifier_data['modifier_id'] =$single_modifier_id;
                        $modifier_data['modifier_price'] = $modifier_price_array[$i];
                        $modifier_data['food_menu_id'] = $item->item_id;
                        $modifier_data['sales_id'] = $sales_id;
                        $modifier_data['sales_details_id'] = $sales_details_id;
                        $modifier_data['menu_taxes'] = isset($modifier_vat_array[$key1]) && $modifier_vat_array[$key1]?$modifier_vat_array[$key1]:'';
                        $modifier_data['user_id'] = Sentinel::getUser()->id;
                        $modifier_data['outlet_id'] = (int)Sentinel::getUser()->parent_id;
                        $modifier_data['customer_id'] =$order_details->customer_id;

                        $query = FranchiseSaleDetailsModifier::create($modifier_data);

                        

                        // $modifier_ingredients = $this->db->query("SELECT * FROM tbl_modifier_ingredients WHERE modifier_id=$single_modifier_id")->result();

                        // foreach($modifier_ingredients as $single_ingredient){
                        //     $data_sale_consumptions_detail = array();
                        //     $data_sale_consumptions_detail['ingredient_id'] = $single_ingredient->ingredient_id;
                        //     $data_sale_consumptions_detail['consumption'] = $item->item_quantity*$single_ingredient->consumption;
                        //     $data_sale_consumptions_detail['sale_consumption_id'] = $sale_consumption_id;
                        //     $data_sale_consumptions_detail['sales_id'] = $sales_id;
                        //     $data_sale_consumptions_detail['food_menu_id'] = $item->item_id;
                        //     $data_sale_consumptions_detail['user_id'] = $this->session->userdata('user_id');
                        //     $data_sale_consumptions_detail['outlet_id'] = $this->session->userdata('outlet_id');
                        //     $data_sale_consumptions_detail['del_status'] = 'Live';
                        //     $query = $this->db->insert('tbl_sale_consumptions_of_modifiers_of_menus',$data_sale_consumptions_detail);
                        // }

                        $i++;
                    }
                }
            }
        }
       DB::commit();
        echo POS_SettingHelpers::escape_output($sales_id);
        }
        catch(Exception $e)
        {
            DB::rollBack();

        }
        // $this->db->trans_complete();
        // if ($this->db->trans_status() === FALSE) {
        //     $this->db->trans_rollback();
        // } else {
        //     echo escape_output($sales_id);
        //     $this->db->trans_commit();
        // }
       

    } 

     public function get_all_information_of_a_sale($sales_id){
        $sales_information = POS_SettingHelpers::getSaleBySaleId($sales_id);
         // dd($sales_information);
        $sales_information[0]->sub_total = POS_SettingHelpers::getAmtP(isset($sales_information[0]->sub_total) && $sales_information[0]->sub_total?$sales_information[0]->sub_total:0);
        $sales_information[0]->paid_amount = POS_SettingHelpers::getAmtP(isset($sales_information[0]->paid_amount) && $sales_information[0]->paid_amount?$sales_information[0]->paid_amount:0);
        $sales_information[0]->due_amount = POS_SettingHelpers::getAmtP(isset($sales_information[0]->due_amount) && $sales_information[0]->due_amount?$sales_information[0]->due_amount:0);
        $sales_information[0]->gst = POS_SettingHelpers::getAmtP(isset($sales_information[0]->gst) && $sales_information[0]->gst?$sales_information[0]->gst:0);
        $sales_information[0]->total_payable = POS_SettingHelpers::getAmtP(round(isset($sales_information[0]->total_payable) && $sales_information[0]->total_payable?$sales_information[0]->total_payable:0));
        $sales_information[0]->total_item_discount_amount = POS_SettingHelpers::getAmtP(isset($sales_information[0]->total_item_discount_amount) && $sales_information[0]->total_item_discount_amount?$sales_information[0]->total_item_discount_amount:0);
        $sales_information[0]->sub_total_with_discount = POS_SettingHelpers::getAmtP(isset($sales_information[0]->sub_total_with_discount) && $sales_information[0]->sub_total_with_discount?$sales_information[0]->sub_total_with_discount:0);
        $sales_information[0]->sub_total_discount_amount = POS_SettingHelpers::getAmtP(isset($sales_information[0]->sub_total_discount_amount) && $sales_information[0]->sub_total_discount_amount?$sales_information[0]->sub_total_discount_amount:0);
        $sales_information[0]->total_discount_amount = POS_SettingHelpers::getAmtP(isset($sales_information[0]->total_discount_amount) && $sales_information[0]->total_discount_amount?$sales_information[0]->total_discount_amount:0);
        $sales_information[0]->delivery_charge = (isset($sales_information[0]->delivery_charge) && $sales_information[0]->delivery_charge?$sales_information[0]->delivery_charge:0);
        $this_value = $sales_information[0]->sub_total_discount_value;
        $disc_fields = explode('%',$this_value);
        $discP = isset($disc_fields[1]) && $disc_fields[1]?$disc_fields[1]:'';
          if ($discP == "") {
          } else {
              $sales_information[0]->sub_total_discount_value = POS_SettingHelpers::getAmtP(isset($sales_information[0]->sub_total_discount_value) && $sales_information[0]->sub_total_discount_value?$sales_information[0]->sub_total_discount_value:0);
          }
        $items_by_sales_id =  POS_SettingHelpers::getAllItemsFromSalesDetailBySalesId($sales_id);

        foreach($items_by_sales_id as $single_item_by_sale_id){
            $modifier_information = POS_SettingHelpers::getModifiersBySaleAndSaleDetailsId($sales_id,$single_item_by_sale_id->sales_details_id);
            $single_item_by_sale_id->modifiers = $modifier_information;
        }
        $sales_details_objects = $items_by_sales_id;
        $sales_details_objects[0]->menu_price_without_discount = POS_SettingHelpers::getAmtP(isset($sales_details_objects[0]->menu_price_without_discount) && $sales_details_objects[0]->menu_price_without_discount?$sales_details_objects[0]->menu_price_without_discount:0);
        $sales_details_objects[0]->menu_price_with_discount = POS_SettingHelpers::getAmtP(isset($sales_details_objects[0]->menu_price_with_discount) && $sales_details_objects[0]->menu_price_with_discount?$sales_details_objects[0]->menu_price_with_discount:0);
        $sales_details_objects[0]->menu_unit_price = POS_SettingHelpers::getAmtP(isset($sales_details_objects[0]->menu_unit_price) && $sales_details_objects[0]->menu_unit_price?$sales_details_objects[0]->menu_unit_price:0);
        $sales_details_objects[0]->menu_vat_percentage = POS_SettingHelpers::getAmtP(isset($sales_details_objects[0]->menu_vat_percentage) && $sales_details_objects[0]->menu_vat_percentage?$sales_details_objects[0]->menu_vat_percentage:0);
        $sales_details_objects[0]->discount_amount = POS_SettingHelpers::getAmtP(isset($sales_details_objects[0]->discount_amount) && $sales_details_objects[0]->discount_amount?$sales_details_objects[0]->discount_amount:0);

        $this_value = $sales_details_objects[0]->menu_discount_value;
        $disc_fields = explode('%',$this_value);
        $discP = isset($disc_fields[1]) && $disc_fields[1]?$disc_fields[1]:'';
        if ($discP == "") {
        } else {
            $sales_details_objects[0]->menu_discount_value = POS_SettingHelpers::getAmtP(isset($sales_details_objects[0]->menu_discount_value) && $sales_information[0]->menu_discount_value?$sales_details_objects[0]->menu_discount_value:0);
        }

        $sale_object = $sales_information[0];
        $sale_object->items = $sales_details_objects;
        $sale_object->tables_booked =  POS_SettingHelpers::get_all_tables_of_a_sale_items($sales_id);
        return $sale_object;
    }
     public function get_all_information_of_a_sale_ajax(Request $request){
        $sales_id =$request->sale_id;;
        $sale_object = $this->get_all_information_of_a_sale($sales_id);
        echo json_encode($sale_object);
    }
     public function get_new_orders_ajax(){
        $data1 = $this->get_new_orders();

        echo json_encode($data1);
    }
    public function get_new_notifications_ajax()
    {
        echo json_encode($this->get_new_notification());
    }
    public function add_temp_kot_ajax(Request $request)
    {
         $order = json_decode($request->order);
     
        $data['temp_kot_info'] = $order;
        $data['outlet_id'] = (int)Sentinel::getUser()->parent_id;
        $query = FranchiseTempKot::create($data);
      echo POS_SettingHelpers::escape_output($query->id);
       
    }
      public function print_kot($sale_id){
        $data = $this->get_all_information_of_a_sale($sale_id);
        
         return view('outlet.pos.billing.print.print_kot_56mm',compact('data'));


     
    }

     public function print_temp_kot($temp_kot_id){

        $data['temp_kot_info'] =POS_SettingHelpers::get_temp_kot($temp_kot_id);
        FranchiseTempKot::where('id',$temp_kot_id)->delete();
       
        // $print_format = $this->session->userdata('print_format');
        if(isset($data['temp_kot_info']) && $data['temp_kot_info']){
            // if($print_format=="80mm"){
            //     $this->load->view('sale/print_kot_temp', $data);
            // }else{
            //     $this->load->view('sale/print_kot_temp_56mm', $data);
            // }
             return view('outlet.pos.billing.print.print_kot_temp_56mm',compact('data'));
             // $this->load->view('sale/print_kot_temp_56mm', $data);
        }else{
            echo lang('Please open from POS screen');
        }

    }
    public function remove_a_table_booking_ajax(Request $request)
    {
        $orders_table_id =$request->orders_table_id;
        $orders_table_single_info = POSCommonHelpers::getDataById($orders_table_id, "pos_order_tables");
        PosOrderTables::where('id',$orders_table_id)->delete();
      
        echo json_encode($orders_table_single_info);
    }
    public function get_new_hold_number_ajax(){
        $number_of_holds_of_this_user_and_outlet = $this->get_current_hold();
        $number_of_holds_of_this_user_and_outlet++;
        /*This variable could not be escaped because this is html content*/
        echo $number_of_holds_of_this_user_and_outlet;
    }
    public function get_current_hold(){
        $outlet_id = (int)Sentinel::getUser()->parent_id;
        $user_id = Sentinel::getUser()->id;
        $number_of_holds = POS_SettingHelpers::getNumberOfHoldsByUserAndOutletId($outlet_id,$user_id);

        return $number_of_holds;
    }
    public function add_hold_by_ajax(Request $request)
    {
       $order_details = json_decode(json_decode($request->order));
       
        $hold_number = trim($request->hold_number);
       
        $data = array();
        $data['customer_id'] = trim($order_details->customer_id);
        $data['total_items'] = trim($order_details->total_items_in_cart);
        $data['sub_total'] = trim($order_details->sub_total);
        $data['charge_type'] = trim($order_details->charge_type);
        $data['table_id'] = trim($order_details->selected_table);
        $data['total_payable'] = trim($order_details->total_payable);
        $data['total_item_discount_amount'] = trim($order_details->total_item_discount_amount);
        $data['sub_total_with_discount'] = trim($order_details->sub_total_with_discount);
        $data['sub_total_discount_amount'] = trim($order_details->sub_total_discount_amount);
        $data['total_discount_amount'] = trim($order_details->total_discount_amount);
        $data['delivery_charge'] = trim($order_details->delivery_charge);
        $data['sub_total_discount_value'] = trim($order_details->sub_total_discount_value);
        $data['sub_total_discount_type'] = trim($order_details->sub_total_discount_type);
        $data['user_id'] = Sentinel::getUser()->id;
        if($order_details->waiter_id!=''):
        $data['waiter_id'] = trim($order_details->waiter_id);
        endif;
        $data['outlet_id'] = (int)Sentinel::getUser()->parent_id;
        $data['sale_date'] = trim(isset($order_details->open_invoice_date_hidden) && $order_details->open_invoice_date_hidden?$order_details->open_invoice_date_hidden:date('Y-m-d'));
        $data['sale_time'] = date('Y-m-d h:i A');
        $data['order_status'] = trim($order_details->order_status);

        $total_tax = 0;
        if(isset($order_details->sale_vat_objects) && $order_details->sale_vat_objects){
            foreach ($order_details->sale_vat_objects as $keys=>$val){
                $total_tax+=$val->tax_field_amount;
            }
        }
        $data['gst'] = $total_tax;
        
        $data['sale_vat_objects'] = json_encode($order_details->sale_vat_objects);
        $data['order_type'] = trim($order_details->order_type);
        if($hold_number===0 || $hold_number===""){
            $current_hold_order = $this->get_current_hold();
            echo "current hold".$current_hold_order."<br/>";
            $hold_number = $current_hold_order+1;
        }
        $data['hold_no'] = $hold_number;
        $query =FranchiseTableHold::create($data);
        
        $holds_id=$query->id;
        if($holds_id>0 && count($order_details->items)>0){
            foreach($order_details->items as $item){
                $item_data = array();
                $item_data['food_menu_id'] = $item->item_id;
                $item_data['menu_name'] = $item->item_name;
                $item_data['qty'] = $item->item_quantity;
                $item_data['menu_price_without_discount'] = $item->item_price_without_discount;
                $item_data['menu_price_with_discount'] = $item->item_price_with_discount;
                $item_data['menu_unit_price'] = $item->item_unit_price;
                $item_data['menu_taxes'] = json_encode($item->item_vat);
                $item_data['menu_discount_value'] = $item->item_discount;
                $item_data['discount_type'] = $item->discount_type;
                $item_data['menu_note'] = $item->item_note;
                $item_data['discount_amount'] = $item->item_discount_amount;
                $item_data['holds_id'] = $holds_id;
                $item_data['user_id'] = Sentinel::getUser()->id;
                $item_data['outlet_id'] = (int)Sentinel::getUser()->parent_id;
                $item_data['del_status'] = 'Live';
                $query =FranchiseTableHoldDetails::create($item_data);
              
                $holds_details_id = $query->id;

                $modifier_id_array = ($item->modifiers_id!="")?explode(",",$item->modifiers_id):null;
                $modifier_price_array = ($item->modifiers_price!="")?explode(",",$item->modifiers_price):null;
                $modifier_vat_array = ($item->modifier_vat!="")?explode("|||",$item->modifier_vat):null;

                if(!empty($modifier_id_array)>0){
                    $i = 0;
                    foreach($modifier_id_array as $key1=>$single_modifier_id){
                        $modifier_data = array();
                        $modifier_data['modifier_id'] =$single_modifier_id;
                        $modifier_data['modifier_price'] = $modifier_price_array[$i];
                        $modifier_data['food_menu_id'] = $item->item_id;
                        $modifier_data['holds_id'] = $holds_id;
                        $modifier_data['holds_details_id'] = $holds_details_id;
                        $modifier_data['menu_taxes'] = isset($modifier_vat_array[$key1]) && $modifier_vat_array[$key1]?$modifier_vat_array[$key1]:'';
                        $modifier_data['user_id'] = Sentinel::getUser()->id;
                        $modifier_data['outlet_id'] = (int)Sentinel::getUser()->parent_id;
                        $modifier_data['customer_id'] =$order_details->customer_id;
                        $query =FranchiseTableHoldDetailsModifiers::create($modifier_data);
                      

                        $i++;
                    }
                }
            }
            foreach($order_details->orders_table as $single_order_table){
                $order_table_info = array();
                $order_table_info['persons'] = $single_order_table->persons;
                $order_table_info['booking_time'] = date('Y-m-d H:i:s');
                $order_table_info['hold_id'] = $holds_id;
                $order_table_info['hold_no'] = $hold_number;
                $order_table_info['outlet_id'] = (int)Sentinel::getUser()->parent_id;
                $order_table_info['table_id'] = $single_order_table->table_id;
                FranchiseHoldTable::create($order_table_info);
               
            }
        }

        echo POS_SettingHelpers::escape_output($holds_id);
    }
    public function get_all_holds_ajax(){
        $outlet_id = (int)Sentinel::getUser()->parent_id;
        $user_id = Sentinel::getUser()->id;
        $holds_information = POS_SettingHelpers::getHoldsByOutletAndUserId($outlet_id,$user_id);
        foreach($holds_information as $key=>$single_hold_information){
            $holds_information[$key]->tables_booked = POS_SettingHelpers::get_all_tables_of_a_hold_items($single_hold_information->id);
        }
        echo json_encode($holds_information);
    }
    public function get_single_hold_info_by_ajax(Request $request)
    {
        $hold_id =$request->hold_id;
        $hold_information = POS_SettingHelpers::get_hold_info_by_hold_id($hold_id);

        $items_by_holds_id = POS_SettingHelpers::getAllItemsFromHoldsDetailByHoldsId($hold_id);
        foreach($items_by_holds_id as $single_item_by_hold_id){
            $modifier_information = POS_SettingHelpers::getModifiersByHoldAndHoldsDetailsId($hold_id,$single_item_by_hold_id->holds_details_id);
            $single_item_by_hold_id->modifiers = $modifier_information;
        }
        $holds_details_objects = $items_by_holds_id;
        $hold_object = $hold_information[0];
        $hold_object->items = $holds_details_objects;
        $hold_object->tables_booked = json_encode(POS_SettingHelpers::get_all_tables_of_a_hold_items($hold_id));
        echo json_encode($hold_object);

    }
    public function delete_all_information_of_hold_by_ajax(Request $request)
    {
        $hold_id =$request->hold_id;
        FranchiseTableHold::where('id',$hold_id)->delete();
        FranchiseTableHoldDetails::where('holds_id',$hold_id)->delete();
        FranchiseTableHoldDetailsModifiers::where('holds_id',$hold_id)->delete();
       
    }
  public function delete_all_holds_with_information_by_ajax(Request $request)
    {
        $outlet_id = (int)Sentinel::getUser()->parent_id;
        $user_id =  Sentinel::getUser()->id;
        FranchiseTableHold::where([['user_id',$user_id],['outlet_id',$outlet_id]])->delete();
       FranchiseTableHoldDetails::where([['user_id',$user_id],['outlet_id',$outlet_id]])->delete();
       FranchiseTableHoldDetailsModifiers::where([['user_id',$user_id],['outlet_id', $outlet_id]])->delete();
      
        echo 1;
    }
    public function print_invoice($sale_id){
        
         $data['sale_object'] = $this->get_all_information_of_a_sale($sale_id);
         return view('outlet.pos.billing.print.print_invoice_56mm',compact('data'));

        // $print_format = $this->session->userdata('print_format');
        // if($print_format=="80mm"){
        //     $this->load->view('sale/print_invoice', $data);
        // }else{
        //     $this->load->view('sale/print_invoice_56mm', $data);
        // }
    }
      public function print_bill($sale_id){
       
        $data['sale_object'] = $this->get_all_information_of_a_sale($sale_id);
        // $print_format = $this->session->userdata('print_format');
        // if($print_format=="80mm"){
        //     $this->load->view('sale/print_bill',$data);
        // }else{
        //     $this->load->view('sale/print_bill_56mm',$data);
        // }
      return view('outlet.pos.billing.print.print_bill_56mm',compact('data'));
    }
    public function get_last_10_sales_ajax(){
        $outlet_id = (int)Sentinel::getUser()->parent_id;
        $sales_information = POS_SettingHelpers::getLastTenSalesByOutletAndUserId($outlet_id);
        foreach($sales_information as $single_sale_information){
            $single_sale_information->tables_booked = POS_SettingHelpers::get_all_tables_of_a_last_sale($single_sale_information->id);
        }
        echo json_encode($sales_information);
    }
    public function get_last_10_future_sales_ajax(){
        $outlet_id = (int)Sentinel::getUser()->parent_id;
        $sales_information = POS_SettingHelpers::future_sales($outlet_id);
        foreach($sales_information as $single_sale_information){
            $single_sale_information->tables_booked =POS_SettingHelpers::get_all_tables_of_a_last_sale($single_sale_information->id);
        }
        echo json_encode($sales_information);
    }
    public function update_order_status_ajax(Request $request)
    {
        $sale_id =$request->sale_id; 
        $close_order =$request->close_order; 
        $paid_amount =$request->paid_amount;  
        $due_amount =$request->due_amount;  
        $given_amount_input =$request->given_amount_input;  
        $change_amount_input =$request->change_amount_input;  
        $payment_method_type =$request->payment_method_type;  
        $is_just_cloase = ($payment_method_type=='0')? true:false;
        if($close_order=='true'){
            POS_SettingHelpers::delete_status_orders_table($sale_id);
            if($is_just_cloase){
                $order_status = array('order_status' => 3,'given_amount' => $given_amount_input,'change_amount' => $change_amount_input,'close_time'=>date('H:i:s'));
            }else{
                $order_status = array('paid_amount' =>  $paid_amount,'given_amount' => $given_amount_input,'change_amount' => $change_amount_input, 'due_amount' => $due_amount, 'order_status' => 3,'payment_method_id'=>$payment_method_type,'close_time'=>date('H:i:s'));
            }

        }else{
            $order_status = array('paid_amount' => $paid_amount,'given_amount' => $given_amount_input,'change_amount' => $change_amount_input,'due_amount' => $due_amount,'order_status' => 2,'payment_method_id'=>$payment_method_type);
        }
        FranchiseSale::where('id',$sale_id)->update($order_status);
        
        echo POS_SettingHelpers::escape_output($sale_id);
    }
   public function cancel_particular_order_ajax(Request $request)
    {
        $sale_id =$request->sale_id;
        $delete_remarks =$request->delete_remarks;
        $this->delete_specific_order_by_sale_id($sale_id,$delete_remarks);
        echo "success";
    }
    public function delete_specific_order_by_sale_id($sale_id,$delete_remarks){
        
       
        $order_status = array('cancel_remarks'=>$delete_remarks,'del_status' =>'Del','close_time'=>date('H:i:s'));
        // FranchiseSale::where('id',$sale_id)->delete();
        // FranchiseSalesDetails::where('sales_id',$sale_id)->delete();
        FranchiseSale::where('id',$sale_id)->update($order_status);
        FranchiseSaleDetailsModifier::where('sales_id',$sale_id)->delete();
        FranchiseSaleConsuptions::where('sale_id',$sale_id)->delete();
        FranchiseSaleConsuptionsOfMenu::where('sales_id',$sale_id)->delete();
        FranchiseSaleConsuptionsOfModifiersOfMenu::where('sales_id',$sale_id)->delete();
        PosOrderTables::where('sale_id',$sale_id)->delete();
       
        return true;
    }
   public function printSaleBillByAjax(Request $request){
        $sale_id = $request->sale_id;

        if($sale_id){
            $company_id = 1;
            $outlet_id = (int)Sentinel::getUser()->parent_id;
            $company = POS_SettingHelpers::get_outlet_details((int)Sentinel::getUser()->parent_id);
            $outlet = POS_SettingHelpers::get_outlet_details((int)Sentinel::getUser()->parent_id);
            $logo_path=CustomHelpers::logo_path(Sentinel::getUser()->parent_id);
              
                $data = array();
                $data['print_type'] = "bill";
                $data['logo'] = $logo_path;
                $data['store_name'] = $outlet->firm_name; ;
                $data['address'] = $outlet->address;
                $data['phone'] = $outlet->mobile;
                
                //printer config
                
            

                $sale = $this->get_all_information_of_a_sale($sale_id);
                $data['date'] = date('d-m-Y', strtotime($sale->sale_date));
                $data['time_inv'] = date('h:i A',strtotime($sale->order_time));
                $order_type = '';
                if($sale->order_type == 1){
                    $order_type = 'Dine In';
                }elseif($sale->order_type == 2){
                    $order_type = 'Take Away';
                }elseif($sale->order_type == 3){
                    $order_type = 'Delivery';
                }

                $data['sale_type'] = $order_type;

                $data['sales_associate'] = $sale->user_name;
                $data['customer_name'] = (isset($sale->customer_name) && $sale->customer_name?$sale->customer_name:'---');
                $data['phone'] = (isset($sale->phone) && $sale->phone?$sale->phone:'---');
                $data['customer_address'] = '';
                if($sale->customer_address!=NULL  && $sale->customer_address!=""){
                    $data['customer_address'] = (isset($sale->customer_address) && $sale->customer_address?$sale->customer_address:'---');
                }
                $data['waiter_name'] = '';
                if($sale->order_type=='1'){
                    $data['waiter_name']= $sale->waiter_name;
                }
                $data['customer_table'] = '';

                if($sale->tables_booked){
                    $html_table = '';
                    foreach ($sale->tables_booked as $key1=>$val){
                        $html_table.= POS_SettingHelpers::escape_output($val->table_name);
                        if($key1 < (sizeof($sale->tables_booked) -1)){
                            $html_table.= ", ";
                        }
                    }
                    $data['customer_table'] = $html_table;
                }


                $items = "\n";
                
                $count  = 1;
                $totalItems = 0;
                $sale = $this->get_all_information_of_a_sale($sale_id);

                foreach($sale->items as $r=>$value){
                    $totalItems++;
                    $menu_unit_price = POS_SettingHelpers::getAmtP($value->menu_unit_price);
                   
                    $count++;
                    if(count($value->modifiers)>0){
                        $items .= printText(("".lang('modifier').":"), $printer_tmp->characters_per_line)."\n";
                        $l = 1;
                        $modifier_price = 0;
                        foreach($value->modifiers as $modifier){
                            if($l==count($value->modifiers)){
                                $items .= printText((escape_output($modifier->name)), $printer_tmp->characters_per_line)."\n";
                            }else{
                                $items .= printText((escape_output($modifier->name).", "), $printer_tmp->characters_per_line)."\n";
                            }
                            $modifier_price+=$modifier->modifier_price;
                            $l++;
                        }
                        $items .= printLine("   ".lang('modifier')." ".lang('price'). ":  ". escape_output(getAmt($modifier_price)), $printer_tmp->characters_per_line, ' ')."\n";
                    }
                }
                $order_type = '';
                if($sale->order_type == 1){
                    $order_type = 'A';
                }elseif($sale->order_type == 2){
                    $order_type = 'B';
                }elseif($sale->order_type == 3){
                    $order_type = 'C';
                }
                $data['sale_no_p'] = $sale->sale_no;
                $data['date_format_p'] ='d-m-Y';
                $data['items'] = $items;
                $currency = 'Rs';
                $totals = "";
               
                

                $data['totals'] = $totals;
            
                    $return_data['content_data'] = $data;
                    echo json_encode($return_data);
                
          

        }


    }
   public function remove_multiple_notification_ajax(Request $request)
    {
        $notifications =$request->notifications;
        $notifications_array = explode(",",$notifications);
        foreach($notifications_array as $single_notification){
            FranchiseNotification::where('id',$single_notification)->delete();
           
        }
    }

}   
