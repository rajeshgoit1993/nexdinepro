<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Sentinel;
use App\Helpers\CustomHelpers;
use App\Helpers\POS_SettingHelpers;
use App\Helpers\POSCommonHelpers;
use App\Helpers\KitchenHelpers;
use App\Helpers\WaiterHelpers;
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

class WaiterController extends Controller
{
    //
    public function index()
    {
         $data = array();
         $data['notifications'] = $this->get_new_notification();
          

         return view('outlet.pos.waiter.index',compact('data'));
    }
    public function get_new_notification()
    {
        $outlet_id = (int)Sentinel::getUser()->parent_id;
       
        $notifications = WaiterHelpers::getNotificationByOutletId($outlet_id);
        return $notifications;
    }
    public function get_new_notifications_ajax()
    {
        echo json_encode($this->get_new_notification());        
    }
    public function remove_notication_ajax(Request $request)
    {
        $notification_id =$request->notification_id;
        FranchiseNotification::where('id',$notification_id)->delete();
        
        echo POS_SettingHelpers::escape_output( $notification_id);
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
