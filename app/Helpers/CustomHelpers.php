<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Crypt;
use DB;
use Sentinel;
use App\Models\MasterGst;
use App\Models\SupplyItemList;
use App\Models\SupplyCart;
use App\Models\FirstTimeStockCart;
use App\Models\UtensilList;
use App\Models\FanchiseRegistration;
use App\Models\PageAccess;
use App\Models\Role;
use App\Models\User;
use App\Models\OrderPayment;
use App\Models\Brands;
use App\Models\OrderItemDetails;
use App\Models\MasterProduct;
use App\Models\PreLaunch;
use App\Models\FranchiseCreditHistory;
use App\Models\WharehouseOrderDetails;
use App\Models\FactoryOrderDetails;
use App\Models\FranchiseStockSalePrice;

class CustomHelpers 
{

 public static function get_ip()
  {
    // $ip=getHostByName(getHostName());
     $ip=$_SERVER['REMOTE_ADDR'];
    return $ip;
  }
  public static function distance_from_office($lat1, $lon1, $lat2, $lon2, $unit)
  {
    if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  }
  else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } 
   else if ($unit == "M") {
      return ($miles * 1.609344*1000);
    }
    else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }

  }
  public static function get_month($month_no)
  {
    if($month_no=='01')
    {
   return 'January';
    }
    elseif($month_no=='02')
    {
 return 'February';
    }
     elseif($month_no=='03')
    {
 return 'March';
    }
     elseif($month_no=='04')
    {
 return 'April';
    }
     elseif($month_no=='05')
    {
 return 'May';
    }
     elseif($month_no=='06')
    {
 return 'June';
    }
     elseif($month_no=='07')
    {
 return 'July';
    }
     elseif($month_no=='08')
    {
 return 'August';
    }
     elseif($month_no=='09')
    {
 return 'September';
    }
     elseif($month_no=='10')
    {
 return 'October';
    }
     elseif($month_no=='11')
    {
 return 'November';
    }
     elseif($month_no=='12')
    {
 return 'December';
    }
  }
  public static function get_page_access_data($user_id,$return)
  {
      $role=DB::table('role_users')->where('user_id','=',$user_id)->first();

      $role_id=$role->role_id;
      $page_acess=PageAccess::where('role_id','=',$role_id)->first();
       
       if($page_acess!=''):
        //
      if($return=='fanchise_menu'):
       if($page_acess->new_registration==1 || $page_acess->prelaunch_date==1 || $page_acess->fanchise_data==1 || $page_acess->architect==1 || $page_acess->social==1 || $page_acess->procurement==1 || $page_acess->operations==1 || $page_acess->accounts==1):
         return 1;
       else:
        return 0;
      endif;
    elseif($return=='billing'):
       if($page_acess->billing==1):
         return 1;
       else:
        return 0;
      endif;
    elseif($return=='master_product'):
        if($page_acess->master_product==1):
         return 1;
       else:
        return 0;
      endif;
    elseif($return=='setting'):
      if($page_acess->setting==1):
         return 1;
       else:
        return 0;
      endif;
       elseif($return=='view_franchise_details'):
      if($page_acess->view_franchise_details==1):
         return 1;
       else:
        return 0;
      endif;

      elseif($return=='area_manager_work'):
      if($page_acess->area_manager_work==1):
         return 1;
       else:
        return 0;
      endif;

      
      endif;


      //
    else:
      return 0;
    endif;
  }
  public static function get_outlet_products($outlet_id)
  {
   $registered_fanchise=FanchiseRegistration::where('fanchise_id','=',$outlet_id)->first();

       // $data = DB::table('brand_wise_products')
       //      ->join('master_products', 'master_products.id', '=', 'brand_wise_products.product_id')
       //      ->where([['brand_wise_products.brand_id','=',(int)$registered_fanchise->brands],['master_products.supply_for','=',1]])
       //      ->select('master_products.*', 'brand_wise_products.initial_qty', 'brand_wise_products.brand_id')
       //      ->get();
   $data = DB::table('master_products')
           
            ->where('outlet_id',$outlet_id)
            ->select('master_products.*')
            ->get();
        return $data;
  }
  public static function get_update_outlet_stock($outlet_id)
  {
   $data_ings=CustomHelpers::get_outlet_products($outlet_id);
         
         foreach($data_ings as $datas):
            $check_stock=FranchiseStockSalePrice::where([['outlet_id','=',(int)$outlet_id],['product_id','=',(int)$datas->id]])->first();
            if($check_stock==''):
     $stock=new FranchiseStockSalePrice;
     $stock->outlet_id=(int)$outlet_id;
     $stock->product_id=(int)$datas->id;
     $stock->threshold_qty=$datas->threshold_qty;
     $available_qty_data=DB::table('first_time_stock_carts')->where([['list_id','=',$datas->id],['fanchise_id','=',$outlet_id]])->first();
     if($available_qty_data!=''):
$stock->available_qty=$available_qty_data->qty;
     else:
$stock->available_qty=0;
     endif;
  
     $stock->status=1;
     $stock->save();
       endif;
         endforeach;

     $stocks_data=FranchiseStockSalePrice::where('outlet_id','=',(int)$outlet_id)->get();
     foreach($stocks_data as $stock_check)
     {
      $product_id=$stock_check->product_id;
      $product=MasterProduct::find($product_id);
      if($product=='')
      {
        FranchiseStockSalePrice::destroy($stock_check->id);
      }
     }

  }
 public static function get_page_access_data_without_new_registration($user_id,$return)
  {
      $role=DB::table('role_users')->where('user_id','=',$user_id)->first();
      $role_id=$role->role_id;
      $page_acess=PageAccess::where('role_id','=',$role_id)->first();
       
       if($page_acess!=''):
        //
      if($return=='new_work_menu'):
       if($page_acess->new_registration==0 && ($page_acess->prelaunch_date==1 || $page_acess->fanchise_data==1 || $page_acess->architect==1 || $page_acess->social==1 || $page_acess->procurement==1 || $page_acess->operations==1 || $page_acess->accounts==1)):
         return 1;
       else:
        return 0;
      endif;
      endif;
      //
    else:
      return 0;
    endif;
  }
  public static function custom_encrypt($string, $key=101)
  {
   $result = '';
    for($i=0, $k= strlen($string); $i<$k; $i++) {
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)+ord($keychar));
    $result .= $char;
  }
  return base64_encode($result);
  } 
   public static function custom_decrypt($string, $key=101)
  {
    $result = '';
  $string = base64_decode($string);
  for($i=0,$k=strlen($string); $i< $k ; $i++) {
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)-ord($keychar));
    $result.=$char;
  }
  return $result;
  }
  public static function mask_mobile_no($number)
   {
    if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'view_franchise_details')==1):
return $number;
    else:
return substr($number, 0, 2) . '******' . substr($number, -2);
    endif;

    
   }
  public static  function partiallyHideEmail($email)
   {
    if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'view_franchise_details')==1):
    return $email;
    else:
    $em   = explode("@",$email);
    $name = implode('@', array_slice($em, 0, count($em)-1));
    $len  = floor(strlen($name)/2);
    return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em); 
    endif;
     
    }
  public static  function partiallyaddress($address)
   {
    if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'view_franchise_details')==1):
    return $address;
    else:
  
    return 'NA'; 
    endif;
     
    }
 public static function callAPI($method, $url, $data){
   $curl = curl_init();

   switch ($method){
      case "POST":
curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }

   // OPTIONS:
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
   ));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
curl_close($curl);
   return $result;
} 

  public static function get_first_time_cart_data($fanchise_id,$item_id,$return)
  {
   $data=FirstTimeStockCart::where([['fanchise_id','=',$fanchise_id],['list_id','=',$item_id],['payment_status','=',0]])->first();
   return $data->$return;
  }
  public static function get_list_data($id,$return)
  {
   $data=MasterProduct::find($id);
   if($data!='')
   {
    return $data->$return;
   }
   else
   {
    return 'NA';
   }
   
  }
   public static function get_first_stock_amount($id,$purchase_from)
  {
  $cart_datas=FirstTimeStockCart::where([['fanchise_id','=',$id],['payment_status','=',0],['qty','>',0],['purchase_from','=',$purchase_from]])->get();  
   
   $total=0;
   foreach($cart_datas as $cart_data):
  $total=$total+(float)$cart_data->amount;
   endforeach;
   return round($total);
  }
  public static function get_amount($id,$return)
  {
   $data=FanchiseRegistration::find($id);
   $installment_amount=0;
   $advance=$data->advance;
   if($advance!=''):
   $installment_amount=$installment_amount+$advance;
   endif;
   $first_installment=$data->first_installment;
   if($first_installment!=''):
   $installment_amount=$installment_amount+$first_installment;
   endif;
   $seoond_installment=$data->seoond_installment;
   if($seoond_installment!=''):
   $installment_amount=$installment_amount+$seoond_installment;
   endif;
   $third_installment=$data->third_installment;
   if($third_installment!=''):
   $installment_amount=$installment_amount+$third_installment;
   endif;
   
   $total_fee_amount=$data->balance_amount;


   $reveived_amount=0;
   $advance_reveived=$data->advance_received;
    if($advance_reveived!=''):
   $reveived_amount=$reveived_amount+$advance_reveived;
   endif;
   $first_installment_reveived=$data->first_installment_received;
   if($first_installment_reveived!=''):
   $reveived_amount=$reveived_amount+$first_installment_reveived;
   endif;
   $seoond_installment_reveived=$data->second_installment_received;
   if($seoond_installment_reveived!=''):
   $reveived_amount=$reveived_amount+$seoond_installment_reveived;
   endif;
   $third_installment_reveived=$data->third_installment_received;
   if($third_installment_reveived!=''):
   $reveived_amount=$reveived_amount+$third_installment_reveived;
   endif;
   if($return=='installment'):
    return $installment_amount;
   elseif($return=='received'):
    return $reveived_amount;
   elseif($return=='balance'):
   return $total_fee_amount-$reveived_amount;
   endif;


   
  }
 
  public static function get_rate_with_gst($item_id)
  {
  $data=MasterProduct::find($item_id);

  if($data!='')
  {
 $rate=$data->franchise_rate;
 $gst_data=MasterGst::find($data->gst_id);
 if($gst_data!='')
{
  $gst_percentage=$gst_data->gst_value;
  $rate=(float)$rate+((float)$rate*$gst_percentage/100);
}
// $sentinel_user=Sentinel::getUser();
// $state=$sentinel_user->state;
// $dist=$sentinel_user->dist;
// $city=$sentinel_user->city;
// $unit_id=$data->unit;
// $tranport_charge=CustomHelpers::get_transport_fee($state,$dist,$city,$unit_id);

// $rate=(float)$rate+(float)$tranport_charge;

return round($rate,2);
  }
   
  }
  public static function get_transport_fee($user_id,$unit_id)
  {
    $sentinel_user=Sentinel::findById($user_id);
    $state=$sentinel_user->state;
    $dist=$sentinel_user->dist;
    $city=$sentinel_user->city;
    $unit_id=$unit_id;


  $transport_data=DB::table('transport_charges')->where([['state','=',$state],['dist','=',$dist],['city','=',$city],['unit','=',$unit_id]])->first();
      if($transport_data!='')
      {
      $transport_fee=$transport_data->fee;
      $gst_data=MasterGst::find($transport_data->gst_id);
       if($gst_data!='')
      {
        $gst_percentage=$gst_data->gst_value;
        $transport_fee=$transport_fee+($transport_fee*$gst_percentage/100);
      }
          return round($transport_fee,2);
      }
      else
      {
         return 0;
      }
  }
   
   public static function get_rate_with_gst_first_stock($item_id)

  {
  $data=MasterProduct::find($item_id);

  if($data!='')
  {
 $rate=$data->franchise_rate;
 $gst_data=MasterGst::find($data->gst_id);
 if($gst_data!='' && $rate!='')
{
  $gst_percentage=$gst_data->gst_value;
  $rate=(float)$rate+((float)$rate*(float)$gst_percentage/100);
}
return $rate;
  }
   
  }
 
 public static function get_product_data($item_id,$return)
  {
  $data=MasterProduct::find($item_id);

   return $data->$return;
   
  }
  public static function get_item_subtotal_with_gst($id)
  {
$cart_data=SupplyCart::find($id);
$qty=$cart_data->qty;
$rate=CustomHelpers::get_rate_with_gst($cart_data->item_id);
$total=$rate*$qty;
return round($total,2);

  }
    public static function get_item_subtotal_with_gst_with_transport($id)
  {
$cart_data=SupplyCart::find($id);
$qty=$cart_data->qty;
$rate=CustomHelpers::get_rate_with_gst($cart_data->item_id);
$total=(float)$rate*(float)$qty;

$transport_fee=CustomHelpers::get_transport_fee($cart_data->fanchise_id,CustomHelpers::get_product_data($cart_data->item_id,"unit"));
$total_transport_fee=$transport_fee*$qty;
$grand_total=$total+$total_transport_fee;


return round($grand_total,2);

  }

   public static function get_all_item_subtotal_with_gst()
  {
$cart_datas=SupplyCart::where('fanchise_id','=',Sentinel::getUser()->id)->get();
$output=0;
foreach($cart_datas as $cart_data)
{
// $qty=$cart_data->qty;
// $rate=CustomHelpers::get_rate_with_gst($cart_data->item_id);
// $total=$rate*$qty;
// $output+=$total;

$output+=CustomHelpers::get_item_subtotal_with_gst_with_transport($cart_data->id);

}


return round($output);

  }
  public static function get_page_access($role_id,$page)
  {
   $data=DB::table('page_accesses')->where('role_id','=',$role_id)->first();
   if($data!=''):
    return $data->$page;
   else:
    return 0;
   endif;
  }
  public static function get_user_data($id,$return)
  {
  $data=User::find($id);
  return $data->$return;
  }
   public static function get_order_dispatched_notification($fanchise_id)
  {

$data = OrderItemDetails::where('fanchise_id',$fanchise_id)->whereIn('status',[2,4,6])->get();
return count($data);
  }
public static function get_order_dispatched_notification_order_wise($order_id)
  {

$data = OrderItemDetails::where('order_id',$order_id)->whereIn('status',[2,4,6])->get();
return count($data);
  }
  public static function get_order_placed_count($order_id)
  {

$data = OrderItemDetails::where('order_id',$order_id)->get();
return count($data);
  }
  public static function get_order_dilivered_count($order_id)
  {

$data = OrderItemDetails::where('order_id',$order_id)->whereIn('status',[7])->get();
return count($data);
  }
  
  public static function get_order_payment_notification()
  {
$data = OrderPayment::where([['status','=',0],['payment_status','=',1]])->get();
return count($data);
  }

  public static function logo_path($parent_id)
  {
    if($parent_id==1):
   $image_path=url('public/uploads/logo/right.png');

   return $image_path;
    else:
   // $data=FanchiseRegistration::where('fanchise_id','=',$parent_id)->first();
   // $brand_id=$data->brands;
   // $brand_data=Brands::find($brand_id);
   // $image_path=url('public/uploads/logo/'.$brand_data->brand_logo);
  $image_path=url('public/uploads/logo/right.png');
   return $image_path;
    endif;
  

  }
  public static function get_brand_name($id)
  {
    $brand_data=Brands::find($id);
    return $brand_data->brand;
  }
  public static function get_table_data($table,$id,$return)
  {
    $data=DB::table($table)->where('id','=',$id)->first();
    return $data->$return;
  }
   public static function get_master_table_data($table,$where,$id,$return)
  {
    $data=DB::table($table)->where($where,'=',$id)->first();
    if($data!='')
    {
      return $data->$return;
    }
    else
    {
      return 'NA';
    }
    
  }
  public static function get_factory_vendor_data($factory_vendor_id,$type)
  {
    $data=DB::table('assign_product_factory_vendors')->where([['factory_vendor_id','=',$factory_vendor_id],['type','=',$type]])->get();
    return $data;
  }
  public static function get_wharehouse_count($type)
  {
  
 

  }
  public static function get_step_complete_count($id,$return)
  {
    $architect_done=0;
    $architect_total=19;
    $social_media_done=0;
    $social_media_total=12;
    $operations_done=0;
    $operations_total=18;
    $accounts_done=0;
    $accounts_total=3;
    

    $data=PreLaunch::where('fanchise_id','=',$id)->first();
    if($data!=''):
    if($data->layouts=='Yes'):
    $architect_done=$architect_done+1;
    endif;
    if($data->interior=='Yes'):
    $architect_done=$architect_done+1;
    endif;
    if($data->wall_design=='Yes'):
    $architect_done=$architect_done+1;
    endif;
     if($data->coming_soon_banner_installation=='Yes'):
    $architect_done=$architect_done+1;
    endif;
     if($data->furnitures=='Yes'):
    $architect_done=$architect_done+1;
    endif;
     if($data->false_ceiling_work=='Yes'):
    $architect_done=$architect_done+1;
    endif;
     if($data->electricity=='Yes'):
    $architect_done=$architect_done+1;
    endif;
     if($data->water_drainage=='Yes'):
    $architect_done=$architect_done+1;
    endif;
     if($data->ac=='Yes'):
    $architect_done=$architect_done+1;
    endif;
     if($data->music_system=='Yes'):
    $architect_done=$architect_done+1;
    endif;
     if($data->wifi=='Yes'):
    $architect_done=$architect_done+1;
    endif;
     if($data->cctv=='Yes'):
    $architect_done=$architect_done+1;
    endif;
     if($data->gas_bank=='Yes'):
    $architect_done=$architect_done+1;
    endif;
    if($data->kitchen=='Yes'):
    $architect_done=$architect_done+1;
    endif;
    if($data->menu_display=='Yes'):
    $architect_done=$architect_done+1;
    endif;
    if($data->coke_cooler=='Yes'):
    $architect_done=$architect_done+1;
    endif;
    if($data->fire_extinguisher=='Yes'):
    $architect_done=$architect_done+1;
    endif;
    if($data->signage_board=='Yes'):
    $architect_done=$architect_done+1;
    endif;
    if($data->certificate_display=='Yes'):
    $architect_done=$architect_done+1;
    endif;
    //
    if($data->official_mail=='Yes'):
    $social_media_done=$social_media_done+1;
    endif;
    if($data->google_listing=='Yes'):
    $social_media_done=$social_media_done+1;
    endif;
    if($data->fbpage=='Yes'):
    $social_media_done=$social_media_done+1;
    endif;
    if($data->instapage=='Yes'):
    $social_media_done=$social_media_done+1;
    endif;
    if($data->menu_dine_in=='Yes'):
    $social_media_done=$social_media_done+1;
    endif;
    if($data->menu_online=='Yes'):
    $social_media_done=$social_media_done+1;
    endif;
    if($data->coming_soon_banner_status=='Yes'):
    $social_media_done=$social_media_done+1;
    endif;
    if($data->npi=='Yes'):
    $social_media_done=$social_media_done+1;
    endif;
    if($data->hoarding=='Yes'):
    $social_media_done=$social_media_done+1;
    endif;
    if($data->banner=='Yes'):
    $social_media_done=$social_media_done+1;
    endif;
    if($data->newspaper=='Yes'):
    $social_media_done=$social_media_done+1;
    endif;
    if($data->foodshots=='Yes'):
    $social_media_done=$social_media_done+1;
    endif;
    //
     if($data->agreement=='Yes'):
    $operations_done=$operations_done+1;
    endif;
     if($data->gst_ops=='Yes'):
    $operations_done=$operations_done+1;
    endif;
     if($data->zomato=='Yes' || $data->zomato=='NA'):
    $operations_done=$operations_done+1;
    endif;
     if($data->swiggy=='Yes' || $data->swiggy=='NA'):
    $operations_done=$operations_done+1;
    endif;
    if($data->local_food=='Yes' || $data->local_food=='NA'):
    $operations_done=$operations_done+1;
    endif;
    if($data->man_power_mou=='Yes'):
    $operations_done=$operations_done+1;
    endif;
    if($data->billing_software=='Yes'):
    $operations_done=$operations_done+1;
    endif;
    if($data->edc_machine=='Yes'):
    $operations_done=$operations_done+1;
    endif;
    if($data->cctv_access=='Yes'):
    $operations_done=$operations_done+1;
    endif;
    if($data->sops=='Yes'):
    $operations_done=$operations_done+1;
    endif;
    if($data->chef_travel_plan=='Yes'):
    $operations_done=$operations_done+1;
    endif;
    if($data->dry_run=='Yes'):
    $operations_done=$operations_done+1;
    endif;
     if($data->cutlery=='Yes'):
    $operations_done=$operations_done+1;
    endif;
    if($data->uniforms=='Yes'):
    $operations_done=$operations_done+1;
    endif;
    if($data->central_supply=='Yes'):
    $operations_done=$operations_done+1;
    endif;
    if($data->temple=='Yes'):
    $operations_done=$operations_done+1;
    endif;

    if($data->man_power=='Yes'):
    $operations_done=$operations_done+1;
    endif;
    if($data->local_purchase=='Yes'):
    $operations_done=$operations_done+1;
    endif; 
     //
    if($data->no_dues=='Yes'):
    $accounts_done=$accounts_done+1;
    endif;
    if($data->royalty_pdc==2):
    $accounts_done=$accounts_done+1;
    endif;
     if($data->agreementstatus==2):
    $accounts_done=$accounts_done+1;
    endif;

   
     
    
    $architect_pending=$architect_total-$architect_done; 
    $social_media_pending=$social_media_total-$social_media_done; 
    $operations_pending=$operations_total-$operations_done; 
    $accounts_pending=$accounts_total-$accounts_done; 
   else:
    $architect_pending=$architect_total; 
    $social_media_pending=$social_media_total; 
    $operations_pending=$operations_total; 
    $accounts_pending=$accounts_total; 
   endif;
    
    if($return=='architect_done'):
    return $architect_done;
    elseif($return=='architect_pending'):
      return $architect_pending;
    elseif($return=='social_media_pending'):
      return $social_media_pending;

    elseif($return=='social_media_done'):
      return $social_media_done;

        elseif($return=='operations_pending'):
      return $operations_pending;

    elseif($return=='operations_done'):
      return $operations_done;

      elseif($return=='accounts_pending'):
      return $accounts_pending;

      elseif($return=='accounts_done'):
      return $accounts_done;

    elseif($return=='procurement_pending'):
      $registration_data=FanchiseRegistration::where('fanchise_id','=',$id)->first();
      if($registration_data->procurement_status=='' || $registration_data->procurement_status==0):
      return 4;
     elseif($registration_data->procurement_status==1):
      return 3;
      elseif($registration_data->procurement_status==2):
      return 2;
     elseif($registration_data->procurement_status==3):
      return 1;
       elseif($registration_data->procurement_status==4):
      return 0;
      endif;
      

    elseif($return=='procurement_done'):
       $registration_data=FanchiseRegistration::where('fanchise_id','=',$id)->first();
      if($registration_data->procurement_status=='' || $registration_data->procurement_status==0):
      return 0;
     elseif($registration_data->procurement_status==1):
      return 1;
      elseif($registration_data->procurement_status==2):
      return 2;
     elseif($registration_data->procurement_status==3):
      return 3;
       elseif($registration_data->procurement_status==4):
      return 4;
      endif;
      //
     //    elseif($return=='accounts_pending'):
     //  $registration_data=FanchiseRegistration::where('fanchise_id','=',$id)->first();
     //  if($registration_data->accounts_status=='' || $registration_data->accounts_status==0):
     //  return 1;
     // elseif($registration_data->accounts_status==1):
     //  return 0;
      
     //  endif;
      

    // elseif($return=='accounts_done'):
    //    $registration_data=FanchiseRegistration::where('fanchise_id','=',$id)->first();
    //     if($registration_data->accounts_status=='' || $registration_data->accounts_status==0):
    //   return 0;
    //  elseif($registration_data->accounts_status==1):
    //   return 1;
    //   endif;
       //
        elseif($return=='agreementstatus_pending'):
      $registration_data=FanchiseRegistration::where('fanchise_id','=',$id)->first();
      if($registration_data->agreementstatus=='' || $registration_data->agreementstatus==0):
      return 2;
     elseif($registration_data->agreementstatus==1):
      return 1;
       elseif($registration_data->agreementstatus==2):
      return 0;
      endif;
      

    elseif($return=='agreementstatus_done'):
       $registration_data=FanchiseRegistration::where('fanchise_id','=',$id)->first();
      if($registration_data->agreementstatus=='' || $registration_data->agreementstatus==0):
      return 0;
     elseif($registration_data->agreementstatus==1):
      return 1;
       elseif($registration_data->agreementstatus==2):
      return 2;
      endif;
       //
        elseif($return=='local_purchase_pending'):
      $registration_data=FanchiseRegistration::where('fanchise_id','=',$id)->first();
      if($registration_data->local_purchase_status==0 || $registration_data->local_purchase_status==2):
      return 1;
     
       elseif($registration_data->local_purchase_status==1):
      return 0;
      endif;
      

    elseif($return=='local_purchase_done'):
       $registration_data=FanchiseRegistration::where('fanchise_id','=',$id)->first();
      if($registration_data->local_purchase_status==0 || $registration_data->local_purchase_status==2):
      return 0;
     
       elseif($registration_data->local_purchase_status==1):
      return 1;
      endif;
      //

    endif;
    
  }
  public static function get_franchise_previous_credit_bal($id)
  {
     
   $data=FranchiseCreditHistory::where('franchise_id','=',$id)->orderBy('id','DESC')->first();
   if($data!=''):
    if($data->remaining_bal==''):
      $bal=0;
    else:
      $bal=$data->remaining_bal;
    endif;
   $bal=$data->remaining_bal;
   else:
    $bal=0;
   endif;
     return $bal;
  }
  
  public static function get_return_item_subtotal($id,$qty)
  {
$order_data=OrderItemDetails::where('fanchise_id','=',$id)->first();

$rate=$order_data->product_rate;

 $gst_data=MasterGst::find($order_data->gst_id);
 if($gst_data!='')
{
  $gst_percentage=$gst_data->gst_value;
  $rate=(float)$rate+((float)$rate*$gst_percentage/100);
}

$transport_rate=(float)$order_data->transport_rate;
$grand_total=$qty*($rate+$transport_rate);


return round($grand_total,2);

  }
  public static function get_wharehouse_order_status_count($id,$return)
  {
    if($return=='ordered_item'):
$data=WharehouseOrderDetails::where('wharehouse_order_id','=',$id)->get();
    elseif($return=='replied_to_ac'):
$data=WharehouseOrderDetails::where([['wharehouse_order_id','=',$id],['status','=',4]])->get();
    elseif($return=='view_accept_pending'):
$data=WharehouseOrderDetails::where([['wharehouse_order_id','=',$id],['status','=',5]])->get();
    elseif($return=='accepted'):

$data=WharehouseOrderDetails::where([['wharehouse_order_id','=',$id],['status','=',6]])->get();
    elseif($return=='dispatch'):
$data=WharehouseOrderDetails::where([['wharehouse_order_id','=',$id],['status','=',2]])->get();

    elseif($return=='delivered'):
$data=WharehouseOrderDetails::where([['wharehouse_order_id','=',$id],['status','=',3]])->get();
 elseif($return=='action_pending'):
$data=WharehouseOrderDetails::where([['wharehouse_order_id','=',$id],['status','=',1]])->get();
elseif($return=='action_pending_account'):
$data=WharehouseOrderDetails::where([['wharehouse_order_id','=',$id],['status','=',0]])->get();
    endif;


return count($data);

  }
  public static function get_factory_order_status_count($id,$return)
  {
    if($return=='ordered_item'):
$data=FactoryOrderDetails::where('factory_order_id','=',$id)->get();
    elseif($return=='replied_to_ac'):
$data=FactoryOrderDetails::where([['factory_order_id','=',$id],['status','=',4]])->get();
    elseif($return=='view_accept_pending'):
$data=FactoryOrderDetails::where([['factory_order_id','=',$id],['status','=',5]])->get();
    elseif($return=='accepted'):

$data=FactoryOrderDetails::where([['factory_order_id','=',$id],['status','=',6]])->get();
    elseif($return=='dispatch'):
$data=FactoryOrderDetails::where([['factory_order_id','=',$id],['status','=',2]])->get();

    elseif($return=='delivered'):
$data=FactoryOrderDetails::where([['factory_order_id','=',$id],['status','=',3]])->get();
 elseif($return=='action_pending'):
$data=FactoryOrderDetails::where([['factory_order_id','=',$id],['status','=',1]])->get();
elseif($return=='action_pending_account'):
$data=FactoryOrderDetails::where([['factory_order_id','=',$id],['status','=',0]])->get();
    endif;


return count($data);

  }
}