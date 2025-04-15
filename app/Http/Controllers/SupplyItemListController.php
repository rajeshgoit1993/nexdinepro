<?php

namespace App\Http\Controllers;

use App\Models\SupplyItemList;
use Illuminate\Http\Request;
use DataTables;
use Sentinel;
use App\Helpers\CustomHelpers;
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
use App\Models\MasterProduct;
use App\Models\FanchiseRegistration;
use App\Models\FranchiseCreditHistory;
use App\Models\FranchiseStockSalePrice;
use App\Models\DailyPurchase;
use App\Models\DailyPurchaseIngredients;
use DB;

class SupplyItemListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function newly_order()
    {
        $fanchise_id=Sentinel::getUser()->id;
        $data = OrderPayment::where('fanchise_id','=',$fanchise_id)->where('payment_status','=',1)
                              ->whereIn('status',[0,1,2,4])->orderBy('id', 'DESC')->get();
      return view('admin.order.newly_order',compact('data'));
    }
      public function order_completed()
    {
        $fanchise_id=Sentinel::getUser()->id;
        $data = OrderPayment::where([['fanchise_id','=',$fanchise_id],['status','=',3]])
                              ->get();
      return view('admin.order.order_completed',compact('data'));
    }
     public function new_order_payments()
    {
        
      $data = OrderPayment::where([['status','=',0],['payment_status','=',1]])->get();
                             
      return view('admin.order.new_order_payments',compact('data'));
    }
     public function ongoing_order()
    {
        
        $data = OrderPayment::whereIn('status',[1,2])->get();
                             
      return view('admin.order.ongoing_order',compact('data'));
    }
     public function accepted_order_payments()
    {
        
        $data = OrderPayment::where('status',1)->get();
                             
      return view('admin.order.accepted_order_payments',compact('data'));
    }
      public function order_details_with_status_change(Request $request)
    {
    $id=CustomHelpers::custom_decrypt($request->id);
    $data=OrderPayment::find($id);

    
    // $options = view("admin.order.step",compact('data'))->render();
    $options = view("admin.order.order_details_with_status_change",compact('data'))->render();
    echo $options;
    
    }
    public function dispatched_product(Request $request)
    {
    $id=CustomHelpers::custom_decrypt($request->id);
    $data=OrderPayment::find($id);

    
    // $options = view("admin.order.step",compact('data'))->render();
    $options = view("admin.order.dispatched_product",compact('data'))->render();
    echo $options;
    
    }
    public function track_order_status(Request $request)
    {
    $id=CustomHelpers::custom_decrypt($request->id);
    $data=OrderPayment::find($id);

    
    // $options = view("admin.order.step",compact('data'))->render();
    $options = view("admin.order.order_details",compact('data'))->render();
    echo $options;
    
    }
    public function get_update_order_payment_status(Request $request)
    {
   $id=CustomHelpers::custom_decrypt($request->id);
   $data=OrderPayment::find($id);
   $setting_data=StoreSetting::find(1);
   if($setting_data->status==0)
   {
  $stores=Stores::where('type','=',1)->whereIn('status',[1,2])->get();
   }
  else
  {
  $fanchise_id=$data->fanchise_id;
  $sentinel_user=User::where('id','=',$fanchise_id)->first();
  $state=$sentinel_user->state;
  $dist=$sentinel_user->dist;
  $city=$sentinel_user->city;
  $stores=Stores::where([['type','=',1],['state','=',$state],['dist','=',$dist],['city','=',$city]])->whereIn('status',[1,2])->get();
   }

   

    $output=' <input type="hidden" name="id" id="fanchise_id" value="'.$data->id.'">  
         <div class="row">
    <div class="col-md-12">
     <div class="form-group">
          <label for="">Status</label>
         <select class="form-control" name="status" required> 
           <option value="1">Confirmed</option>
         
         </select>
      
        </div>
 </div>
 <div class="col-md-12">
     <div class="form-group">
          <label for="">Assign to Warehouse</label>
         <select class="form-control" name="store_id" id="store_id" required> 
         <option value="" >--Select Warehouse--</option>
         ';

foreach($stores as $store)
{
    if($store->id==$data->assign_order_to_warehouse_id):
  $output.='<option value="'. $store->id.'" selected>'. $store->name.'</option>';  
   else:
    $output.='<option value="'. $store->id.'" >'. $store->name.'</option>';  
   endif;
}

 
 
  $output.='</select>
      
        </div>
 </div></div><br>

 <button type="button"  id="update_survey" class="btn btn-info btn-lg">Save</button>';
  echo $output;

    }

       public function get_outlet_order_status_update_by_factory(Request $request)
    {
   $id=CustomHelpers::custom_decrypt($request->id);
   $data=OrderItemDetails::find($id);
    $output=' <input type="hidden" name="id" id="order_item_id" value="'.$request->id.'">  
         <div class="row">
    <div class="col-md-6">
     <div class="form-group">
          <label for="">Status</label>
         <select class="form-control" name="status" required> 
         
           <option value="4">Dispatch</option>
          
         </select>
      
        </div>
 </div>
 <div class="col-md-6">
     <div class="form-group">
          <label for="">Dispatch Date</label>
          <input type="date" name="dispatch_date" id="dispatch_date" class="form-control" placeholder="Date" value="" required>
       
        </div>
 </div>
 <div class="col-md-12">
     <div class="form-group">
          <label for="">Courier Name</label>
          <textarea name="courier_name" id="courier_name" class="form-control" placeholder="  Courier Name" required></textarea>
     
         
        </div>
 </div>


 
 
  </div><br>

 <button type="submit"   class="btn btn-info btn-lg">Update</button>';
  echo $output;

    }
    public function update_order_status_factory(Request $request)
    {

      $order_id=$request->id;
      $order_id=CustomHelpers::custom_decrypt($order_id);
      $data=OrderItemDetails::find($order_id);
    
       $data->status=4;
       $data->dispatch_date=$request->dispatch_date; 
       $data->courier_name=$request->courier_name;
        
       $data->save();


       echo 'success'; 

    }
     public function update_order_status_vendor(Request $request)
    {

      $order_id=$request->id;
      $order_id=CustomHelpers::custom_decrypt($order_id);
      $data=OrderItemDetails::find($order_id);
    
       $data->status=6;
       $data->dispatch_date=$request->dispatch_date; 
       $data->courier_name=$request->courier_name;
        
       $data->save();


       echo 'success'; 

    }
    public function get_update_order_status(Request $request)
    {
   $id=CustomHelpers::custom_decrypt($request->id);
   $data=OrderPayment::find($id);
    $output=' <input type="hidden" name="id" id="fanchise_id" value="'.$data->id.'">  
         <div class="row">
    <div class="col-md-6">
     <div class="form-group">
          <label for="">Status</label>
         <select class="form-control" name="status"> 
           <option value="1">Confirmed</option>
           <option value="2">Dispatch</option>
           <option value="3">Delivered</option>
         </select>
      
        </div>
 </div>
 <div class="col-md-6">
     <div class="form-group">
          <label for="">Date</label>
          <input type="date" name="date" id="date" class="form-control" placeholder="Date" value="">
          <span id="error_survey_date" class="text-danger"></span>
        </div>
 </div>
 <div class="col-md-12">
     <div class="form-group">
          <label for="">Remarks</label>
          <textarea name="remarks" id="remarks" class="form-control" placeholder="  Remarks"></textarea>
     
          <span id="error_survey_remarks" class="text-danger"></span>
        </div>
 </div>


 
 
  </div><br>

 <button type="button"  id="update_survey" class="btn btn-info btn-lg">Save</button>';
  echo $output;

    }
    public function change_order_status_dynamic_data(Request $request)
    {
      $order_id=$request->order_id;
      $order_id=CustomHelpers::custom_decrypt($order_id);
      $order_details=OrderItemDetails::find($order_id);
      $product_id=$order_details->product_id;

      $status=$request->status;
      if($status==2):
        $output='<div class="row"><div class="col-md-6">
     <div class="form-group">
          <label for="">Dispatch Date</label>
          <input type="date" name="dispatch_date" class="form-control" placeholder="Dispatch Date" value="" required>
         
        </div> 
 </div>
<div class="col-md-6">
     <div class="form-group">
          <label for="">Dispatch QTY</label>
          <input type="text" name="order_confirm_qty" class="form-control order_confirm_qty" placeholder="Dispatch QTY" value="'.$order_details->order_confirm_qty.'" required>
         
        </div> 
 </div>
 <div class="col-md-12">
     <div class="form-group">
          <label for="" required>Courier Name</label>
          <input type="text" name="courier_name" class="form-control" placeholder="Courier Name" value="" required>
         
        </div>
 </div></div>';
      elseif($status==3):
      $output='<div class="col-md-12">
     <div class="form-group">
          <label for="">Select Factory</label>
           <select class="form-control" name="factory_vendor_id" required> 
           <option value="">--Select Factory--</option>
         
       ';
      $factory = AssignProductFactoryVendor::where([['product_id','=',$product_id],['type','=','factory']])->get();

      foreach($factory as $data)
      {
        $factory_name=CustomHelpers::get_master_table_data('stores','id',$data->factory_vendor_id,'name');
  $output.='<option value="'. $data->factory_vendor_id.'">'.$factory_name.'</option>';  
          }
   $output.='</select> </div>
 </div>';
      elseif($status==5):
        $output='<div class="col-md-12">
     <div class="form-group">
          <label for="">Select Vendor</label>
           <select class="form-control" name="factory_vendor_id" required> 
           <option value="">--Select Vendor--</option>
         
       ';
      $factory = AssignProductFactoryVendor::where([['product_id','=',$product_id],['type','=','vendor']])->get();

      foreach($factory as $data)
      {
        $factory_name=CustomHelpers::get_master_table_data('users','id',$data->factory_vendor_id,'name');
  $output.='<option value="'. $data->factory_vendor_id.'">'.$factory_name.'</option>';  
          }
   $output.='</select> </div>
 </div>';
      elseif($status==7):
         $output='<div class="col-md-12">
     <div class="form-group">
          <label for="">Delivered Date</label>
          <input type="date" name="dilivered_date" class="form-control" placeholder="Delivered Date" value="" required>
         
        </div>
 </div><div class="col-md-12">
     <div class="form-group">
          <label for="">Delivered Remarks</label>
           <textarea name="dilivered_remarks" class="form-control" placeholder="  Remarks"></textarea>
         
        </div>
 </div>';
    endif;
      echo  $output;  
    }
    public function save_collection_details(Request $request)
    {

     $oid=$request->order_id;
     if($oid!=''):

     foreach($oid as $oids):   
     $order_id=$oids;

      $order_id=CustomHelpers::custom_decrypt($order_id);
      $order_details=OrderItemDetails::find($order_id);
      $order_details->status=7;
      $order_details->dilivered_date=$request->dilivered_date; 
      $order_details->dilivered_remarks=$request->dilivered_remarks; 
       //
        $bal_qty=(float)$order_details->order_qty-(float)$order_details->order_confirm_qty;
        if($bal_qty>0):
        $return_subtotal=CustomHelpers::get_return_item_subtotal($order_details->fanchise_id,$bal_qty);
         $get_franchise_previous_credit_bal=CustomHelpers::get_franchise_previous_credit_bal($order_details->fanchise_id);
          $total_new_balance=(float)$return_subtotal+(float)$get_franchise_previous_credit_bal;
        
          $credit_history=new FranchiseCreditHistory;
           $credit_history->franchise_id=$order_details->fanchise_id;
           $credit_history->refund_qty=$bal_qty;
           $credit_history->refund_order_id=$order_details->order_id;
           $credit_history->refund_product_id=$order_details->product_id;
           $credit_history->credit=$return_subtotal;
           $credit_history->debit=0;
           $credit_history->remaining_bal=$total_new_balance;
           $credit_history->action_user_id=Sentinel::getUser()->id;
           $credit_history->remarks='Refund after reduced order QTY';
           $credit_history->save();
         
           endif;
        //
           
      $order_details->save();
      $order_main_id=$order_details->order_id;
      $condition_check=OrderItemDetails::where([['order_id','=',$order_main_id],['status','!=',7]])->get();
      if(count($condition_check)==0)
      {
        $payments_data=OrderPayment::find($order_main_id);
        $payments_data->status=3;
        $payments_data->save();
      }
      //
       $ordered_imtems=OrderItemDetails::where('order_id','=',$order_main_id)->get();
       $cost=0;
       $gst=0;
      foreach($ordered_imtems as $ordered_imtem)
      {
      $qty=(float)$order_details->order_confirm_qty;
      if($qty>0 && $ordered_imtem->status==7)
      {
       $cost=(float)$cost+(float)$ordered_imtem->product_rate*(float)$qty;
       $gst=(float)$gst+(float)((float)$ordered_imtem->product_rate*(float)$qty*(float)$ordered_imtem->gst_id/100);
       
      
      }
      }
     
       //
    $payments_data=OrderPayment::find($order_main_id);
    $daily_purchase_check=DailyPurchase::where([['outlet_id',$order_details->fanchise_id],['note','online'],['invoice_no',$order_main_id]])->first();
    if($daily_purchase_check=='')
    {
     $daily_purchase_check=new DailyPurchase;    
    }
    $daily_purchase_check->date=date('Y-m-d');
    $daily_purchase_check->subtotal=$cost;
    $daily_purchase_check->grand_total=$cost;
    $daily_purchase_check->user_id=Sentinel::getUser()->id;
    $daily_purchase_check->outlet_id=$order_details->fanchise_id;
    $daily_purchase_check->invoice_no=$order_main_id;
    $daily_purchase_check->total_gst=$gst;
    $daily_purchase_check->note='online';
    $daily_purchase_check->total_with_gst=(float)$gst+(float)$cost;
    $daily_purchase_check->status=2;
    $daily_purchase_check->del_status='Live';
    $daily_purchase_check->accept_date=$payments_data->assign_order_to_warehouse_date;
    $daily_purchase_check->accept_admin_id=$payments_data->assign_order_to_warehouse_id;
    $daily_purchase_check->save();
    
   $daily_purchase_ing=new DailyPurchaseIngredients;
   $daily_purchase_ing->ingredient_id=$order_details->product_id;
   $daily_purchase_ing->unit_price=$order_details->product_rate;
   $daily_purchase_ing->quantity_amount=$order_details->order_confirm_qty;
   $daily_purchase_ing->total=(float)$order_details->order_confirm_qty*(float)$order_details->product_rate;
   $daily_purchase_ing->purchase_id=$daily_purchase_check->id;
   $daily_purchase_ing->outlet_id=$order_details->fanchise_id;
   
   $gst_p=$order_details->gst_id;
   $daily_purchase_ing->gst_percentage=$gst_p;
   $total_gst=(float)$gst_p*(float)$order_details->product_rate*(float)$order_details->order_confirm_qty/100;
   $daily_purchase_ing->total_gst=$total_gst;
   $daily_purchase_ing->total_with_gst=(float)$total_gst+(float)$order_details->order_confirm_qty*(float)$order_details->product_rate;

   $daily_purchase_ing->save();
   //
$new_data=FranchiseStockSalePrice::where([['product_id',$daily_purchase_ing->ingredient_id],['outlet_id',$order_details->fanchise_id]])->first();

          $available_qty_data=$new_data->available_qty;
          $purchase_qty=$daily_purchase_ing->quantity_amount;
          $new_qty=(float)$available_qty_data+(float)$purchase_qty;
          $new_data->available_qty=$new_qty;
          $new_data->save(); 

    //
     endforeach;
     echo 'success';  
      else:
    echo 'select item';  
      endif;
      
         
    }
    public function change_order_status_store(Request $request)
    {


      $order_id=$request->order_id;
      $order_id=CustomHelpers::custom_decrypt($order_id);
      $order_details=OrderItemDetails::find($order_id);
      $product_id=$order_details->product_id;

      $status=$request->status; 
      

        if($status==2):
             $order_confirm_qty=$request->order_confirm_qty; 
             if($order_confirm_qty>$order_details->order_qty):
        echo 'Edit QTY can not be greater than Order QTY';
       die();
       else:

       //
        $order_main_id=$order_details->order_id;
       $store_id=OrderPayment::find($order_main_id);
       $store_data=StoreProduct::where([['product_id','=',$order_details->product_id],['store_id','=',$store_id->assign_order_to_warehouse_id]])->first();
    
        if($store_data->available_qty<$order_confirm_qty):
         echo 'you have insufficient qty';
       die();
        else:
         $previous_status=$order_details->status;
         if($previous_status==2):
        $previous_dispatch_qty=$order_details->order_confirm_qty;
        $new_avilable=(float)$store_data->available_qty+(float)$previous_dispatch_qty;
         $store_data->available_qty=(float)$new_avilable-(float)$order_confirm_qty;
         $store_data->save();
         else:
         $store_data->available_qty=(float)$store_data->available_qty-(float)$order_confirm_qty;
         $store_data->save();
         endif;
         


        endif;

       //

        $order_details->order_confirm_qty=$request->order_confirm_qty; 
        $order_details->qty_edit_admin_id=Sentinel::getUser()->id;
       endif;
       $order_details->status=2;
       $order_details->dispatch_date=$request->dispatch_date; 
       $order_details->courier_name=$request->courier_name;
      
       
      


        elseif($status==3):
       $order_details->status=3;
       $order_details->factory_vendor_id=$request->factory_vendor_id; 
       $order_details->assign_date=date('Y-m-d'); 
        elseif($status==5):
       $order_details->status=5;
       $order_details->factory_vendor_id=$request->factory_vendor_id; 
       $order_details->assign_date=date('Y-m-d'); 
        elseif($status==7):
        $order_details->status=7;
        $order_details->dilivered_date=$request->dilivered_date; 
        $order_details->dilivered_remarks=$request->dilivered_remarks; 
        //
        $bal_qty=(float)$order_details->order_qty-(float)$order_details->order_confirm_qty;
        if($bal_qty>0):
        $return_subtotal=CustomHelpers::get_return_item_subtotal($order_details->fanchise_id,$bal_qty);
         $get_franchise_previous_credit_bal=CustomHelpers::get_franchise_previous_credit_bal($order_details->fanchise_id);
          $total_new_balance=(float)$return_subtotal+(float)$get_franchise_previous_credit_bal;
        
          $credit_history=new FranchiseCreditHistory;
           $credit_history->franchise_id=$order_details->fanchise_id;
           $credit_history->refund_qty=$bal_qty;
           $credit_history->refund_order_id=$order_details->order_id;
           $credit_history->refund_product_id=$order_details->product_id;
           $credit_history->credit=$return_subtotal;
           $credit_history->debit=0;
           $credit_history->remaining_bal=$total_new_balance;
           $credit_history->action_user_id=Sentinel::getUser()->id;
           $credit_history->remarks='Refund after reduced order QTY';
           $credit_history->save();
         
           endif;
        //
        endif;
      $order_details->save();

       $order_main_id=$order_details->order_id;
      $condition_check=OrderItemDetails::where([['order_id','=',$order_main_id],['status','!=',7]])->get();
      if(count($condition_check)==0)
      {
        $payments_data=OrderPayment::find($order_main_id);
        $payments_data->status=3;
        $payments_data->save();
      }
      //
      $condition_check_second=OrderItemDetails::where([['order_id','=',$order_main_id],['status','!=',1]])->get();
      if(count($condition_check_second)==0)
      {
        $payments_data=OrderPayment::find($order_main_id);
        $payments_data->status=4;
        $payments_data->save();
      }
      //
      if($status==7):
echo 'delivered'; 
      else:
 echo 'success'; 
      endif;
     


    }
    public function order_payment_confirm_by_account(Request $request)
    {
        $id=$request->id;
        $data=OrderPayment::find($id);
        $status=$request->status;
      
         $data->status=1;
            
         $store=DB::table('stores')->where('id','=',$request->store_id)->first();
         $sentinel_user=Sentinel::findById($data->fanchise_id);
         $state=$sentinel_user->state;
         $dist=$sentinel_user->dist;
         $city=$sentinel_user->city; 
           if($store!=''):
        if($store->state==$state):
            //igst
        $data->gst_type=1;
        
        else:
             //cgst
        $data->gst_type=0;
             
        endif;
        endif;

         $data->assign_order_to_warehouse_id=$request->store_id;
         $data->assign_order_to_warehouse_date=date('Y-m-d');
      
        $data->save();
        echo 'success';
    }
    public function change_order_status(Request $request)
    {
        $id=$request->id;
        $data=OrderPayment::find($id);
        $status=$request->status;
        if($status=='1'):
         $data->status=$request->status;
         $data->confirm_date=$request->date;
         $data->confirm_remarks=$request->remarks;
        elseif($status=='2'):
        $data->status=$request->status;
         $data->dispatch_date=$request->date;
         $data->dispatch_remarks=$request->remarks;
        elseif($status=='3'):    
        $data->status=$request->status;
         $data->dilivered_date=$request->date;
         $data->dilivered_remarks=$request->remarks;
        endif;
        $data->save();
        echo 'success';
    }
   public function supply_list()
    {
    $user_id=Sentinel::getUser()->id;
    $registered_fanchise=FanchiseRegistration::where('fanchise_id','=',$user_id)->first();

       $data = DB::table('brand_wise_products')
            ->join('master_products', 'master_products.id', '=', 'brand_wise_products.product_id')
            ->where([['brand_wise_products.brand_id','=',(int)$registered_fanchise->brands],['master_products.supply_for','=',1]])
            ->select('master_products.*', 'brand_wise_products.initial_qty', 'brand_wise_products.brand_id')
            ->get()
            ->groupBy('item_type');

        // $data = SupplyItemList::latest()->get();
      return view('admin.order.list',compact('data'));
    }
       public function get_supply_filter_data(Request $request)
    {
      
       $item_type=$request->value;

       $user_id=Sentinel::getUser()->id;
       $registered_fanchise=FanchiseRegistration::where('fanchise_id','=',$user_id)->first();


       if($item_type=='all')
       {
   $data = DB::table('brand_wise_products')
            ->join('master_products', 'master_products.id', '=', 'brand_wise_products.product_id')
            ->where([['brand_wise_products.brand_id','=',(int)$registered_fanchise->brands],['master_products.supply_for','=',1]])
            ->select('master_products.*', 'brand_wise_products.initial_qty', 'brand_wise_products.brand_id')
            ->get()
            ->groupBy('item_type');
       }
       else
       {

         $data = DB::table('brand_wise_products')
            ->join('master_products', 'master_products.id', '=', 'brand_wise_products.product_id')
            ->where([['brand_wise_products.brand_id','=',(int)$registered_fanchise->brands],['master_products.supply_for','=',1],['master_products.item_type','=',$item_type]])
            ->select('master_products.*', 'brand_wise_products.initial_qty', 'brand_wise_products.brand_id')
            ->get()
            ->groupBy('item_type');

       }
      
    $options = view('admin.order.get_supply_filter_data',compact('data'))->render();
    echo $options;
    }
  public function add_to_cart(Request $request)
    {
    $item_id=CustomHelpers::custom_decrypt($request->item_id);
    $fanchise_id=Sentinel::getUser()->id;
    $data_check=SupplyCart::where([['fanchise_id','=',$fanchise_id],['item_id','=',$item_id]])->first();
    if($data_check==''):
    $data =new SupplyCart;
    $data->fanchise_id=$fanchise_id;
    $data->item_id=$item_id;
    $data->qty=1;
    $data->save();
     
  $button='<span class="minus"  cart_id="'.CustomHelpers::custom_encrypt($data->id).'">-</span>
  <input type="text" class="count" value="1"/>
  <span class="plus" cart_id="'.CustomHelpers::custom_encrypt($data->id).'">+</span>';

  $count_data=SupplyCart::where([['fanchise_id','=',$fanchise_id]])->get();
   $count=count($count_data);
   $output=['count'=>$count,'button'=>$button];
          return $output;
    endif;
    }
   //add_to_cart
   public function add_supply_to_cart(Request $request)
    {
        $cart_id=$request->cart_id;
        $cart_id=CustomHelpers::custom_decrypt($cart_id);
       $button='';
       $get_all_item_subtotal_with_gst=0;
        $subtotal=0;
        if($request->new_value==0):
        $previous_data=SupplyCart::find($cart_id); 
        $button='<button class="btn btn-success add_to_cart" item_id="'.CustomHelpers::custom_encrypt($previous_data->item_id).'">Add</button>';    
        SupplyCart::destroy($cart_id); 
       
        else:
       $cart=SupplyCart::find($cart_id); 
        $cart->qty=$request->new_value;
        $cart->save();
      $subtotal=CustomHelpers::get_item_subtotal_with_gst_with_transport($cart->id);
        endif;
       $fanchise_id=Sentinel::getUser()->id;
       $cart=SupplyCart::where('fanchise_id','=',$fanchise_id)->get(); 
$get_all_item_subtotal_with_gst=CustomHelpers::get_all_item_subtotal_with_gst();

        
          $output=['count'=>count($cart),'button'=>$button,'subtotal'=>$subtotal,'get_all_item_subtotal_with_gst'=>$get_all_item_subtotal_with_gst];
          return $output;
    
   

    }
    public function order_placed()
    {
    $fanchise_id=Sentinel::getUser()->id;
    $carts=SupplyCart::where('fanchise_id','=',$fanchise_id)->get();
     return view('admin.order.order_placed',compact('carts')); 

    }
    public function order_checkout()
    {
    $fanchise_id=Sentinel::getUser()->id;
    $carts=SupplyCart::where('fanchise_id','=',$fanchise_id)->get();
     return view('admin.order.order_checkout',compact('carts')); 

    }
    public function index()
    {
      
    // $csv=url("public/uploads/utensil_lists.csv");
    // $rows=array();
    // $rows=file($csv);
    // $data_size=sizeof($rows);
    //   dd($rows);
   //  foreach($rows as $row):
   //      $data_array=explode(",",$row);
   //  if(sizeof($data_array)>4): 
   // $data=new SupplyItemList;

   // $data->product_name=$data_array['4'];
   // $data->initial_qty=$data_array['5'];
   // $data->unit=$data_array['8'];
   // $data->item_type=$data_array['9'];
   // $data->rate_margin=$data_array['10'];
   // $data->rate_fanchise=$data_array['11'];
   // $data->thumb=$data_array['13'];
   //    if(sizeof($data_array)>14):
   // $data->description=$data_array['14'];
     
   // $data->gst_id=$data_array['15'];
   //    endif;
   // $data->save();

   // endif;


   //   endforeach;
   //  dd($rows);


      $brands=Brands::all();
      return view('admin.supply_list.index',compact('brands'));
    }
     public function supplylist(Request $request)
    {
        if ($request->ajax()) {

            $brand=$request->brand;
            if($brand=='NA')
            {
                $data = SupplyItemList::latest()->get();
            }
            else
            {
               $data = SupplyItemList::where('thumb','=',(int)$brand)->get();
            }
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                  
          $image_data=ItemImages::where([['item_id','=',$row->id],['default','=',1],['image_type','=',1]])->first();
          if($image_data!='' && $image_data->thumb!=''):
            $path=url('public/uploads/item/thumb/'.$image_data->thumb);
                    $image = '<img src="'.$path.'" width="100px">';
          else:
           $image = 'NA';
          endif;
                    return $image;
                })
                ->addColumn('gst', function($row){
                  
             if($row->gst_id!=''):
          $gst_data=MasterGst::find($row->gst_id);
          if($gst_data!='')
          {
            return $gst_data->gst_name;
          }
          else
          {
            return 'Not Updated';
          }
                 
             else:
                return 'Not Updated';
             endif;
                })
                ->addColumn('unit', function($row){
                 if($row->unit!=''):
          $unit=Unit::find($row->unit);
                 return $unit->unit;
             else:
                return 'Not Updated';
             endif;
                    
                })
                  ->addColumn('thumb', function($row){
                 if($row->thumb!=''):
          $thumb=Brands::find($row->thumb);
                 return $thumb->brand;
             else:
                return 'Not Updated';
             endif;
                    
                })
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn = '<a href="#"><button type="button" class="btn btn-primary btn-sm uploads" id="'.$id.'"><i class="fas fa-edit"></i>  Uploads</button></a> 
                    <a href="#" id="'.$id.'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> 
                    <a href="'.url('SupplyList-Delete/'.$id).'" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action','image','gst','unit'])
                ->make(true);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loged_user=Sentinel::getUser();
        $gsts=MasterGst::all();
        $vendors = User::where([['registration_level','=',5],['parent_id','=',$loged_user->parent_id]])->whereIn('status',[1,2])->get();
        $brands=Brands::all();
        $units=Unit::all();
        $factories=Stores::where('type','=',2)->whereIn('status',[1,2])->get();  
        return view('admin.supply_list.create',compact('gsts','vendors','brands','units','factories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       $request->validate([
            "product_name"=>"required",
           
         
            ]);
        $data=new SupplyItemList;

        $data->item_type=$request->item_type;
        $data->gst_id=$request->gst_id;
        $data->product_name=$request->product_name;
        $data->unit=$request->unit;
        $data->thumb=$request->thumb;
        $data->rate_margin=$request->rate_margin;
        $data->rate_fanchise=$request->rate_fanchise;
        $data->initial_qty=$request->initial_qty;
        $data->threshold_qty=$request->threshold_qty;  
        $data->description=$request->description;
        $data->user_id=Sentinel::getUser()->id;
        $data->system_ip=CustomHelpers::get_ip();
        if($data->save())
        {
            
    
       
        if ($request->has('vendor')){
         $vendors=$request->vendor;
         if(count($vendors)>0)
         {
            foreach($vendors as $vendor)
            {
              $vendor_data=new AssignProductFactoryVendor;
              $vendor_data->factory_vendor_id=$vendor;
              $vendor_data->product_id=$data->id;
              $vendor_data->type='vendor';
              $vendor_data->save();
            }
         }
           }
         //
           if ($request->has('factory')){
         $factories=$request->factory;
         if(count($factories)>0)
         {
            foreach($factories as $factory)
            {
              $factory_data=new AssignProductFactoryVendor;
              $factory_data->factory_vendor_id=$factory;
              $factory_data->product_id=$data->id;
              $factory_data->type='factory';
              $factory_data->save();
            }
         }
     }
         //
         $stores=Stores::where('type','=',1)->whereIn('status',[1,2])->get();
         foreach($stores as $store)
         {
         $store_product=new StoreProduct;
         $store_product->store_id=$store->id;
         $store_product->product_id=$data->id;
         $store_product->threshold_qty=$data->threshold_qty;
         $store_product->available_qty=$data->initial_qty;
         $store_product->bal_qty=$data->initial_qty-$data->threshold_qty;
         $store_product->save(); 
         }

        }
        
        return redirect()->route("supplyitem_list")->with("success","List Successfully Added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupplyItemList  $supplyItemList
     * @return \Illuminate\Http\Response
     */
    public function show(SupplyItemList $supplyItemList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupplyItemList  $supplyItemList
     * @return \Illuminate\Http\Response
     */
    
    public function edit_supply_list(Request $request)
   {
    $id=CustomHelpers::custom_decrypt($request->id);
    $loged_user=Sentinel::getUser();
    $gsts=MasterGst::all();
    $vendors = User::where([['registration_level','=',5],['parent_id','=',$loged_user->parent_id]])->whereIn('status',[1,2])->get();
    $brands=Brands::all();
    $units=Unit::all();
    $factories=Stores::where('type','=',2)->whereIn('status',[1,2])->get(); 
     $data=SupplyItemList::find($id); 
    $options = view('admin.supply_list.edit',compact('data','gsts','vendors','brands','units','factories'))->render();
    echo $options;


   }
    public function edit($id,SupplyItemList $supplyItemList)
    {
        $id=CustomHelpers::custom_decrypt($id);
       
        if (SupplyItemList::where('id', $id)->exists()) 
        {
        $loged_user=Sentinel::getUser();
        $gsts=MasterGst::all();
        $vendors = User::where([['registration_level','=',5],['parent_id','=',$loged_user->parent_id]])->whereIn('status',[1,2])->get();
        $brands=Brands::all();
        $units=Unit::all();
        $factories=Stores::where('type','=',2)->whereIn('status',[1,2])->get();  

    
         $data=SupplyItemList::find($id);
          return view('admin.supply_list.edit',compact('data','gsts','vendors','brands','units','factories'));
        }
        else
        {
       return redirect()->route("supplyitem_list")->with("success","No Data Found");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SupplyItemList  $supplyItemList
     * @return \Illuminate\Http\Response
     */
    public function update_supply_list(Request $request)
    {
      $id=CustomHelpers::custom_decrypt($request->id);   
       $request->validate([
            "product_name"=>"required",
           
         
            ]);

        if (SupplyItemList::where('id', $id)->exists()) 
        {
         $data=SupplyItemList::find($id);
         $data->item_type=$request->item_type;
           $data->gst_id=$request->gst_id;
        $data->product_name=$request->product_name;
        $data->unit=$request->unit;
        $data->thumb=$request->thumb;
        $data->rate_margin=$request->rate_margin;
        $data->rate_fanchise=$request->rate_fanchise;

        $data->description=$request->description;
        $data->user_id=Sentinel::getUser()->id;
        $data->system_ip=CustomHelpers::get_ip();

        
         if($data->save())
        {
            
         $previous_datas=AssignProductFactoryVendor::where('product_id','=',$id)->whereIn('type',['vendor','factory'])->get();
         foreach($previous_datas as $previous_data)
         {
           AssignProductFactoryVendor::destroy($previous_data->id);
         }
       
        if ($request->has('vendor')){
         $vendors=$request->vendor;
         if(count($vendors)>0)
         {
            
            foreach($vendors as $vendor)
            {

              $vendor_data=new AssignProductFactoryVendor;
              $vendor_data->factory_vendor_id=$vendor;
              $vendor_data->product_id=$data->id;
              $vendor_data->type='vendor';
              $vendor_data->save();


            }
         }
           }
         //
           if ($request->has('factory')){
         $factories=$request->factory;

         if(count($factories)>0)
         {
            foreach($factories as $factory)
            {
              $factory_data=new AssignProductFactoryVendor;
              $factory_data->factory_vendor_id=$factory;
              $factory_data->product_id=$data->id;
              $factory_data->type='factory';
              $factory_data->save();
            }
         }
        }
         //
         $stores=Stores::where('type','=',1)->whereIn('status',[1,2])->get();
         foreach($stores as $store)
         {
         $check_data=StoreProduct::where([['store_id','=',$store->id],['product_id','=',$data->id]])->first();
         if($check_data==''):
         $store_product=new StoreProduct;
         $store_product->store_id=$store->id;
         $store_product->product_id=$data->id;
         $store_product->threshold_qty=$data->threshold_qty;
         $store_product->available_qty=$data->initial_qty;
         $store_product->bal_qty=$data->initial_qty-$data->threshold_qty;
         $store_product->save(); 
        endif;
         }

        }

         echo 'success';
        }
        else
        {
       echo 'error';
        }
    }
    public function update($id,Request $request, SupplyItemList $supplyItemList)
    {
       $id=CustomHelpers::custom_decrypt($id);
         $request->validate([
            "product_name"=>"required",
           
         
            ]);

        if (SupplyItemList::where('id', $id)->exists()) 
        {
         $data=SupplyItemList::find($id);
         $data->item_type=$request->item_type;
           $data->gst_id=$request->gst_id;
        $data->product_name=$request->product_name;
        $data->unit=$request->unit;
        $data->thumb=$request->thumb;
        $data->rate_margin=$request->rate_margin;
        $data->rate_fanchise=$request->rate_fanchise;

        $data->description=$request->description;
        $data->user_id=Sentinel::getUser()->id;
        $data->system_ip=CustomHelpers::get_ip();
        $data->save();
        
         if($data->save())
        {
            
         $previous_datas=AssignProductFactoryVendor::where('product_id','=',$id)->get();
         foreach($previous_datas as $previous_data)
         {
           AssignProductFactoryVendor::destroy($previous_data->id);
         }
       
        if ($request->has('vendor')){
         $vendors=$request->vendor;
         if(count($vendors)>0)
         {
            
            foreach($vendors as $vendor)
            {

              $vendor_data=new AssignProductFactoryVendor;
              $vendor_data->factory_vendor_id=$vendor;
              $vendor_data->product_id=$data->id;
              $vendor_data->type='vendor';
              $vendor_data->save();


            }
         }
           }
         //
           if ($request->has('factory')){
         $factories=$request->factory;

         if(count($factories)>0)
         {
            foreach($factories as $factory)
            {
              $factory_data=new AssignProductFactoryVendor;
              $factory_data->factory_vendor_id=$factory;
              $factory_data->product_id=$data->id;
              $factory_data->type='factory';
              $factory_data->save();
            }
         }
        }
        

        }

        return redirect()->route("supplyitem_list")->with("success","List Successfully Updated");
        }
        else
        {
       return redirect()->route("supplyitem_list")->with("success","No Data Found");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupplyItemList  $supplyItemList
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,SupplyItemList $supplyItemList)
    {
        $id=CustomHelpers::custom_decrypt($id);
       
        if (SupplyItemList::where('id', $id)->exists()) 
        {
          SupplyItemList::destroy($id);
         return redirect()->route('supplyitem_list')->with('success',"List Successfully Deleted");
        }
        else
        {
       return redirect()->route("supplyitem_list")->with("success","No Data Found");
        }
    }
}
