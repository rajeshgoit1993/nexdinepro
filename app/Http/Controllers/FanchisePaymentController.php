<?php

namespace App\Http\Controllers;

use App\Models\FanchisePayment;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Session;
use Exception;
use App\Models\FanchiseRegistration;
use App\Models\FanchiseRegistrationStep;
use App\Models\RegistrationActivityStatus;
use App\Notifications\UserWelcomeNotification;
use App\Models\OrderItemDetails;
use App\Models\Role;
use App\Models\User;
use App\Helpers\CustomHelpers;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use App\Models\PreLaunch;
use App\Models\PreLaunchDoc;
use App\Models\UtensilList;
use App\Models\FirstTimeStockCart;
use App\Models\ItemImages;
use Validator;
use Sentinel;
use DB;
use PDF;
use App\Models\OrderPayment;
use App\Models\SupplyCart;
use App\Models\MasterGst;
use App\Models\FranchiseCreditHistory;
use Mail;

class FanchisePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise')):

    $fanchise_detail=User::where('id','=',Sentinel::getUser()->id)->first();
           
            
     $cart_datas=FirstTimeStockCart::where([['fanchise_id','=',Sentinel::getUser()->id],['payment_status','=',0],['qty','>',0],['purchase_from','=','Central Supply']])->get(); 
     return view('admin.payment.fanchisepayment',compact('cart_datas','fanchise_detail')); 
     
       endif;

         
    }
    
   public function update_collection_admin(Request $request)
   {
     $id=$request->id;
      $payment_data=FanchisePayment::find($id);
      $payment_data->collection_status=1;
      $payment_data->items_send_date=$request->items_send_date;
      $payment_data->item_send_system_date=date('Y-m-d');
      $payment_data->items_send_remarks=$request->items_send_remarks;
      $payment_data->save();
       //RegistrationActivityStatus
        $registration_status=new RegistrationActivityStatus;
        $registration_status->fanchise_id=$payment_data->fanchise_id;
        $registration_status->activity_from_id=Sentinel::getUser()->id;
        $registration_status->activity='Admin Update Collection Details';
        $registration_status->remarks='';
        $registration_status->system_ip=CustomHelpers::get_ip();
        $registration_status->date=date('d-m-Y');
        $registration_status->save();

        echo 'success';

   }
   public function update_collection_fanchise(Request $request)
   {
     $id=$request->id;
      $payment_data=FanchisePayment::find($id);
      $payment_data->collection_status=2;
      $payment_data->items_received_date=$request->items_received_date;
      $payment_data->item_received_system_date=date('Y-m-d');
      $payment_data->items_received_remarks=$request->items_received_remarks;
      $payment_data->save();
      //
      $registered_fanchise=FanchiseRegistration::where('fanchise_id','=',$payment_data->fanchise_id)->first();
        $registered_fanchise->procurement_status=4;
        $registered_fanchise->save();
       //RegistrationActivityStatus
        $registration_status=new RegistrationActivityStatus;
        $registration_status->fanchise_id=$payment_data->fanchise_id;
        $registration_status->activity_from_id=Sentinel::getUser()->id;
        $registration_status->activity='Fanchise Update Items Received Details';
        $registration_status->remarks='';
        $registration_status->system_ip=CustomHelpers::get_ip();
        $registration_status->date=date('d-m-Y');
        $registration_status->save();

        echo 'success';

   }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function invoice($id,Request $request)
    {
        $id=$id;
        $id=CustomHelpers::custom_decrypt($id);
         // $data=FirstTimeStockCart::where([['fanchise_id','=',$id],['payment_status','=',1],['qty','>',0],['purchase_from','=','Central Supply']])->get();
         $data=FanchisePayment::where('fanchise_id','=',$id)->first();
         
        $fanchise_detail =User::find($id);
         $payment_datas=FanchisePayment::where('fanchise_id','=',$id)->first();
        $pdf = PDF::loadView('admin.invoice.first_stock_invoice', compact('data','payment_datas','fanchise_detail'))->setPaper('a4', 'landscape');;
     
        return $pdf->download('invoice.pdf',);

    }
    public function order_invoice($id)
    {
   $id=CustomHelpers::custom_decrypt($id);
   $data=OrderPayment::find($id);
   $fanchise_detail =User::find($data->fanchise_id);
   $pdf = PDF::loadView('admin.invoice.order_invoice', compact('data','fanchise_detail'))->setPaper('a4', 'portrait');;
     
        return $pdf->download($fanchise_detail->name.'_invoice.pdf',);
        // return view('admin.invoice.order_invoice', compact('data','fanchise_detail'));
    }
     public function product_invoice($id)
    {
   $id=CustomHelpers::custom_decrypt($id);
   $data=OrderItemDetails::find($id);
   $fanchise_detail =User::find($data->fanchise_id);
   $payment_details=OrderPayment::where('id','=',$data->order_id)->first();
   $pdf = PDF::loadView('admin.invoice.product_invoice', compact('data','fanchise_detail','payment_details'))->setPaper('a4', 'landscape');;
     
        return $pdf->download('invoice.pdf',);
       // return view('admin.invoice.order_invoice', compact('data','fanchise_detail'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store_payment(Request $request)
    {
        $input = $request->all();
  
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
  
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
  
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 

               //
        $id=Sentinel::getUser()->id;
        $cart_datas=FirstTimeStockCart::where([['fanchise_id','=',Sentinel::getUser()->id],['payment_status','=',0],['qty','>',0],['purchase_from','=','Central Supply']])->get();
        $cart_item_id=[];
        foreach($cart_datas as $cart_data):
        $new_cart=FirstTimeStockCart::find($cart_data->id);
        
         $gst_data=MasterGst::find($cart_data->gst_id);
         $cart_item_id[]=[
                     'product_id'=>$cart_data->list_id,
                     'product_name'=>CustomHelpers::get_list_data($cart_data->list_id,'product_name'),
                     'product_rate'=>CustomHelpers::get_list_data($cart_data->list_id,'franchise_rate'),
                     'product_gst'=>$gst_data->gst_value,
                     
                     'qty'=>$cart_data->qty,
                      ]; 

        $new_cart->payment_status=1;
        $new_cart->save();
        
        endforeach;
         //
        $payment=new FanchisePayment;

        $payment->fanchise_id=$id;
        $payment->date=date('Y-m-d');
        $payment->system_ip=CustomHelpers::get_ip();
        $payment->cart_item_id=serialize($cart_item_id);
        $payment->transaction_id=$response->id;
        $payment->amount=$response->amount/100;
        $payment->currency=$response->currency;
        $payment->status=$response->status;
        $payment->method=$response->method;
        $payment->email=$response->email;
        $payment->contact=$response->contact;
        $payment->save();
        //
        $data=FanchiseRegistration::where('fanchise_id','=',$id)->first();
        $data->procurement_status=2;
       
        $data->save();
        //activity status
        $registration_status=new RegistrationActivityStatus;
        $registration_status->fanchise_id=$id;
        $registration_status->activity_from_id=Sentinel::getUser()->id;
        $registration_status->activity='Payment Completed By Franchise';
        $registration_status->remarks='';
        $registration_status->system_ip=CustomHelpers::get_ip();
        $registration_status->date=date('d-m-Y');
        $registration_status->save();

               // 
            } 
            catch (Exception $e) {
                return  $e->getMessage();
               
                return redirect('Fanchise-Account')->with('error', $e->getMessage());
                
            }
        }
        return redirect('Fanchise-Account')->with('success', 'Payment successful');
          
        
    }

    public function store_payment_supplychain(Request $request)
    {
        $input = $request->all();
         //

        $id=Sentinel::getUser()->id;
       
      $cart_datas=SupplyCart::where('fanchise_id','=',$id)->get();
       if(count($cart_datas)==0)
       {
        return redirect('Newly-Order')->with('success', 'This payment has already been captured');
       }
        $cart_item=[];
        foreach($cart_datas as $cart_data):
         $gst_id=CustomHelpers::get_product_data($cart_data->item_id,'gst_id');
          $gst_data=MasterGst::find($gst_id);
          
          if($gst_data=='')
          {
           $gst_value=0;
          }
          else
          {
            $gst_value=$gst_data->gst_value;
          }

         $cart_item[]=[
                     'product_id'=>$cart_data->item_id,
                     'product_name'=>CustomHelpers::get_product_data($cart_data->item_id,'product_name'),
                     'product_rate'=>CustomHelpers::get_product_data($cart_data->item_id,'franchise_rate'),
                     'company_rate'=>CustomHelpers::get_product_data($cart_data->item_id,'company_rate'),
                     'unit'=>CustomHelpers::get_product_data($cart_data->item_id,'unit'),
                     'gst_value'=>$gst_value,
                     'gst_id'=>$gst_id,
                     'tranport_charge'=>CustomHelpers::get_transport_fee($id,CustomHelpers::get_product_data($cart_data->item_id,'unit')),
                     'qty'=>$cart_data->qty,
                      ]; 
       SupplyCart::destroy($cart_data->id);
        
        endforeach;
         $order_id=time();
        $orderpayment=new OrderPayment;

        $orderpayment->fanchise_id=$id;
        $orderpayment->date=date('Y-m-d');
        $orderpayment->system_ip=CustomHelpers::get_ip();
        $orderpayment->cart_item=serialize($cart_item);
        //

        $sentinel_user=Sentinel::findById($id);
        $state=$sentinel_user->state;
        $dist=$sentinel_user->dist;
        $city=$sentinel_user->city;
        $setting_data=DB::table('store_settings')->where('id','=',1)->first();
         if($setting_data->status==0)
        {
        $store=DB::table('stores')->whereIn('status',[1,2])->first();
        }
               else
               {
               $store=DB::table('stores')->where([['type','=',1],['state','=',$state],['dist','=',$dist],['city','=',$city]])->whereIn('status',[1,2])->first();
                }
        if($store!=''):
        if($store->state==$state):
            //igst
        $orderpayment->gst_type=1;
        $orderpayment->assign_order_to_warehouse_id=$store->id;
        $orderpayment->assign_order_to_warehouse_date==date('Y-m-d');
        else:
             //cgst
        $orderpayment->gst_type=0;
        $orderpayment->assign_order_to_warehouse_id=$store->id;
        $orderpayment->assign_order_to_warehouse_date==date('Y-m-d');       
        endif;
        endif;
        //
        
        $orderpayment->order_no=$order_id;
        $orderpayment->save();

        //OrderItemDetails
        foreach($cart_item as $item)
        {
             $gst_amount=$item['gst_value']*$item['product_rate']/100;
             $new_item=new OrderItemDetails;
             $new_item->order_id=$orderpayment->id;
             $new_item->fanchise_id=Sentinel::getUser()->id;
             $new_item->user_id=Sentinel::getUser()->id;
             $new_item->system_ip=CustomHelpers::get_ip();
             $new_item->product_id=$item['product_id'];
             $new_item->product_name=$item['product_name'];
             $new_item->product_rate=$item['product_rate'];
             $new_item->company_rate=$item['company_rate'];
             $new_item->unit_id=$item['unit'];
             $new_item->gst_id=$item['gst_value'];
             $new_item->order_qty=$item['qty'];
             $new_item->order_confirm_qty=$item['qty'];
             $new_item->amount=$item['qty']*((float)$item['product_rate']+(float)$gst_amount+(float)$item['tranport_charge']);
             $new_item->transport_rate=$item['tranport_charge'];
             $new_item->save();
        }

         //


        //
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
  
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
  
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
          
          $payment_data=OrderPayment::find($orderpayment->id);
          $payment_data->payment_status=1;
          $payment_data->transaction_id=$response->id;
          $payment_data->amount=$response->amount/100;
          $payment_data->currency=$response->currency;
         // $payment->status=$response->status;
          $payment_data->method=$response->method;
          $payment_data->email=$response->email;
          $payment_data->contact=$response->contact;
          //previous deduct credit
          $previous_credit=CustomHelpers::get_franchise_previous_credit_bal($payment_data->fanchise_id);
          if($previous_credit>0):
          $previous_credit_data=new FranchiseCreditHistory;
           $previous_credit_data->franchise_id=$payment_data->fanchise_id;
           $previous_credit_data->credit=0;
           $previous_credit_data->debit=$previous_credit;
           $previous_credit_data->remaining_bal=0;
           $previous_credit_data->action_user_id=Sentinel::getUser()->id;
           $previous_credit_data->remarks='Amount Adjust in new order';
           $previous_credit_data->save();
          endif;
          //
          $payment_data->save(); 
           
           $credit_history=new FranchiseCreditHistory;
           $credit_history->franchise_id=$payment_data->fanchise_id;
           $credit_history->credit=$payment_data->amount;
           $credit_history->debit=$payment_data->amount;
           $credit_history->remaining_bal=0;
           $credit_history->action_user_id=Sentinel::getUser()->id;
           $credit_history->remarks='new order payment';
           $credit_history->save();
            //
          $data = OrderPayment::find($orderpayment->id);
      Mail::send('email.order_mail', compact('data'), function($message) {
         $message->to('rajeshgoit@gmail.com', 'New Order Mail')->subject
            ('New Order Mail');
         $message->from('xyz@gmail.com','Rajesh Goit');
      });
           
               // 
            } 
            catch (Exception $e) {
                return  $e->getMessage();
               
                return redirect('Newly-Order')->with('error', $e->getMessage());
                
            }
        }
        return redirect('Newly-Order')->with('success', 'Payment successful');
          
        
    }
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FanchisePayment  $fanchisePayment
     * @return \Illuminate\Http\Response
     */
    public function show(FanchisePayment $fanchisePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FanchisePayment  $fanchisePayment
     * @return \Illuminate\Http\Response
     */
    public function edit(FanchisePayment $fanchisePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FanchisePayment  $fanchisePayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FanchisePayment $fanchisePayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FanchisePayment  $fanchisePayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(FanchisePayment $fanchisePayment)
    {
        //
    }
}
