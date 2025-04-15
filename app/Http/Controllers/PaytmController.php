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

class PaytmController extends Controller
{
    public function store_paytm(Request $request)
    {
       $cart_datas=FirstTimeStockCart::where([['fanchise_id','=',Sentinel::getUser()->id],['payment_status','=',0],['qty','>',0],['purchase_from','=','Central Supply']])->get();
        $cart_item_id=[];
        $total=0;
        foreach($cart_datas as $cart_data):
          $gst_data=MasterGst::find($cart_data->gst_id);

                    if($cart_data->purchase_from=='Central Supply'):
                    $total=$total+$cart_data->amount;
                
                    endif;
                     if($gst_data=='')
          {
            $cart_item_id[]=[
                     'product_id'=>$cart_data->list_id,
                     'product_name'=>CustomHelpers::get_list_data($cart_data->list_id,'product_name'),
                     'product_rate'=>CustomHelpers::get_list_data($cart_data->list_id,'franchise_rate'),
                     'product_gst'=>0,
                     
                     'qty'=>$cart_data->qty,
                      ]; 
          }
          else
          {
            $cart_item_id[]=[
                     'product_id'=>$cart_data->list_id,
                     'product_name'=>CustomHelpers::get_list_data($cart_data->list_id,'product_name'),
                     'product_rate'=>CustomHelpers::get_list_data($cart_data->list_id,'franchise_rate'),
                     'product_gst'=>$gst_data->gst_value,
                     
                     'qty'=>$cart_data->qty,
                      ]; 
          }
          

         endforeach;
        $order_id=time();
        $amount=round($total);
        $id=Sentinel::getUser()->id;
        $payment=new FanchisePayment;

        $payment->fanchise_id=$id;
        $payment->date=date('Y-m-d');
        $payment->system_ip=CustomHelpers::get_ip();
        $payment->cart_item_id=serialize($cart_item_id);
        // $payment->transaction_id=$response->id;
        $payment->amount=$amount;
        // $payment->currency=$response->currency;
        $payment->status=0;
        // $payment->method=$response->method;
        // $payment->email=$response->email;
        // $payment->contact=$response->contact;
        $payment->order_id=$order_id;
        $payment->save();


      
       $data_for_request=$this->handlePaytmRequest($order_id , $amount);
       $paytm_txn_url = env('TXN_URL');
       $paramList = $data_for_request['paramList'];
       $checkSum = $data_for_request['checkSum'];
       return view("admin.payment.merchantform",compact('paytm_txn_url', 'paramList', 'checkSum'));


    }
    public function paytmcallback(Request $request)
    {
       $order_id = $request['ORDERID'];
       if('TXN_SUCCESS' === $request['STATUS'])
       {

        $id=Sentinel::getUser()->id;
        $cart_datas=FirstTimeStockCart::where([['fanchise_id','=',Sentinel::getUser()->id],['payment_status','=',0],['qty','>',0],['purchase_from','=','Central Supply']])->get();
        $cart_item_id=[];
        foreach($cart_datas as $cart_data):
        $new_cart=FirstTimeStockCart::find($cart_data->id);
        
        $new_cart->payment_status=1;
        $new_cart->save();
        
        endforeach;


            $transaction_id = $request['TXNID'];
            $data = FanchisePayment::where( 'order_id', $order_id )->first();
            $data->status = 1;
            $data->transaction_id = $transaction_id;
            $data->method = $request['PAYMENTMODE'];
            $data->save();
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
        
            return redirect('Fanchise-Account')->with('success', 'Payment successful');

       }
       elseif ('TXN_FAILURE' === $request['STATUS'])
       {
        // return view("payment.fail");
        return redirect('Fanchise-Account')->with('error','Transaction Fail');
        // return  Redirect::to('/')->with('error','Transaction Fail');
       }
    }

  //supplychain
 public function order_payment(Request $request)
    {
       
        $total=round(CustomHelpers::get_all_item_subtotal_with_gst()-CustomHelpers::get_franchise_previous_credit_bal(Sentinel::getUser()->id));
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
          $amount=round($total);
        $orderpayment=new OrderPayment;

        $orderpayment->fanchise_id=$id;
        $orderpayment->date=date('Y-m-d');
        $orderpayment->system_ip=CustomHelpers::get_ip();
        $orderpayment->cart_item=serialize($cart_item);
        $orderpayment->payment_status=0;
        $orderpayment->amount=$amount;
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


       $data_for_request=$this->handlePaytmRequest_second($order_id , $amount);
       $paytm_txn_url = env('TXN_URL');
       $paramList = $data_for_request['paramList'];
       $checkSum = $data_for_request['checkSum'];
       return view("admin.payment.merchantform",compact('paytm_txn_url', 'paramList', 'checkSum'));


    }
    public function paytmcallback_supplychain(Request $request)
    {
       $order_id = $request['ORDERID'];
       if('TXN_SUCCESS' === $request['STATUS'])
       {

        $id=Sentinel::getUser()->id;
         try {
            $transaction_id = $request['TXNID'];
          
          $payment_data=OrderPayment::where('order_no', $order_id )->first();
          $payment_data->payment_status=1;
          $payment_data->transaction_id=$transaction_id;
         
          $payment_data->currency='INR';
         // $payment->status=$response->status;
          $payment_data->method=$request['PAYMENTMODE'];
          
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
           
          $data = OrderPayment::find($payment_data->id);
      // Mail::send('email.order_mail', compact('data'), function($message) {
      //    $message->to('rajeshgoit@gmail.com', 'New Order Mail')->subject
      //       ('New Order Mail');
      //    $message->from('xyz@gmail.com','Rajesh Goit');
      // });
           
               // 
            } 
            catch (Exception $e) {
                return  $e->getMessage();
               
                return redirect('Newly-Order')->with('error', $e->getMessage());
                
            }



        return redirect('Newly-Order')->with('success', 'Payment successful');

       }
       elseif ('TXN_FAILURE' === $request['STATUS'])
       {
        // return view("payment.fail");
        return redirect('Newly-Order')->with('error','Transaction Fail');
        // return  Redirect::to('/')->with('error','Transaction Fail');
       }
    }
    public function handlePaytmRequest_second( $order_id, $amount ) {
        // Load all functions of encdec_paytm.php and config-paytm.php
        $this->getAllEncdecFunc();
        $this->getConfigPaytmSettings();
        $checkSum = "";
        $paramList = array();
        // Create an array having all required parameters for creating checksum.
        $paramList["MID"] = 'oCBNGY29884450185562';
        $paramList["ORDER_ID"] = $order_id;
        $paramList["CUST_ID"] = Sentinel::getUser()->id;
        $paramList["INDUSTRY_TYPE_ID"] = 'Retail';
        $paramList["CHANNEL_ID"] = 'WEB';
        $paramList["TXN_AMOUNT"] = $amount;
        $paramList["WEBSITE"] = 'WEBSTAGING';
        $paramList["CALLBACK_URL"] = url( '/paytm-callback-supplychain' );
        $paytm_merchant_key = 'ISEhSF_%p@&NI67n';
        //Here checksum string will return by getChecksumFromArray() function.
        $checkSum = getChecksumFromArray( $paramList, $paytm_merchant_key );
        return array(
            'checkSum' => $checkSum,
            'paramList' => $paramList
        );
    }
    //
    public function handlePaytmRequest( $order_id, $amount ) {
        // Load all functions of encdec_paytm.php and config-paytm.php
        $this->getAllEncdecFunc();
        $this->getConfigPaytmSettings();
        $checkSum = "";
        $paramList = array();
        // Create an array having all required parameters for creating checksum.
        $paramList["MID"] = 'oCBNGY29884450185562';
        $paramList["ORDER_ID"] = $order_id;
        $paramList["CUST_ID"] = Sentinel::getUser()->id;
        $paramList["INDUSTRY_TYPE_ID"] = 'Retail';
        $paramList["CHANNEL_ID"] = 'WEB';
        $paramList["TXN_AMOUNT"] = $amount;
        $paramList["WEBSITE"] = 'WEBSTAGING';
        $paramList["CALLBACK_URL"] = url( '/paytm-callback' );
        $paytm_merchant_key = 'ISEhSF_%p@&NI67n';
        //Here checksum string will return by getChecksumFromArray() function.
        $checkSum = getChecksumFromArray( $paramList, $paytm_merchant_key );
        return array(
            'checkSum' => $checkSum,
            'paramList' => $paramList
        );
    }
       function getAllEncdecFunc()
   {
function encrypt_e($input, $ky) {
    $key   = html_entity_decode($ky);
    $iv = "@@@@&&&&####$$$$";
    $data = openssl_encrypt ( $input , "AES-128-CBC" , $key, 0, $iv );
    return $data;
}
function decrypt_e($crypt, $ky) {
    $key   = html_entity_decode($ky);
    $iv = "@@@@&&&&####$$$$";
    $data = openssl_decrypt ( $crypt , "AES-128-CBC" , $key, 0, $iv );
    return $data;
}
function generateSalt_e($length) {
    $random = "";
    srand((double) microtime() * 1000000);
    $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
    $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
    $data .= "0FGH45OP89";
    for ($i = 0; $i < $length; $i++) {
        $random .= substr($data, (rand() % (strlen($data))), 1);
    }
    return $random;
}
function checkString_e($value) {
    if ($value == 'null')
        $value = '';
    return $value;
}
function getChecksumFromArray($arrayList, $key, $sort=1) {
    if ($sort != 0) {
        ksort($arrayList);
    }
    $str = getArray2Str($arrayList);
    $salt = generateSalt_e(4);
    $finalString = $str . "|" . $salt;
    $hash = hash("sha256", $finalString);
    $hashString = $hash . $salt;
    $checksum = encrypt_e($hashString, $key);
    return $checksum;
}
function getChecksumFromString($str, $key) {
    $salt = generateSalt_e(4);
    $finalString = $str . "|" . $salt;
    $hash = hash("sha256", $finalString);
    $hashString = $hash . $salt;
    $checksum = encrypt_e($hashString, $key);
    return $checksum;
}
function verifychecksum_e($arrayList, $key, $checksumvalue) {
    $arrayList = removeCheckSumParam($arrayList);
    ksort($arrayList);
    $str = getArray2StrForVerify($arrayList);
    $paytm_hash = decrypt_e($checksumvalue, $key);
    $salt = substr($paytm_hash, -4);
    $finalString = $str . "|" . $salt;
    $website_hash = hash("sha256", $finalString);
    $website_hash .= $salt;
    $validFlag = "FALSE";
    if ($website_hash == $paytm_hash) {
        $validFlag = "TRUE";
    } else {
        $validFlag = "FALSE";
    }
    return $validFlag;
}
function verifychecksum_eFromStr($str, $key, $checksumvalue) {
    $paytm_hash = decrypt_e($checksumvalue, $key);
    $salt = substr($paytm_hash, -4);
    $finalString = $str . "|" . $salt;
    $website_hash = hash("sha256", $finalString);
    $website_hash .= $salt;
    $validFlag = "FALSE";
    if ($website_hash == $paytm_hash) {
        $validFlag = "TRUE";
    } else {
        $validFlag = "FALSE";
    }
    return $validFlag;
}
function getArray2Str($arrayList) {
    $findme   = 'REFUND';
    $findmepipe = '|';
    $paramStr = "";
    $flag = 1;
    foreach ($arrayList as $key => $value) {
        $pos = strpos($value, $findme);
        $pospipe = strpos($value, $findmepipe);
        if ($pos !== false || $pospipe !== false)
        {
            continue;
        }
        if ($flag) {
            $paramStr .= checkString_e($value);
            $flag = 0;
        } else {
            $paramStr .= "|" . checkString_e($value);
        }
    }
    return $paramStr;
}
function getArray2StrForVerify($arrayList) {
    $paramStr = "";
    $flag = 1;
    foreach ($arrayList as $key => $value) {
        if ($flag) {
            $paramStr .= checkString_e($value);
            $flag = 0;
        } else {
            $paramStr .= "|" . checkString_e($value);
        }
    }
    return $paramStr;
}
function redirect2PG($paramList, $key) {
    $hashString = getchecksumFromArray($paramList);
    $checksum = encrypt_e($hashString, $key);
}
function removeCheckSumParam($arrayList) {
    if (isset($arrayList["CHECKSUMHASH"])) {
        unset($arrayList["CHECKSUMHASH"]);
    }
    return $arrayList;
}
function getTxnStatus($requestParamList) {
    return callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
}
function getTxnStatusNew($requestParamList) {
    return callNewAPI(PAYTM_STATUS_QUERY_NEW_URL, $requestParamList);
}
function initiateTxnRefund($requestParamList) {
    $CHECKSUM = getRefundChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY,0);
    $requestParamList["CHECKSUM"] = $CHECKSUM;
    return callAPI(PAYTM_REFUND_URL, $requestParamList);
}
function callAPI($apiURL, $requestParamList) {
    $jsonResponse = "";
    $responseParamList = array();
    $JsonData =json_encode($requestParamList);
    $postData = 'JsonData='.urlencode($JsonData);
    $ch = curl_init($apiURL);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($postData))
    );
    $jsonResponse = curl_exec($ch);
    $responseParamList = json_decode($jsonResponse,true);
    return $responseParamList;
}
function callNewAPI($apiURL, $requestParamList) {
    $jsonResponse = "";
    $responseParamList = array();
    $JsonData =json_encode($requestParamList);
    $postData = 'JsonData='.urlencode($JsonData);
    $ch = curl_init($apiURL);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($postData))
    );
    $jsonResponse = curl_exec($ch);
    $responseParamList = json_decode($jsonResponse,true);
    return $responseParamList;
}
function getRefundChecksumFromArray($arrayList, $key, $sort=1) {
    if ($sort != 0) {
        ksort($arrayList);
    }
    $str = getRefundArray2Str($arrayList);
    $salt = generateSalt_e(4);
    $finalString = $str . "|" . $salt;
    $hash = hash("sha256", $finalString);
    $hashString = $hash . $salt;
    $checksum = encrypt_e($hashString, $key);
    return $checksum;
}
function getRefundArray2Str($arrayList) {
    $findmepipe = '|';
    $paramStr = "";
    $flag = 1;
    foreach ($arrayList as $key => $value) {
        $pospipe = strpos($value, $findmepipe);
        if ($pospipe !== false)
        {
            continue;
        }
        if ($flag) {
            $paramStr .= checkString_e($value);
            $flag = 0;
        } else {
            $paramStr .= "|" . checkString_e($value);
        }
    }
    return $paramStr;
}
function callRefundAPI($refundApiURL, $requestParamList) {
    $jsonResponse = "";
    $responseParamList = array();
    $JsonData =json_encode($requestParamList);
    $postData = 'JsonData='.urlencode($JsonData);
    $ch = curl_init($apiURL);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_URL, $refundApiURL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $jsonResponse = curl_exec($ch);
    $responseParamList = json_decode($jsonResponse,true);
    return $responseParamList;
}
   }
    //
    function getConfigPaytmSettings()
   {
    /*
- Use PAYTM_ENVIRONMENT as 'PROD' if you wanted to do transaction in production environment else 'TEST' for doing transaction in testing environment.
- Change the value of PAYTM_MERCHANT_KEY constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_MID constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_WEBSITE constant with details received from Paytm.
- Above details will be different for testing and production environment.
*/
define('PAYTM_ENVIRONMENT', 'TEST'); // PROD
define('PAYTM_MERCHANT_KEY', 'ISEhSF_%p@&NI67n'); //Change this constant's value with Merchant key received from Paytm.
define('PAYTM_MERCHANT_MID', 'oCBNGY29884450185562'); //Change this constant's value with MID (Merchant ID) received from Paytm.
define('PAYTM_MERCHANT_WEBSITE', 'WEBSTAGING'); //Change this constant's value with Website name received from Paytm.
$PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
$PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';
if (PAYTM_ENVIRONMENT == 'PROD') {
    $PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
    $PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';
}
define('PAYTM_REFUND_URL', '');
define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_TXN_URL', $PAYTM_TXN_URL);
   }
}
