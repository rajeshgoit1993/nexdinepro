<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FanchiseRegistration;
use App\Models\FanchiseRegistrationStep;
use App\Models\RegistrationActivityStatus;
use App\Notifications\UserWelcomeNotification;
use App\Models\Role;
use App\Models\User;
use App\Helpers\CustomHelpers;
use App\Helpers\NotificationHelpers;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use App\Models\PreLaunch;
use App\Models\PreLaunchDoc;
use App\Models\UtensilList;
use App\Models\FirstTimeStockCart;
use App\Models\StoreDetails;
use App\Models\ItemImages;
use Validator;
use App\Models\PageAccess;
use App\Models\Brands;
use App\Models\MasterProduct;
use Sentinel;
use Session;
use DB;

class AdminDashboardController extends Controller
{
    public function set_brand_session(Request $request)
    {
         $brand=$request->brand;
         Session::put('current_brand',$brand);
    }
    public function get_admin_dashboard(Request $request)
    {

     $brand=$request->brand;
      $get_franchise_registration_new_active_submitted=NotificationHelpers::get_franchise_registration_new_active_submitted($brand);

     $get_franchise_registration_new_inactive_submitted=NotificationHelpers::get_franchise_registration_new_inactive_submitted($brand);

      $get_franchise_registration_pushbacked=NotificationHelpers::get_franchise_registration_pushbacked($brand);

      $get_franchise_registration_replied=NotificationHelpers::get_franchise_registration_replied($brand);


      
      $get_franchise_registration_ongoing_kyc_inactive=NotificationHelpers::get_franchise_registration_ongoing_kyc_inactive($brand);
      
      $get_franchise_registration_ongoing=NotificationHelpers::get_franchise_registration_ongoing($brand);

      $get_franchise_registration_launched=NotificationHelpers::get_franchise_registration_launched($brand);

      $get_franchise_registration_tem_inactive=NotificationHelpers::get_franchise_registration_tem_inactive($brand);

      $get_franchise_registration_inactive=NotificationHelpers::get_franchise_registration_inactive($brand);
      
      $get_franchise_total=NotificationHelpers::get_franchise_total($brand);

      $get_Utensil_count=NotificationHelpers::get_Utensil_count($brand);

      $get_Equipment_count=NotificationHelpers::get_Equipment_count($brand);

      $get_Disposable_count=NotificationHelpers::get_Disposable_count($brand);

      $get_Frozen_count=NotificationHelpers::get_Frozen_count($brand);

      $get_Masala_count=NotificationHelpers::get_Masala_count($brand);

      $get_total_product=NotificationHelpers::get_total_product($brand);

       $data=['get_franchise_registration_new_active_submitted'=>$get_franchise_registration_new_active_submitted,'get_franchise_registration_new_inactive_submitted'=>$get_franchise_registration_new_inactive_submitted,'get_franchise_registration_ongoing_kyc_inactive'=>$get_franchise_registration_ongoing_kyc_inactive,'get_franchise_registration_pushbacked'=>$get_franchise_registration_pushbacked,'get_franchise_registration_replied'=>$get_franchise_registration_replied,'get_franchise_registration_ongoing'=>$get_franchise_registration_ongoing,'get_franchise_registration_launched'=>$get_franchise_registration_launched,'get_franchise_registration_tem_inactive'=>$get_franchise_registration_tem_inactive,'get_franchise_registration_inactive'=>$get_franchise_registration_inactive,'get_franchise_total'=>$get_franchise_total,'get_Utensil_count'=>$get_Utensil_count,'get_Equipment_count'=>$get_Equipment_count,'get_Disposable_count'=>$get_Disposable_count,'get_Frozen_count'=>$get_Frozen_count,'get_Masala_count'=>$get_Masala_count,'get_total_product'=>$get_total_product];
        

      
        return $data;
      
    }
}
