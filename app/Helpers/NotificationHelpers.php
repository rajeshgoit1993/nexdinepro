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
use App\Models\WharehouseOrder;
use App\Models\WharehouseOrderDetails;
use App\Models\FactoryOrder;
use App\Models\FactoryOrderDetails;
use App\Models\DailyPurchase;
use App\Models\RegionSetting;
use App\Models\RegionWiseOutlet;
use App\Models\PhysicalEntry;
class NotificationHelpers 
{


  public static function get_outlet_purchase_notification($val)
  {
    $outlet_id =Sentinel::getUser()->parent_id;
    $data = DailyPurchase::where([['outlet_id','=',(int)$outlet_id],['status',$val]])->latest()->get();
    return count($data);  
   }
   public static function get_outlet_physical_entry_notification_area_manager()
  {
    $id =Sentinel::getUser()->id;
   $region_ids=RegionSetting::where('assign_area_manager',$id)->pluck('id');
   $outlet_ids=RegionWiseOutlet::whereIn('region_id',$region_ids)->pluck('outlet_id');
   $data = PhysicalEntry::where('area_manager_approval',0)->whereIn('outlet_id',$outlet_ids)->latest()->get()->groupBy('outlet_id');
    return count($data);  
   }
 public static function get_outlet_purchase_notification_area_manager($val)
  {
    $id =Sentinel::getUser()->id;
        $region_ids=RegionSetting::where('assign_area_manager',$id)->pluck('id');
        $outlet_ids=RegionWiseOutlet::whereIn('region_id',$region_ids)->pluck('outlet_id');
       
            $data = DailyPurchase::where('status',$val)->whereIn('outlet_id',$outlet_ids)->latest()->get();
    return count($data);  
   }
  public static function get_wherehouse_new_order_notification()
  {

    if(Sentinel::getUser()->inRole('superadmin')):
     
    $data = OrderPayment::where([['payment_status','=',1],['status','=',1]])->get();
     else:
     $user_id=Sentinel::getUser()->id;
     $store_check=DB::table('store_assign_users')->where([['user_id','=',$user_id],['type','=',1]])->pluck('store_id');
     $data = OrderPayment::where([['payment_status','=',1],['status','=',1]])->whereIn('assign_order_to_warehouse_id',$store_check)->get();
     endif;
     return count($data);
   }

  public static function get_factory_new_order_notification()
  {

    if(Sentinel::getUser()->inRole('superadmin')):
     
    $data = OrderItemDetails::where('status','=',3)->get();
     else:
     $user_id=Sentinel::getUser()->id;
     $store_check=DB::table('store_assign_users')->where([['user_id','=',$user_id],['type','=',2]])->pluck('store_id');
     $data = OrderItemDetails::where('status','=',3)->whereIn('factory_vendor_id',$store_check)->get();
     endif;
     return count($data);
   }
 public static function get_vendor_new_order_notification()
  {

    if(Sentinel::getUser()->inRole('superadmin')):
     
    $data = OrderItemDetails::where('status','=',4)->get();
     else:
     $user_id=Sentinel::getUser()->id;
     $store_check=DB::table('store_assign_users')->where([['user_id','=',$user_id],['type','=',2]])->pluck('store_id');
     $data = OrderItemDetails::where('status','=',5)->whereIn('factory_vendor_id',$store_check)->get();
     endif;
     return count($data);
   }
    public static function newly_wharehouse_order_accounts()
  {

  
     $data = WharehouseOrder::where('status',0)->get();  
 
     return count($data);
   }
  public static function newly_factory_order_accounts()
  {

  
     $data = FactoryOrder::where('status',0)->get();  
 
     return count($data);
   }
   public static function new_factory_order_from_wharehouse($assign_type)
  {

    if(Sentinel::getUser()->inRole('superadmin')):
     
    $data = DB::table('wharehouse_order_details')->where([['status','=',1],['assign_type','=',$assign_type]])->get()->groupBy('wharehouse_order_id');
     else:
     $user_id=Sentinel::getUser()->id;
     $store_check=DB::table('store_assign_users')->where([['user_id','=',$user_id],['type','=',2]])->pluck('store_id');

     $data = DB::table('wharehouse_order_details')->where([['status','=',1],['assign_type','=',$assign_type]])->whereIn('factory_vendor_id',$store_check)->get()->groupBy('wharehouse_order_id');

     endif;
     return count($data);
   }
      public static function new_vendor_order_from_factory($assign_type)
  {

    if(Sentinel::getUser()->inRole('superadmin')):

     $data = DB::table('factory_order_details')->where([['status','=',1],['assign_type','=',$assign_type]])->get()->groupBy('factory_order_id');
    // $data = FactoryOrderDetails::where([['status','=',1],['assign_type','=',$assign_type]])->get();
     else:
     $user_id=Sentinel::getUser()->id;
     $store_check=DB::table('store_assign_users')->where([['user_id','=',$user_id],['type','=',2]])->pluck('store_id');
     $data = DB::table('factory_order_details')->where([['status','=',1],['assign_type','=',$assign_type]])->whereIn('factory_vendor_id',$store_check)->get()->groupBy('factory_order_id');
     // $data = FactoryOrderDetails::where([['status','=',1],['assign_type','=',$assign_type]])->whereIn('factory_vendor_id',$store_check)->get();
     endif;
     return count($data);
   }

    public static function ongoing_factory_order_from_wharehouse($assign_type)
  {

    if(Sentinel::getUser()->inRole('superadmin')):
     $data=DB::table('wharehouse_order_details')
               ->where([['status','=',5],['assign_type','=',$assign_type]])
              
              ->get()->groupBy('wharehouse_order_id');
    // $data = WharehouseOrderDetails::where([['status','=',5],['assign_type','=',$assign_type]])->get();
     else:
     $user_id=Sentinel::getUser()->id;
     $store_check=DB::table('store_assign_users')->where([['user_id','=',$user_id],['type','=',2]])->pluck('store_id');

     $data=DB::table('wharehouse_order_details')
               ->where([['status','=',5],['assign_type','=',$assign_type]])
               ->whereIn('factory_vendor_id',$store_check)
              ->get()->groupBy('wharehouse_order_id');

     // $data = WharehouseOrderDetails::where([['status','=',5],['assign_type','=',$assign_type]])->whereIn('factory_vendor_id',$store_check)->get();
     endif;
     return count($data);
   }
    public static function ongoing_vendor_order_from_factory($assign_type)
  {

    if(Sentinel::getUser()->inRole('superadmin')):
     
    // $data = FactoryOrderDetails::where([['status','=',5],['assign_type','=',$assign_type]])->get();
    $data=DB::table('factory_order_details')
               ->where([['status','=',5],['assign_type','=',$assign_type]])
              
              ->get()->groupBy('factory_order_id');

     else:
     $user_id=Sentinel::getUser()->id;
     $store_check=DB::table('store_assign_users')->where([['user_id','=',$user_id],['type','=',2]])->pluck('store_id');
     // $data = FactoryOrderDetails::where([['status','=',5],['assign_type','=',$assign_type]])->whereIn('factory_vendor_id',$store_check)->get();
     $data=DB::table('factory_order_details')
               ->where([['status','=',5],['assign_type','=',$assign_type]])
               ->whereIn('factory_vendor_id',$store_check)
              ->get()->groupBy('factory_order_id');
     endif;
     return count($data);
   }
    public static function ongoing_accounts_order_from_wharehouse()
  {

    if(Sentinel::getUser()->inRole('superadmin')):
      $data = DB::table('wharehouse_order_details')->whereIn('status',[4])->get()->groupBy('wharehouse_order_id');
     else:
     $user_id=Sentinel::getUser()->id;
     $store_check=DB::table('store_assign_users')->where([['user_id','=',$user_id],['type','=',2]])->pluck('store_id');
      $data = DB::table('wharehouse_order_details')->whereIn('status',[4])->whereIn('factory_vendor_id',$store_check)->get()->groupBy('wharehouse_order_id');
     
     endif;
     return count($data);
   }
      public static function dispatched_accounts_order_from_wharehouse()
  {

    if(Sentinel::getUser()->inRole('superadmin')):
      $data = DB::table('wharehouse_order_details')->whereIn('status',[2])->get()->groupBy('wharehouse_order_id');
     else:
     $user_id=Sentinel::getUser()->id;
     $store_check=DB::table('store_assign_users')->where([['user_id','=',$user_id],['type','=',2]])->pluck('store_id');
      $data = DB::table('wharehouse_order_details')->whereIn('status',[2])->whereIn('factory_vendor_id',$store_check)->get()->groupBy('wharehouse_order_id');
     
     endif;
     return count($data);
   }
   public static function ongoing_accounts_order_from_factory()
  {

    if(Sentinel::getUser()->inRole('superadmin')):
     
    // $data = FactoryOrderDetails::whereIn('status',[4,2])->get();
     $data = DB::table('factory_order_details')->whereIn('status',[4])->get()->groupBy('factory_order_id');

     else:
     $user_id=Sentinel::getUser()->id;
     $store_check=DB::table('store_assign_users')->where([['user_id','=',$user_id],['type','=',2]])->pluck('store_id');
     // $data = FactoryOrderDetails::whereIn('status',[4,2])->whereIn('factory_vendor_id',$store_check)->get();
     $data = DB::table('factory_order_details')->whereIn('status',[4])->whereIn('factory_vendor_id',$store_check)->get()->groupBy('factory_order_id');
     endif;
     return count($data);
   }
  public static function dispatched_accounts_order_from_factory()
  {

    
    if(Sentinel::getUser()->inRole('superadmin')):
     
    // $data = FactoryOrderDetails::whereIn('status',[4,2])->get();
     $data = DB::table('factory_order_details')->whereIn('status',[2])->get()->groupBy('factory_order_id');

     else:
     $user_id=Sentinel::getUser()->id;
     $store_check=DB::table('store_assign_users')->where([['user_id','=',$user_id],['type','=',2]])->pluck('store_id');
     // $data = FactoryOrderDetails::whereIn('status',[4,2])->whereIn('factory_vendor_id',$store_check)->get();
     $data = DB::table('factory_order_details')->whereIn('status',[2])->whereIn('factory_vendor_id',$store_check)->get()->groupBy('factory_order_id');
     endif;
     return count($data);
   } 
   public static function get_franchise_registration_new_submitted($brand)
  {
    if($brand==0):
    $data=User::whereIn('registration_level',[2,1])
            ->where([['status','=',1],['active_status','=',1]])->get();
    else:
    $data = DB::table('fanchise_registrations')
               ->join('users','fanchise_registrations.fanchise_id' , '=', 'users.id')
               ->whereIn('users.registration_level',[2,1])
            ->where([['fanchise_registrations.brands' , '=', (int)$brand],['users.status','=',1],['users.active_status','=',1]])
            ->get(); 
    endif;
    return count($data);
   
   }
   public static function get_franchise_registration_new_active_submitted($brand)
  {
    if($brand==0):
    $data=User::whereIn('registration_level',[2,1])
            ->where([['status','=',1],['active_status','=',1]])->get();
    else:
    $data = DB::table('fanchise_registrations')
               ->join('users','fanchise_registrations.fanchise_id' , '=', 'users.id')
               ->whereIn('users.registration_level',[2,1])
            ->where([['fanchise_registrations.brands' , '=', (int)$brand],['users.status','=',1],['users.active_status','=',1]])
            ->get(); 
    endif;
    return count($data);
   
   }
   public static function get_franchise_registration_new_inactive_submitted($brand)
  {
    if($brand==0):
    $data=User::whereIn('registration_level',[2,1])
            ->where([['status','=',1],['active_status','=',2]])->get();
    else:
    $data = DB::table('fanchise_registrations')
               ->join('users','fanchise_registrations.fanchise_id' , '=', 'users.id')
               ->whereIn('users.registration_level',[2,1])
            ->where([['fanchise_registrations.brands' , '=', (int)$brand],['users.status','=',1],['users.active_status','=',2]])
            ->get(); 
    endif;
    return count($data);
   
   }
    public static function get_franchise_registration_tem_inactive($brand)
  {
   
    $data=DB::table('users')
           ->join('fanchise_registrations','fanchise_registrations.fanchise_id','=','users.id')
           ->whereIn('users.registration_level',[2,1])
           ->where([['users.active_status','=',1]])
           ->whereDate('fanchise_registrations.expire_date', '<', date('Y-m-d'))
           ->select('users.*')
           ->latest()
           ->get();
   

    return count($data);
   
   }
    public static function get_franchise_registration_inactive($brand)
  {
      $data=DB::table('users')
           ->join('fanchise_registrations','fanchise_registrations.fanchise_id','=','users.id')
           ->whereIn('users.registration_level',[2,1])
           ->where([['users.active_status','=',3]])
         
           ->select('users.*')
           ->latest()
           ->get();
    return count($data);
   
   }
   public static function get_franchise_registration_pushbacked($brand)
  {
     if($brand==0):
   $data=User::whereIn('registration_level',[2,1])
            ->where([['status','=',3],['active_status','=',1]])->get();
     else:
    $data = DB::table('fanchise_registrations')
               ->join('users','fanchise_registrations.fanchise_id' , '=', 'users.id')
               ->whereIn('users.registration_level',[2,1])
            ->where([['fanchise_registrations.brands' , '=', (int)$brand],['users.status','=',3],['users.active_status','=',1]])
            ->get(); 
    endif;
    return count($data);
   
   }
   public static function get_franchise_registration_replied($brand)
  {
     if($brand==0):
   $data=User::whereIn('registration_level',[2,1])
            ->where('status','=',4)->get();
     else:
    $data = DB::table('fanchise_registrations')
               ->join('users','fanchise_registrations.fanchise_id' , '=', 'users.id')
               ->whereIn('users.registration_level',[2,1])
            ->where([['fanchise_registrations.brands' , '=', (int)$brand],['users.status','=',4]])
            ->get(); 
    endif;
    return count($data);
   
   }
   public static function get_franchise_registration_ongoing_kyc_inactive($brand)
  {
     if($brand==0):
      $data = DB::table('fanchise_registrations')
             ->join('users','fanchise_registrations.fanchise_id' , '=', 'users.id')
             ->whereNotIn('users.status',[0,1,3,4,7,6])
             ->where('users.active_status',1)
             ->orderBy('users.created_at', 'DESC')
             ->get(); 
     else:
     $data = DB::table('fanchise_registrations')
             ->join('users','fanchise_registrations.fanchise_id' , '=', 'users.id')
             ->whereNotIn('users.status',[0,1,3,4,7,6])
             ->where([['fanchise_registrations.brands','=',(int)$brand],['users.active_status',1]])
             ->orderBy('users.created_at', 'DESC')
             ->get();
    endif;
    return count($data);
   
   }
   
    public static function get_franchise_registration_ongoing($brand)
  {
     if($brand==0):
     $data = DB::table('fanchise_registrations')
             ->join('users','fanchise_registrations.fanchise_id' , '=', 'users.id')
             ->whereNotIn('users.status',[0,1,3,4,7,2,5])
             ->where('users.active_status',1)
             ->orderBy('users.created_at', 'DESC')
             ->get(); 
     else:
      $data = DB::table('fanchise_registrations')
             ->join('users','fanchise_registrations.fanchise_id' , '=', 'users.id')
             ->whereNotIn('users.status',[0,1,3,4,7,2,5])
             ->where([['fanchise_registrations.brands','=',(int)$brand],['users.active_status',1]])
             ->orderBy('users.created_at', 'DESC')
             ->get();
    endif;
    return count($data);
   
   }
    public static function get_franchise_registration_launched($brand)
  {

     $data=DB::table('users')
           ->join('fanchise_registrations','fanchise_registrations.fanchise_id','=','users.id')
           ->whereIn('users.registration_level',[2,1])
           ->where([['users.active_status','=',1]])
           ->whereDate('fanchise_registrations.expire_date', '>=', date('Y-m-d'))
           ->select('users.*')
           ->latest()
           ->get();
   
   
    return count($data);
   
   }
   public static function get_franchise_total($brand)
  {
    
     $data=User::whereIn('registration_level',[2,1])
           ->get();
     
    return count($data);
   
   }
    public static function get_Utensil_count($brand)
  {
    if($brand==0):
     $data=MasterProduct::where('item_type','=','Utensil')
           ->get();
    else:
        $data = DB::table('brand_wise_products')
               ->join('master_products','brand_wise_products.product_id' , '=', 'master_products.id')
             ->where([['brand_wise_products.brand_id' , '=',(int)$brand],['master_products.item_type' , '=', 'Utensil']])
            ->get(); 

    endif;
    return count($data);
   
   }
     public static function get_Equipment_count($brand)
  {
    if($brand==0):
     $data=MasterProduct::where('item_type','=','Equipment')
           ->get();
    else:
        $data = DB::table('brand_wise_products')
               ->join('master_products','brand_wise_products.product_id' , '=', 'master_products.id')
             ->where([['brand_wise_products.brand_id' , '=', (int)$brand],['master_products.item_type' , '=', 'Equipment']])
            ->get(); 

    endif;
    return count($data);
   
   }
     public static function get_Disposable_count($brand)
  {
    if($brand==0):
     $data=MasterProduct::where('item_type','=','Disposable')
           ->get();
     else:
        $data = DB::table('brand_wise_products')
               ->join('master_products','brand_wise_products.product_id' , '=', 'master_products.id')
             ->where([['brand_wise_products.brand_id' , '=', (int)$brand],['master_products.item_type' , '=', 'Disposable']])
            ->get(); 

     endif;
    return count($data);
   
   }
    public static function get_Frozen_count($brand)
  {
    if($brand==0):
     $data=MasterProduct::where('item_type','=','Frozen')
           ->get();
     else:
        $data = DB::table('brand_wise_products')
               ->join('master_products','brand_wise_products.product_id' , '=', 'master_products.id')
             ->where([['brand_wise_products.brand_id' , '=', (int)$brand],['master_products.item_type' , '=', 'Frozen']])
            ->get(); 

    endif;
    return count($data);
   
   }
   public static function get_Masala_count($brand)
  {
    if($brand==0):
     $data=MasterProduct::where('item_type','=','Masala')
           ->get();
     else:
        $data = DB::table('brand_wise_products')
               ->join('master_products','brand_wise_products.product_id' , '=', 'master_products.id')
             ->where([['brand_wise_products.brand_id' , '=',(int) $brand],['master_products.item_type' , '=', 'Masala']])
            ->get(); 

    endif;
    return count($data);
   
   }
   public static function get_total_product($brand)
  {
    if($brand==0):
     $data=MasterProduct::all();
      else:
        $data = DB::table('brand_wise_products')
               ->join('master_products','brand_wise_products.product_id' , '=', 'master_products.id')
             ->where('brand_wise_products.brand_id' , '=', (int)$brand)
            ->get(); 

    endif;
    return count($data);
   
   }
}