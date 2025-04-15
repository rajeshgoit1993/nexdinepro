<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Sentinel;
use App\Helpers\CustomHelpers;
use App\Helpers\POS_SettingHelpers;
use App\Helpers\POSCommonHelpers;
use App\Helpers\KitchenHelpers;
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


class KitchenController extends Controller
{
   public function index()
    {
       
     $data = array();
      $data['getUnReadyOrders'] = $this->get_new_orders();
      $data['notifications'] = $this->get_new_notification();
       //   echo "<pre>";
       // var_dump($data['notifications']);
       //  echo "<pre>";
       //  die();

       return view('outlet.pos.kitchen.index',compact('data'));
    }
       public function get_new_orders(){
        $outlet_id = (int)Sentinel::getUser()->parent_id;
        $user_id = Sentinel::getUser()->id;
        $data1 = KitchenHelpers::getNewOrders($outlet_id);
        $i = 0;
        for($i;$i<count($data1);$i++){
            //update for bell
            $data_bell = array();
            $data_bell['is_kitchen_bell'] = 2;
            POSCommonHelpers::updateInformation($data_bell, $data1[$i]->sale_id, "franchise_sales");

            $data1[$i]->total_kitchen_type_items =KitchenHelpers::get_total_kitchen_type_items($data1[$i]->sale_id);
            $data1[$i]->total_kitchen_type_done_items = KitchenHelpers::get_total_kitchen_type_done_items($data1[$i]->sale_id);
            $data1[$i]->total_kitchen_type_started_cooking_items = KitchenHelpers::get_total_kitchen_type_started_cooking_items($data1[$i]->sale_id);
            $data1[$i]->tables_booked = KitchenHelpers::get_all_tables_of_a_sale_items($data1[$i]->sale_id);
            $items_by_sales_id = KitchenHelpers::getAllKitchenItemsFromSalesDetailBySalesId($data1[$i]->sale_id);    
        
            foreach($items_by_sales_id as $single_item_by_sale_id){
                $modifier_information = KitchenHelpers::getModifiersBySaleAndSaleDetailsId($data1[$i]->sale_id,$single_item_by_sale_id->sales_details_id);
                $single_item_by_sale_id->modifiers = $modifier_information;
            }
            $data1[$i]->items = $items_by_sales_id;
        }
        return $data1;
    }
  public function get_new_notification()
    {
        $outlet_id = (int)Sentinel::getUser()->parent_id;
        $notifications = KitchenHelpers::getNotificationByOutletId($outlet_id);
        return $notifications;
    }
    public function get_new_orders_ajax(){
        $data1 = $this->get_new_orders();
        echo json_encode($data1);        
    }
    public function get_new_notifications_ajax()
    {
        echo json_encode($this->get_new_notification());        
    }
     public function update_cooking_status_ajax(Request $request)
    {
        $previous_id =$request->previous_id;
        $previous_id_array = explode(",",$previous_id);
        $cooking_status =$request->cooking_status;
        $total_item = count($previous_id_array); 

        foreach($previous_id_array as $single_previous_id){
            $previous_id = $single_previous_id;
            $item_info = KitchenHelpers::getItemInfoByPreviousId($previous_id);

            $sale_id = $item_info->sales_id;
            $sale_info = KitchenHelpers::getSaleBySaleId($sale_id);
            $sale_info[0]->tables_booked = KitchenHelpers::get_all_tables_of_a_sale_items($sale_id);
            $tables_booked = '';
            if(count($sale_info[0]->tables_booked)>0){
                $w = 1;
                foreach($sale_info[0]->tables_booked as $single_table_booked){
                    if($w == count($sale_info[0]->tables_booked)){
                        $tables_booked .= $single_table_booked->table_name;
                    }else{
                        $tables_booked .= $single_table_booked->table_name.', ';
                    }
                    $w++;
                }    
            }else{
                $tables_booked = 'None';
            }
            if($cooking_status=="Started Cooking"){
                $cooking_status_update_array = array('cooking_status' => $cooking_status, 'cooking_start_time' => date('Y-m-d H:i:s'));
                
               
                 FranchiseSalesDetails::where('previous_id', $previous_id)->update($cooking_status_update_array);
                if($sale_info[0]->date_time==strtotime('0000-00-00 00:00:00')){
                    $cooking_update_array_sales_tbl = array('cooking_start_time' => date('Y-m-d H:i:s'));
                   
                    FranchiseSale::where('id', $sale_id)->update($cooking_update_array_sales_tbl);  
                }
                
            }else{

                $cooking_status_update_array = array('cooking_status' => $cooking_status, 'cooking_done_time' => date('Y-m-d H:i:s'));
                
             
                FranchiseSalesDetails::where('previous_id', $previous_id)->update($cooking_status_update_array);
                $cooking_update_array_sales_tbl = array('cooking_done_time' => date('Y-m-d H:i:s'));
               
           FranchiseSale::where('id', $sale_id)->update($cooking_update_array_sales_tbl);
                if($sale_info[0]->order_type==1){
                    $order_name = "A ".$sale_info[0]->sale_no;
                }elseif($sale_info[0]->order_type==2){
                    $order_name = "B ".$sale_info->sale_no;
                }elseif($sale_info[0]->order_type==3){
                    $order_name = "C ".$sale_info[0]->sale_no;
                }
                $notification = "Table: ".$tables_booked.', Customer: '.$sale_info[0]->customer_name.', Item: '.$item_info->menu_name.' is ready to serve, Order: '.$order_name;
                $notification_data = array();        
                $notification_data['notification'] = $notification;
                $notification_data['sale_id'] = $sale_id;
                $notification_data['waiter_id'] = $sale_info[0]->waiter_id;
                $notification_data['outlet_id'] =  (int)Sentinel::getUser()->parent_id;
               
                FranchiseNotification::create($notification_data);
            }
        } 
    }

     public function update_cooking_status_delivery_take_away_ajax(Request $request){
        $outlet_id = (int)Sentinel::getUser()->parent_id;
        $previous_id =$request->previous_id;
        $previous_id_array = explode(",",$previous_id);
        $cooking_status =$request->cooking_status;
        $total_item = count($previous_id_array);
        $i = 1;
        foreach($previous_id_array as $single_previous_id){
            $previous_id = $single_previous_id;
            $item_info = KitchenHelpers::getItemInfoByPreviousId($previous_id);
            $sale_id = $item_info->sales_id;
            if($cooking_status=="Started Cooking"){
                $cooking_status_update_array = array('cooking_status' => $cooking_status, 'cooking_start_time' => date('Y-m-d H:i:s'));
                
               FranchiseSalesDetails::where('previous_id',$previous_id)->update($cooking_status_update_array);

                
                
                $cooking_update_array_sales_tbl = array('cooking_start_time' => date('Y-m-d H:i:s'));
                FranchiseSale::where('id',$sale_id)->update($cooking_update_array_sales_tbl);
               
            }else{
                $cooking_status_update_array = array('cooking_status' => $cooking_status, 'cooking_done_time' => date('Y-m-d H:i:s'));
                
                FranchiseSalesDetails::where('previous_id',$previous_id)->update($cooking_status_update_array);

               

                $cooking_update_array_sales_tbl = array('cooking_done_time' => date('Y-m-d H:i:s'));
               
              FranchiseSale::where('id',$sale_id)->update($cooking_update_array_sales_tbl);
                if($i==$total_item){
                    $sale_info = $this->get_all_information_of_a_sale_kitchen_type($sale_id);
                    $order_type_operation = '';
                    if($sale_info->order_type==1){
                        $order_name = "A ".$sale_info->sale_no;
                    }elseif($sale_info->order_type==2){
                        $order_name = "B ".$sale_info->sale_no;
                        $order_type_operation = 'Take Away order is ready to take';
                    }elseif($sale_info->order_type==3){
                        $order_name = "C ".$sale_info->sale_no;
                        $order_type_operation = 'Delivery order is ready to deliver';
                    }
                    $notification = 'Customer: '.$sale_info->customer_name.', Order Number: '.$order_name.' '.$order_type_operation;
                    $notification_data = array();        
                    $notification_data['notification'] = $notification;
                    $notification_data['sale_id'] = $sale_id;
                    $notification_data['waiter_id'] = $sale_info->waiter_id;
                    $notification_data['outlet_id'] = $outlet_id;
                    FranchiseNotification::create($notification_data);
                      
                }
            }
            $i++;
        }
    }
    public function get_all_information_of_a_sale_kitchen_type($sales_id){
        $sales_information = KitchenHelpers::getSaleBySaleId($sales_id);
        $items_by_sales_id = KitchenHelpers::getAllKitchenItemsFromSalesDetailBySalesId($sales_id);
        foreach($items_by_sales_id as $single_item_by_sale_id){
            $modifier_information = KitchenHelpers::getModifiersBySaleAndSaleDetailsId($sales_id,$single_item_by_sale_id->sales_details_id);
            $single_item_by_sale_id->modifiers = $modifier_information;
        }
        $sales_details_objects = $items_by_sales_id;
        $sale_object = $sales_information[0];
        $sale_object->items = $sales_details_objects;
        return $sale_object;
    }
    public function remove_notication_ajax(Request $request)
    {
        $notification_id =$request->notification_id;
        FranchiseNotificationBarKitchenPanel::where('id',$notification_id)->delete();
        
        echo escape_output($notification_id);
    }
}  
