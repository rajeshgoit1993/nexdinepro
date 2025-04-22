<?php

namespace App\Http\Controllers;

use App\Models\FanchiseRegistration;
use App\Models\FanchiseRegistrationStep;
use App\Models\RegistrationActivityStatus;
use App\Notifications\UserWelcomeNotification;
use Illuminate\Http\Request;
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
use App\Models\StoreDetails;
use App\Models\ItemImages;
use Validator;
use App\Models\PageAccess;
use App\Models\Brands;
use App\Models\MasterProduct;
use Sentinel;
use DB;
use DataTables;
use Session;
use App\Models\FranchiseCreditHistory;
use App\Models\OrderPayment;
use Activation;
use PDF;



class FanchiseRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new_registration()
    {
    $all_roles = Role::whereIn('slug',['fanchise'])->get();
    $states=State::all();
    $brands=Brands::all();
    return view('admin.fanchises.new_registration',compact('all_roles','states','brands'));
    }
     public function new_work_list()
    {
    
      $id=Sentinel::getUser()->id;
      $role=DB::table('role_users')->where('user_id','=',$id)->first();
      $role_id=$role->role_id;
      $page_acess=PageAccess::where('role_id','=',$role_id)->first();
      if($page_acess!=''):
       
          if($page_acess->new_registration==1):

          $all_roles = Role::whereIn('slug',['fanchise','masterfanchise'])->get();
          $states=State::all();
      return redirect('New-Registration');
  
          else:

           $role_wise_array=['prelaunch_action'=>$page_acess->prelaunch_date,
                        'fanchise_status'=>$page_acess->fanchise_data,
                        'architect_status'=>$page_acess->architect,
                        'social_media_status'=>$page_acess->social,
                        'procurement_status'=>$page_acess->procurement,
                        'operations_status'=>$page_acess->operations,
                        'accounts_status'=>$page_acess->accounts,
                        ];
        

        foreach($role_wise_array as $row=>$col):
           if($col==0):
$new_query[]=[$row,'=',$col];
           endif;
        endforeach;    
          

            $query = DB::table('fanchise_registrations')
               ->join('users','fanchise_registrations.fanchise_id' , '=', 'users.id')
            ->where(function ($query) use ($role_wise_array) {
        foreach ($role_wise_array as $row=>$col)
        {
            // you can use orWhere the first time, doesn't need to be ->where
               if($col==1 && $row=='prelaunch_action'):
             $query->orWhere([[$row,'=',0],['status','=',5],['active_status','=',1]]);
               elseif($col==1 && ($row=='fanchise_status' || $row=='architect_status' || $row=='social_media_status' || $row=='procurement_status' || $row=='operations_status' || $row=='accounts_status')):
                $query->orWhere([[$row,'=',0],['status','=',6],['active_status','=',1]]);
             endif;
           }
         })
           ->get();
           $data=$query;
           
       
            
        return view('admin.new_work_list.index',compact('data'));
          endif;
      else:
          
    return view('admin.dashboard.index_blank');

      endif;
   
    }
    
    
   
   
    public function get_chart_data(Request $request)
    {
     $id=$request->id;
     $id=CustomHelpers::custom_decrypt($id);
      $fanchise_detail =FanchiseRegistration::where('fanchise_id','=',$id)->first();
      //franchise_part
      if($fanchise_detail->fanchise_status==0):
         //pending
      $franchise_color='#f56954';
      elseif($fanchise_detail->fanchise_status==1):
        //complete
       $franchise_color='#00a65a';
        elseif($fanchise_detail->fanchise_status==2):
        //ongoing
       $franchise_color='#ffc107';
        endif;
     //architect_part
      if($fanchise_detail->architect_status==0):
         //pending
      $architect_color='#f56954';
      elseif($fanchise_detail->architect_status==1):
         //ongoing
       $architect_color='#ffc107';
       
        elseif($fanchise_detail->architect_status==2):
        //complete
       $architect_color='#00a65a';
        endif;

         //social_part
      if($fanchise_detail->social_media_status==0):
         //pending
      $social_color='#f56954';
      elseif($fanchise_detail->social_media_status==1):
         //ongoing
       $social_color='#ffc107';
       
        elseif($fanchise_detail->social_media_status==2):
        //complete
       $social_color='#00a65a';
        endif;
         //procurement_part
      if($fanchise_detail->procurement_status==0):
         //pending
      $procurement_color='#f56954';
      elseif($fanchise_detail->procurement_status==1 || $fanchise_detail->procurement_status==2 || $fanchise_detail->procurement_status==3):
         //ongoing
       $procurement_color='#ffc107';
       
        elseif($fanchise_detail->procurement_status==4):
        //complete
       $procurement_color='#00a65a';
        endif;
          //operations_part
      if($fanchise_detail->operations_status==0):
         //pending
      $operations_color='#f56954';
      elseif($fanchise_detail->operations_status==1):
         //ongoing
       $operations_color='#ffc107';
       
        elseif($fanchise_detail->operations_status==2):
        //complete
       $operations_color='#00a65a';
        endif;
          //accounts_part
      if($fanchise_detail->accounts_status==0):
         //pending
      $accounts_color='#f56954';
     
        elseif($fanchise_detail->accounts_status==1):
        //ongoing
       $accounts_color='#ffc107';
   elseif($fanchise_detail->accounts_status==2):
        //complete
       $accounts_color='#00a65a';
        endif;
          //agreementstatus_part
      if($fanchise_detail->agreementstatus==0 || $fanchise_detail->agreementstatus==''):
         //pending
      $agreement_color='#f56954';
      elseif($fanchise_detail->agreementstatus==1):
         //ongoing
       $agreement_color='#ffc107';
       
        elseif($fanchise_detail->agreementstatus==2):
        //complete
       $agreement_color='#00a65a';
        endif;
        //local_purchase_status_part
      if($fanchise_detail->local_purchase_status==0 || $fanchise_detail->local_purchase_status==2):
         //pending
      $local_purchase_color='#f56954';
      elseif($fanchise_detail->local_purchase_status==1):
     //complete
       $local_purchase_color='#00a65a';
       
        endif;
     //

        $data=['franchise_color'=>$franchise_color,'architect_color'=>$architect_color,'social_color'=>$social_color,'procurement_color'=>$procurement_color,'operations_color'=>$operations_color,'accounts_color'=>$accounts_color,'agreement_color'=>$agreement_color,'local_purchase_color'=>$local_purchase_color];
        return $data;
    }
    public function date_change(Request $request)
    {
       $id=CustomHelpers::custom_decrypt($request->id);
        $fanchise_detail =FanchiseRegistration::where('fanchise_id','=',$id)->first();
        $fanchise_detail->fanchise_end_date=$request->fanchise_end_date;
        $fanchise_detail->save();
        //RegistrationActivityStatus
        $registration_status=new RegistrationActivityStatus;
        $registration_status->fanchise_id=$fanchise_detail->fanchise_id;
        $registration_status->activity_from_id=Sentinel::getUser()->id;
        $registration_status->activity='Admin Update Launch Date';
        $registration_status->remarks='';
        $registration_status->system_ip=CustomHelpers::get_ip();
        $registration_status->date=date('d-m-Y');
        $registration_status->save();
        echo 'success';
    }
       public function survey_update(Request $request)
    {
       $id=CustomHelpers::custom_decrypt($request->id);
        //
        $new_user = Sentinel::findById($id);
       
         
        $new_data['status']=7;
         Sentinel::update($new_user, $new_data);  

        $fanchise_detail =FanchiseRegistration::where('fanchise_id','=',$id)->first();
        $fanchise_detail->survey_date=$request->survey_date;
        $fanchise_detail->survey_system_date=date('Y-m-d');
        $fanchise_detail->survey_remarks=$request->survey_remarks;
        $fanchise_detail->survey_admin_id=Sentinel::getUser()->id;
        $fanchise_detail->survey_admin_system_ip=CustomHelpers::get_ip();
        $fanchise_detail->save();
        //RegistrationActivityStatus
        $registration_status=new RegistrationActivityStatus;
        $registration_status->fanchise_id=$fanchise_detail->fanchise_id;
        $registration_status->activity_from_id=Sentinel::getUser()->id;
        $registration_status->activity='Admin Update Launch Date';
        $registration_status->remarks='';
        $registration_status->system_ip=CustomHelpers::get_ip();
        $registration_status->date=date('d-m-Y');
        $registration_status->save();
        echo 'success';
    }
     public function check_survey_condation(Request $request)
    {
       $id=CustomHelpers::custom_decrypt($request->id);
        $fanchise_detail =FanchiseRegistration::where('fanchise_id','=',$id)->first();
        $fanchise_end_date=$fanchise_detail->fanchise_end_date;
        $today=date('Y-m-d');
        if($today<$fanchise_end_date):
         $output=' <input type="hidden" name="id" id="fanchise_id" value="'.$request->id.'">  
         <div class="row">
    <div class="col-md-12">
     <div class="form-group">
          <label for="">Survey Date</label>
          <input type="date" name="survey_date" id="survey_date" class="form-control" placeholder="Survey Date" value="">
          <span id="error_survey_date" class="text-danger"></span>
        </div>
 </div>
 <div class="col-md-12">
     <div class="form-group">
          <label for="">Remarks</label>
          <textarea name="survey_remarks" id="survey_remarks" class="form-control" placeholder="Survey  Remarks"></textarea>
     
          <span id="error_survey_remarks" class="text-danger"></span>
        </div>
 </div>


 
 
  </div><br>

 <button type="button"  id="update_survey" class="btn btn-info btn-lg">Save</button>';
  echo $output;
        else:
            echo 'Kindly Change Launch Date First';
        endif;
        
    }

    public function get_fanchise_launch_data(Request $request)
    {
        $id=CustomHelpers::custom_decrypt($request->id);
        $fanchise_detail =FanchiseRegistration::where('fanchise_id','=',$id)->first();
      

        $output='

         <input type="hidden" name="id" id="fanchise_id" value="'.$request->id.'">      
<div class="row">
   
 <div class="col-md-12">
     <div class="form-group">
          <label for="">Launch Date</label>
          <input type="date" name="fanchise_end_date" id="fanchise_end_date" class="form-control" placeholder="Launch  Date" value="'.$fanchise_detail->fanchise_end_date.'">
          <span id="error_fanchise_end_date" class="text-danger"></span>
        </div>
 </div>


 
 
  </div>
<br>

 <button type="button"  id="update_date" class="btn btn-info btn-lg">Save</button>
           ';

           echo $output;
    }
     public function update_amount(Request $request)
    {
        $id=CustomHelpers::custom_decrypt($request->id);
        $fanchise_detail =FanchiseRegistration::find($id);
    
        $fanchise_detail->booking_amount=$request->booking_amount;
        $fanchise_detail->gst=$request->gst;
        $fanchise_detail->gst_percentage=$request->gst_percentage;
        $fanchise_detail->gst_amount=$request->gst_amount;
        $fanchise_detail->total_booking_amount=$request->total_booking_amount;
        $fanchise_detail->royality_amount=$request->royality_amount;
       
        $fanchise_detail->first_installment=$request->first_installment;
        $fanchise_detail->first_installment_date=$request->first_installment_date;
        $fanchise_detail->seoond_installment=$request->seoond_installment;
        $fanchise_detail->second_installment_date=$request->second_installment_date;
        $fanchise_detail->third_installment=$request->third_installment;
        $fanchise_detail->third_installment_date=$request->third_installment_date;
        $fanchise_detail->total_received_amount=$request->total_received_amount;
        $fanchise_detail->total_pending_amount=$request->total_pending_amount;
  
        $fanchise_detail->balance_amount=$request->balance_amount;
       
        $fanchise_detail->advance=$request->advance;
        $fanchise_detail->advance_date=$request->advance_date;
        $fanchise_detail->mode_of_advance=$request->mode_of_advance;
        $fanchise_detail->ref_no_advance=$request->ref_no_advance;
        $fanchise_detail->mode_of_first_installment=$request->mode_of_first_installment;
        $fanchise_detail->ref_first_installment=$request->ref_first_installment;
        $fanchise_detail->mode_of_second_installment=$request->mode_of_second_installment;
        $fanchise_detail->ref_no_second_installment=$request->ref_no_second_installment;
        $fanchise_detail->mode_of_third_installment=$request->mode_of_third_installment;
        $fanchise_detail->ref_no_third_installment=$request->ref_no_third_installment;

         $fanchise_detail->advance_received=$request->advance_reveived;
         $fanchise_detail->advance_received_date=$request->advance_reveived_date;
         if($request->advance_reveived!=''):
         $fanchise_detail->advance_system_date=date('Y-m-d');
          endif;
         $fanchise_detail->first_installment_received=$request->first_installment_reveived;
         $fanchise_detail->first_installment_received_date=$request->first_installment_reveived_date;
          if($request->first_installment_reveived!=''):
         $fanchise_detail->first_installment_received_system_date=date('Y-m-d');
         endif;
         $fanchise_detail->second_installment_received=$request->second_installment_reveived;
         $fanchise_detail->second_installment_received_date=$request->second_installment_reveived_date;
          if($request->second_installment_reveived!=''):
         $fanchise_detail->second_installment_received_system_date=date('Y-m-d');
         endif;
         $fanchise_detail->third_installment_received=$request->third_installment_reveived;
         $fanchise_detail->third_installment_received_date=$request->third_installment_reveived_date;
          if($request->third_installment_reveived!=''):
         $fanchise_detail->third_installment_received_system_date=date('Y-m-d');

         endif;
         $fanchise_detail->save();
         //RegistrationActivityStatus
        $registration_status=new RegistrationActivityStatus;
        $registration_status->fanchise_id=$fanchise_detail->id;
        $registration_status->activity_from_id=Sentinel::getUser()->id;
        $registration_status->activity='Update Fanchise Fee Amount';
        $registration_status->remarks='';
        $registration_status->system_ip=CustomHelpers::get_ip();
        $registration_status->date=date('d-m-Y');
        $registration_status->save();

        echo 'success';

    }
    public function get_fanchise_basic_data(Request $request)
    {
$id=CustomHelpers::custom_decrypt($request->id);
$fanchise_detail=User::where('id','=',$id)->first();

$options = view("admin.fanchises.accordian",compact('fanchise_detail'))->render();


echo $options;
    }
    public function get_booking_amount_data(Request $request)
    {
    $id=CustomHelpers::custom_decrypt($request->id);
    $fanchise_detail =FanchiseRegistration::find($id);

     $output='
<div class="row">
<div class="col-lg-3">
   <div class="form-group">
    <input type="hidden" name="id" id="page_data" value="'.$request->id.'"> 
         <label>Enter Amount</label>
         <input type="text"  name="booking_amount" id="booking_amount" class="booking_amount form-control number_test" placeholder="Enter Amount" value="'.$fanchise_detail->booking_amount.'"/>
         <span id="error_booking_amount" class="text-danger"></span>
        </div>
        </div>
<div class="col-lg-3">
<div class="form-group">
         <label>Discount</label>
         <input type="text"  name="discount_amount" id="discount_amount" class="form-control number_test discount_amount"  placeholder="Discount Amount" value="'.$fanchise_detail->discount_amount.'"/>
        <!--  <span id="error_total_booking_amount" class="text-danger"></span> -->
        </div>
</div>

<div class="col-lg-3">
   <select class="form-control gst" name="gst" style="display: none;" >

<option value="1">Fixed</option>
<option value="2" selected>Percentage</option>
</select>
<input type="text" class="form-control number_test gst_percentage" name="gst_percentage" placeholder="Enter GST Percentage" style="padding: 5px;color: #4a4a4a;min-width: 60px;display:none" value="18">
  <input type="text" name="gst_amount" id="gst_amount " class="form-control number_test gst_amount" placeholder="GST Value"  style="display:none;" />
         <span id="error_gst_amount" class="text-danger"></span>
<div class="form-group">
         <label>Total Booking Amount(Inc GST)</label>
         <input type="text" name="total_booking_amount" id="total_booking_amount" class="form-control number_test total_booking_amount" readonly placeholder="Total Booking Amount" value="'.$fanchise_detail->total_booking_amount.'" />
         <span id="error_total_booking_amount" class="text-danger"></span>
        </div>
</div>

<div class="col-lg-3">
<div class="form-group">
         <label>Balance Amount</label>
         <input type="text" name="balance_amount" id="balance_amount" class="form-control number_test balance_amount" readonly placeholder="Balance Amount" value="'.$fanchise_detail->balance_amount.'"/>
        <!--  <span id="error_total_booking_amount" class="text-danger"></span> -->
        </div>

</div>

</div>
   

<h4>Amount Receiving Part</h4>
 <div class="row">
   <div class="col-lg-2">
       <label>Advance</label>

<input type="text" value="'.$fanchise_detail->advance.'" class="form-control number_test advance" name="advance" id="advance" placeholder="advance Payment" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
<span id="error_advance" class="text-danger"></span>
</div>
<div class="col-lg-2">
 <div class="form-group">
        <label>Advance Date</label>

<input type="date" value="'.$fanchise_detail->advance_date.'" class="form-control" name="advance_date" id="advance_date" placeholder="First Instalment Date" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_advance_date" class="text-danger"></span> 
        </div>
</div>

<div class="col-lg-2">
 <div class="form-group">
        <label>Received Amount</label>

<input type="text" value="'.$fanchise_detail->advance_received.'" class="form-control number_test advance_reveived" name="advance_reveived" id="advance_reveived" placeholder="Received Amount" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_advance_reveived" class="text-danger"></span> 
        </div>
</div>
<div class="col-lg-2">
 <div class="form-group">
        <label>Received Date</label>

<input type="date" value="'.$fanchise_detail->advance_received_date.'" class="form-control" name="advance_reveived_date" id="advance_reveived_date" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_advance_reveived_date" class="text-danger"></span> 
        </div>
</div>


<div class="col-lg-2">
 <div class="form-group">
        <label>Mode of Payment</label>

<input type="text" value="'.$fanchise_detail->mode_of_advance.'" class="form-control" name="mode_of_advance" id="mode_of_advance" placeholder="Mode of Payment" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_mode_of_advance" class="text-danger"></span> 
        </div>
</div>
<div class="col-lg-2">
 <div class="form-group">
        <label>Ref No</label>

<input type="text" value="'.$fanchise_detail->ref_no_advance.'" class="form-control" name="ref_no_advance" id="ref_no_advance" placeholder="Ref No" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_ref_no_advance" class="text-danger"></span> 
        </div>
</div>
<!---->
  <div class="col-lg-2">
       <label>First Instalment</label>

<input type="text" value="'.$fanchise_detail->first_installment.'" class="form-control number_test first_installment" name="first_installment" id="first_installment" placeholder="First Instalment Payment" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
<span id="error_first_installment" class="text-danger"></span>
</div>
<div class="col-lg-2">
 <div class="form-group">
        <label>First Instalment Date</label>

<input type="date" value="'.$fanchise_detail->first_installment_date.'"  class="form-control" name="first_installment_date" id="first_installment_date" placeholder="First Instalment Date" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_first_installment_date" class="text-danger"></span> 
        </div>
</div>
<div class="col-lg-2">
 <div class="form-group">
        <label>Received Amount</label>

<input type="text" value="'.$fanchise_detail->first_installment_received.'"  class="form-control number_test first_installment_reveived" name="first_installment_reveived" id="first_installment_reveived" placeholder="Received Amount" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_first_installment_reveived" class="text-danger"></span> 
        </div>
</div>
<div class="col-lg-2">
 <div class="form-group">
        <label>Received Date</label>

<input type="date" value="'.$fanchise_detail->first_installment_received_date.'"  class="form-control" name="first_installment_reveived_date" id="first_installment_reveived_date" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_first_installment_reveived_date" class="text-danger"></span> 
        </div>
</div>

<div class="col-lg-2">
 <div class="form-group">
        <label>Mode of Payment</label>

<input type="text" value="'.$fanchise_detail->mode_of_first_installment.'" class="form-control" name="mode_of_first_installment" id="mode_of_first_installment" placeholder="Mode of Payment" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_mode_of_first_installment" class="text-danger"></span> 
        </div>
</div>
<div class="col-lg-2">
 <div class="form-group">
        <label>Ref No</label>

<input type="text" value="'.$fanchise_detail->ref_first_installment.'"  class="form-control" name="ref_first_installment" id="ref_first_installment" placeholder="Ref No" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_ref_first_installment" class="text-danger"></span> 
        </div>
</div>
<!---->
  <div class="col-lg-2">
       <label>Second Instalment</label>

<input type="text" value="'.$fanchise_detail->seoond_installment.'" class="form-control number_test seoond_installment" name="seoond_installment" id="seoond_installment" placeholder="Second Instalment Payment" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
 <span id="error_seoond_installment" class="text-danger"></span> 
</div>
<div class="col-lg-2">
 <div class="form-group">
        <label>Second Instalment Date</label>

<input type="date"  value="'.$fanchise_detail->second_installment_date.'" class="form-control" name="second_installment_date" id="second_installment_date" placeholder="Second Instalment Date" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
     <span id="error_second_installment_date" class="text-danger"></span>   
        </div>
</div>
<div class="col-lg-2">
 <div class="form-group">
        <label>Received Amount</label>

<input type="text" value="'.$fanchise_detail->second_installment_received.'" class="form-control number_test second_installment_reveived" name="second_installment_reveived" id="second_installment_reveived" placeholder="Received Amount" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_second_installment_reveived" class="text-danger"></span> 
        </div>
</div>
<div class="col-lg-2">
 <div class="form-group">
        <label>Received Date</label>

<input type="date"  value="'.$fanchise_detail->second_installment_received_date.'" class="form-control" name="second_installment_reveived_date" id="second_installment_reveived_date" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_second_installment_reveived_date" class="text-danger"></span> 
        </div>
</div>
<div class="col-lg-2">
 <div class="form-group">
        <label>Mode of Payment</label>

<input type="text"  value="'.$fanchise_detail->mode_of_second_installment.'"  class="form-control" name="mode_of_second_installment" id="mode_of_second_installment" placeholder="Mode of Payment" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_mode_of_second_installment" class="text-danger"></span> 
        </div>
</div>
<div class="col-lg-2">
 <div class="form-group">
        <label>Ref No</label>

<input type="text" value="'.$fanchise_detail->ref_no_second_installment.'" class="form-control" name="ref_no_second_installment" id="ref_no_second_installment" placeholder="Ref No" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_ref_no_second_installment" class="text-danger"></span> 
        </div>
</div>
<!---->
  <div class="col-lg-2">
       <label>Third Instalment</label>

<input type="text" value="'.$fanchise_detail->third_installment.'" class="form-control number_test third_installment" name="third_installment" id="third_installment" placeholder="Third Instalment Payment" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
<span id="error_third_installment" class="text-danger"></span>   
</div>
<div class="col-lg-2">
 <div class="form-group">
        <label>Third Instalment Date</label>

<input type="date"  value="'.$fanchise_detail->third_installment_date.'" class="form-control" name="third_installment_date" id="third_installment_date" placeholder="Third Instalment Date" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_third_installment_date" class="text-danger"></span>   
        </div>
</div>
<div class="col-lg-2">
 <div class="form-group">
        <label>Received Amount</label>

<input type="text" value="'.$fanchise_detail->third_installment_received.'" class="form-control number_test third_installment_reveived" name="third_installment_reveived" id="third_installment_reveived" placeholder="Received Amount" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_third_installment_reveived" class="text-danger"></span> 
        </div>
</div>
<div class="col-lg-2">
 <div class="form-group">
        <label>Received Date</label>

<input type="date" value="'.$fanchise_detail->third_installment_received_date.'" class="form-control" name="third_installment_reveived_date" id="third_installment_reveived_date" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_third_installment_reveived_date" class="text-danger"></span> 
        </div>
</div>

<div class="col-lg-2">
 <div class="form-group">
        <label>Mode of Payment</label>

<input type="text" value="'.$fanchise_detail->mode_of_third_installment.'" class="form-control" name="mode_of_third_installment" id="mode_of_third_installment" placeholder="Mode of Payment" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_mode_of_third_installment" class="text-danger"></span> 
        </div>
</div>
<div class="col-lg-2">
 <div class="form-group">
        <label>Ref No</label>

<input type="text" value="'.$fanchise_detail->ref_no_third_installment.'" class="form-control" name="ref_no_third_installment" id="ref_no_third_installment" placeholder="Ref No" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_ref_no_ref_no_third_installment" class="text-danger"></span> 
        </div>
</div>
<!---->
<div class="col-lg-4">
  <div class="form-group">
         <label>Total Amount Installments</label>
         <input type="text" name="total_installments_amount" id="total_installments_amount" class="form-control number_test total_installments_amount" readonly placeholder="Total  Amount Received" value="'.CustomHelpers::get_amount($fanchise_detail->id,'installment').'" />
         <span id="error_total_installments_amount" class="text-danger"></span>
        </div>
</div>
<div class="col-lg-4">
  <div class="form-group">
         <label>Total Amount Received</label>
         <input type="text" name="total_received_amount" id="total_received_amount" class="form-control number_test total_received_amount" readonly placeholder="Total  Amount Received" value="'.CustomHelpers::get_amount($fanchise_detail->id,'received').'" />
         <span id="error_total_received_amount" class="text-danger"></span>
        </div>
</div>

<div class="col-lg-4">
  <div class="form-group">
         <label>Total Pending Amount</label>
         <input type="text" value="'.CustomHelpers::get_amount($fanchise_detail->id,'balance').'" name="total_pending_amount" id="total_pending_amount" class="form-control number_test total_pending_amount" readonly placeholder="Total Pending Amount" />
         <span id="error_total_pending_amount" class="text-danger"></span>
        </div>
</div>';
echo $output;
    }
    public function pushback_request()
    
    {
        $data=User::whereIn('registration_level',[2,1])
            ->where('status','=',3)->get();
        return view('admin.fanchises.pushback_request',compact('data'));
    }
     public function replied_request()
    {
        $data=User::whereIn('registration_level',[2,1])
            ->where('status','=',4)->get();
        return view('admin.fanchises.replied_request',compact('data'));
    }
    public function active_status(Request $request)
    {
        $id=$request->id;
        $status=$request->status_value;
        if($status==1)
        {
        $sentinal_user=Sentinel::findById($id);
        $activation = Activation::create($sentinal_user);
        Activation::complete($sentinal_user, $activation->code);
        }
        else
        {
        
        $sentinal_user=Sentinel::findById($id);
        Activation::remove($sentinal_user);
        }
        $data=User::find($id);
        $data->active_status=$status;
        $data->save();
        echo 'success';
    }

    public function ongoing_request()
    {
     if(Sentinel::getUser()->inRole('superadmin')):
     $data=User::whereIn('registration_level',[2,1])
            ->whereNotIn('status',[0,1,3,4,7])->get();
        return view('admin.fanchises.ongoing_request',compact('data'));
     elseif(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise')):
      return Redirect::back()->with('error', 'Access Denied');
     else:
     
     endif;
      $id=Sentinel::getUser()->id;
      $role=DB::table('role_users')->where('user_id','=',$id)->first();
      $role_id=$role->role_id;
      $page_acess=PageAccess::where('role_id','=',$role_id)->first();
      if($page_acess!=''):
      if($page_acess->new_registration==1):
          $data=User::whereIn('registration_level',[2,1])
            ->whereNotIn('status',[0,1,3,4,7])->get();
        return view('admin.fanchises.ongoing_request',compact('data'));
          elseif($page_acess->prelaunch_date==1 || $page_acess->fanchise_data==1 || $page_acess->architect==1 || $page_acess->social==1 || $page_acess->procurement==1 || $page_acess->operations==1 || $page_acess->accounts==1):

      $role_wise_array=['prelaunch_action'=>$page_acess->prelaunch_date,
                        'fanchise_status'=>$page_acess->fanchise_data,
                        'architect_status'=>$page_acess->architect,
                        'social_media_status'=>$page_acess->social,
                        'procurement_status'=>$page_acess->procurement,
                        'operations_status'=>$page_acess->operations,
                        'accounts_status'=>$page_acess->accounts,
                        ];
         $new_query[]=['status','=',6];     
        foreach($role_wise_array as $row=>$col):
           if($col==1):
$new_query[]=[$row,'>=',$col];
           endif;
        endforeach;
        $data = DB::table('fanchise_registrations')
               ->join('users','fanchise_registrations.fanchise_id' , '=', 'users.id')
            ->where($new_query)
            ->get();                 
      
      
      return view('admin.fanchises.ongoing_request',compact('data'));

     endif;
      else:
     return Redirect::back()->with('error', 'Access Denied');
      endif;

      
    }
      public function get_lunched_franchise(Request $request)
    {
        if ($request->ajax()) {
           
            $type=$request->type;
            if($type==1)
            {
              if(Sentinel::getUser()->inRole('superadmin')):
        $data=DB::table('users')
           ->join('fanchise_registrations','fanchise_registrations.fanchise_id','=','users.id')
           ->whereIn('users.registration_level',[2,1])
           ->where([['users.active_status','=',1]])
           ->whereDate('fanchise_registrations.expire_date', '>=', date('Y-m-d'))
           ->select('users.*')
           ->latest()
           ->get();
     
       
     elseif(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise')):
     $data=[];
     else:
     $data=[];
     endif;
      $id=Sentinel::getUser()->id;
      $role=DB::table('role_users')->where('user_id','=',$id)->first();
      $role_id=$role->role_id;
      $page_acess=PageAccess::where('role_id','=',$role_id)->first();
      if($page_acess!=''):
      if($page_acess->new_registration==1):
          $data=DB::table('users')
           ->join('fanchise_registrations','fanchise_registrations.fanchise_id','=','users.id')
           ->whereIn('users.registration_level',[2,1])
           ->where([['users.active_status','=',1]])
           ->whereDate('fanchise_registrations.expire_date', '>=', date('Y-m-d'))
           ->select('users.*')
           ->latest()
           ->get();
       
          elseif($page_acess->prelaunch_date==1 || $page_acess->fanchise_data==1 || $page_acess->architect==1 || $page_acess->social==1 || $page_acess->procurement==1 || $page_acess->operations==1 || $page_acess->accounts==1):

                    
      $data=DB::table('users')
           ->join('fanchise_registrations','fanchise_registrations.fanchise_id','=','users.id')
           ->whereIn('users.registration_level',[2,1])
           ->where([['users.active_status','=',1]])
           ->whereDate('fanchise_registrations.expire_date', '>=', date('Y-m-d'))
           ->select('users.*')
           ->latest()
           ->get();

    

     endif;
      else:
  
      endif;


            }
            elseif($type==2)
            {

             if(Sentinel::getUser()->inRole('superadmin')):
        $data=DB::table('users')
           ->join('fanchise_registrations','fanchise_registrations.fanchise_id','=','users.id')
           ->whereIn('users.registration_level',[2,1])
           ->where([['users.active_status','=',1]])
           ->whereDate('fanchise_registrations.expire_date', '<', date('Y-m-d'))
           ->select('users.*')
           ->latest()
           ->get();
     

       
     elseif(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise')):
     $data=[];
     else:
     $data=[];
     endif;
      $id=Sentinel::getUser()->id;
      $role=DB::table('role_users')->where('user_id','=',$id)->first();
      $role_id=$role->role_id;
      $page_acess=PageAccess::where('role_id','=',$role_id)->first();
      if($page_acess!=''):
      if($page_acess->new_registration==1):
          $data=DB::table('users')
           ->join('fanchise_registrations','fanchise_registrations.fanchise_id','=','users.id')
           ->whereIn('users.registration_level',[2,1])
           ->where([['users.active_status','=',1]])
           ->whereDate('fanchise_registrations.expire_date', '<', date('Y-m-d'))
           ->select('users.*')
           ->latest()
           ->get();
        
          elseif($page_acess->prelaunch_date==1 || $page_acess->fanchise_data==1 || $page_acess->architect==1 || $page_acess->social==1 || $page_acess->procurement==1 || $page_acess->operations==1 || $page_acess->accounts==1):

                    
      $data=DB::table('users')
           ->join('fanchise_registrations','fanchise_registrations.fanchise_id','=','users.id')
           ->whereIn('users.registration_level',[2,1])
           ->where([['users.active_status','=',1]])
           ->whereDate('fanchise_registrations.expire_date', '<', date('Y-m-d'))
           ->select('users.*')
           ->latest()
           ->get();

     

     endif;
      else:

      endif;



            }
            elseif($type==3)
            {
              if(Sentinel::getUser()->inRole('superadmin')):
        $data=DB::table('users')
           ->join('fanchise_registrations','fanchise_registrations.fanchise_id','=','users.id')
           ->whereIn('users.registration_level',[2,1])
           ->where([['users.active_status','=',3]])
         
           ->select('users.*')
           ->latest()
           ->get();
     
      
     elseif(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise')):
     $data=[];
     else:
     $data=[];
     endif;
      $id=Sentinel::getUser()->id;
      $role=DB::table('role_users')->where('user_id','=',$id)->first();
      $role_id=$role->role_id;
      $page_acess=PageAccess::where('role_id','=',$role_id)->first();
      if($page_acess!=''):
      if($page_acess->new_registration==1):
          $data=DB::table('users')
           ->join('fanchise_registrations','fanchise_registrations.fanchise_id','=','users.id')
           ->whereIn('users.registration_level',[2,1])
           ->where([['users.active_status','=',3]])
        
           ->select('users.*')
           ->latest()
           ->get();
       
          elseif($page_acess->prelaunch_date==1 || $page_acess->fanchise_data==1 || $page_acess->architect==1 || $page_acess->social==1 || $page_acess->procurement==1 || $page_acess->operations==1 || $page_acess->accounts==1):

                    
      $data=DB::table('users')
           ->join('fanchise_registrations','fanchise_registrations.fanchise_id','=','users.id')
           ->whereIn('users.registration_level',[2,1])
           ->where([['users.active_status','=',3]])
           
           ->select('users.*')
           ->latest()
           ->get();

     

     endif;
      else:

      endif;  
            }




            
            return Datatables::of($data)
                ->addIndexColumn()
               
                ->addColumn('basic_details', function($row){
                     $email=CustomHelpers::partiallyHideEmail($row->email);
                    $mobile=CustomHelpers::mask_mobile_no($row->mobile);  
                 $basic_details="<b>ID:</b> $email
                 <hr>
                 <b>Name:</b> $row->name
                 <hr>
                 <b>Mobile:</b> $mobile ";

                 if($row->active_status==1):
                        $basic_details.='<select class="active_status form-control">
                           <option value="1" selected>Active</option>

<option value="3" >Inactive</option>
    </select>';
                    elseif($row->active_status==2):
                        $basic_details.='<select class="active_status form-control">
                           <option value="1" >Active</option>

<option value="3" >Inactive</option>
    </select>';
                    elseif($row->active_status==3):
                        $basic_details.='<select class="active_status form-control">
                           <option value="1" >Active</option>

<option value="3" selected>Inactive</option>
    </select>';
                    endif;    
       $basic_details.='<input type="hidden" value="'.$row->id.'" class="fanchise_id">';

                    return $basic_details;
                })
                ->addColumn('location', function($row){
                   $location="<b>State:</b> $row->state
                             <hr>
                             <b>City:</b> $row->city";
                    return $location;
                    
                })
               ->addColumn('subscription', function($row){
$booking_data=DB::table('fanchise_registrations')->where('fanchise_id','=',$row->id)->first();
    if($booking_data->subscription_type==1):
$sub='Monthly';
else:
$sub='Yearly';
endif;
$avl_fund=CustomHelpers::get_franchise_previous_credit_bal($row->id);

                   $subscription="<b>Subscription Type : </b> $sub
                             <hr>
                             <b>Subscription Value :</b> $booking_data->subscription_value
                             <hr>
                             <b>Available Funds :</b> $avl_fund";
                    return $subscription;
                    
                })

               ->addColumn('expire_date', function($row){
                $booking_data=DB::table('fanchise_registrations')->where('fanchise_id','=',$row->id)->first();
                   $expire_date=date('d-m-Y', strtotime($booking_data->expire_date));
                    return $expire_date;
                    
                })

                 
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);
                     $path=preg_replace('/[<=>]+/', '',CustomHelpers::custom_encrypt($row->id));

                     $actionBtn = ' <a href="#" class="view" data-toggle="modal" data-target="#view_modal_$path" id="'.CustomHelpers::custom_encrypt($row->id).'"><button style="display:inline-block;margin-top:5px;width:100%"  class="btn btn-primary btn-sm"><span class="fa fa-eye"></span> View</button></a>
        

 <a href="#" class="edit" id="'.CustomHelpers::custom_encrypt($row->id).'"><button style="display:inline-block;margin-top:5px;width:100%"  class="btn btn-info btn-sm"><span class="fa fa-edit"></span> Edit</button></a>
<!--<a href="#">  <button type="button" style="display:inline-block;margin-top:5px;width:100%" class="btn btn-success btn-sm open_page" id="'.CustomHelpers::custom_encrypt($row->id).'">
                 <span class="fa fa-cog"></span> Menu Item
                  </button></a>-->';
 if(Sentinel::getUser()->inRole('superadmin')):
 $actionBtn.= '<a href="#" class="change_password"  id="'.CustomHelpers::custom_encrypt($row->id).'"><button class="btn btn-danger btn-sm" style="display:inline-block;margin-top:5px;width:100%"><span class="fas fa-key"></span> Change Password</button></a>

  <a href="#" class="add_fund"  id="'.CustomHelpers::custom_encrypt($row->id).'"><button class="btn btn-default btn-sm" style="display:inline-block;margin-top:5px;width:100%"><span class="fa fa-plus"></span> Add Fund</button></a>';
    endif;


                    
                    return $actionBtn;
                })
                ->rawColumns(['basic_details','location','subscription','expire_date','action'])
                ->make(true);
        }
    }


    public function expired_subscription()
    {
     $val=2;
      return view('admin.fanchises.launch_fanchise',compact('val'));

      
    }
    

     public function inactive()
    {
      $val=3;
      return view('admin.fanchises.launch_fanchise',compact('val'));
      
    }


    public function launch_fanchise()
    {
        $val=1;
      return view('admin.fanchises.launch_fanchise',compact('val'));
      
    }
    
     public function fanchise_account()
    {

    if(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise')):
    $data=DB::table('users')
           ->join('fanchise_registrations','fanchise_registrations.fanchise_id','=','users.id')
            ->whereIn('users.registration_level',[2,1])
            
            ->where('users.id','=',Sentinel::getUser()->id)->select('users.*','fanchise_registrations.expire_date','fanchise_registrations.aurthorise_person_id')->get();

       return view('outlet.myaccount.index',compact('data'));
       endif;
    }
     public function supply_order_payment()
    {

    if(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise')):
     $data=OrderPayment::where([['fanchise_id','=',Sentinel::getUser()->id],['payment_status','=',1]])->orderBy('created_at','DESC')->get();
       return view('outlet.order_payments.index',compact('data'));
       endif;
    }
    public function franchise_credit_history()
    {

    if(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise')):
    $data=FranchiseCreditHistory::where('franchise_id','=',Sentinel::getUser()->id)->orderBy('id','DESC')->get();
            
       return view('outlet.credit_history.index',compact('data'));
       endif;
    }
    public function my_account()
    {

   if(Sentinel::getUser()->inRole('store') || Sentinel::getUser()->inRole('vendor') || Sentinel::getUser()->inRole('factory')):
   $data=User::whereIn('registration_level',[4,5,6])
               ->where([['id','=',Sentinel::getUser()->id],['status','=',2]])->get();
    
          
       return view('admin.multidepartmentuser.store_account',compact('data'));
       endif;
    }
     public function kyc()
    {

  if(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise')):
    $fanchise_detail=User::whereIn('registration_level',[2,1])
           
            ->where([['id','=',Sentinel::getUser()->id],['status','=',2]])->first();
       return view('admin.fanchises.kyc',compact('fanchise_detail'));
       endif;
    }
     public function store_kyc()
    {

if(Sentinel::getUser()->inRole('store') || Sentinel::getUser()->inRole('vendor') || Sentinel::getUser()->inRole('factory')):
    $fanchise_detail=User::whereIn('registration_level',[4,5,6])

    
           
            ->where([['id','=',Sentinel::getUser()->id],['status','=',1]])->first();
       return view('admin.multidepartmentuser.kyc',compact('fanchise_detail'));
       endif;
    }
    public function first_time_stock_download()
    {

    if(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise')):

    $fanchise_detail=User::where('id','=',Sentinel::getUser()->id)->first();
           
     $categories=FirstTimeStockCart::where([['fanchise_id','=',Sentinel::getUser()->id],['payment_status','=',0],['qty','>',0]])->groupBy('extra1')->get();  

     $cart_datas=FirstTimeStockCart::where([['fanchise_id','=',Sentinel::getUser()->id],['payment_status','=',0],['qty','>',0]])->get();  
     
       $pdf=PDF::loadView('admin.fanchises.prelaunch.first_time_stock_download',compact('cart_datas','fanchise_detail','categories'));
    
        return $pdf->stream('first_time_stock_list.pdf'); 

      
       endif;
    }
    public function first_time_stock()
    {

    if(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise')):

    $fanchise_detail=User::where('id','=',Sentinel::getUser()->id)->first();
           
     $categories=FirstTimeStockCart::where([['fanchise_id','=',Sentinel::getUser()->id],['payment_status','=',0],['qty','>',0]])->groupBy('extra1')->get();  

     $cart_datas=FirstTimeStockCart::where([['fanchise_id','=',Sentinel::getUser()->id],['payment_status','=',0],['qty','>',0]])->get();  

       return view('admin.fanchises.prelaunch.first_time_stock',compact('cart_datas','fanchise_detail','categories'));
       endif;
    }
    public function change_supply_from(Request $request)
    {
    $id=$request->id;
    $id=CustomHelpers::custom_decrypt($id); 
    $supply_from=$request->supply_from;
    $fanchise_id=Sentinel::getUser()->id;
     if (FirstTimeStockCart::where('id', $id)->exists()) 
        {
         $data=FirstTimeStockCart::find($id);
         $data->purchase_from=$supply_from;
         $data->save();
        }
        $central_total=CustomHelpers::get_first_stock_amount($fanchise_id,'Central Supply');
        $local_total=CustomHelpers::get_first_stock_amount($fanchise_id,'Local Purchase');

        $output=['central'=>$central_total,'local'=>$local_total,'price'=>$data->amount];
          return $output;
    }
    public function push_back_request(Request $request)
    {
     $id=Sentinel::getUser()->id;
     
   
        $new_user = Sentinel::findById($id);
       
         
        $new_data['status']=3;
         Sentinel::update($new_user, $new_data);  
       $registration_status=new RegistrationActivityStatus;
        $registration_status->fanchise_id=$id;
        $registration_status->activity_from_id=Sentinel::getUser()->id;
        $registration_status->activity='Fanchise Pushback to Company';
        $registration_status->remarks=$request->pushback_comments;
        $registration_status->system_ip=CustomHelpers::get_ip();
        $registration_status->date=date('d-m-Y');
        $registration_status->save();
        echo 'success';

    }
    public function accept_request(Request $request)
    {
     $id=Sentinel::getUser()->id;
     
   
        $new_user = Sentinel::findById($id);
       
         
        $new_data['status']=2;
         Sentinel::update($new_user, $new_data);  
        $registration_status=new RegistrationActivityStatus;
        $registration_status->fanchise_id=$id;
        $registration_status->activity_from_id=Sentinel::getUser()->id;
        $registration_status->activity='Franchise Accept Request';
        $registration_status->remarks=$request->pushback_comments;
        $registration_status->system_ip=CustomHelpers::get_ip();
        $registration_status->date=date('d-m-Y');
        $registration_status->save();
        echo 'success';

    }
    public function approve_kyc_by_admin(Request $request)
    {
       $id=$request->id;
       $id=CustomHelpers::custom_decrypt($id); 
       
       //
        //FanchiseRegistrationStep
        $registration_step=FanchiseRegistrationStep::where('user_id','=',$id)->first();
    
        $registration_step->system_ip=CustomHelpers::get_ip();
        $registration_step->kyc=1;
        $registration_step->save();  
       //
        $data=FanchiseRegistration::where('fanchise_id','=',$id)->first();
    
        $data->prelaunch_action=1;
        $data->prelaunch_id=Sentinel::getUser()->id;
        $data->fanchise_start_date=$request->fanchise_start_date;
        $data->fanchise_end_date=$request->fanchise_end_date;
        $data->prelaunch_action_date=date('d-m-Y');
        $data->save();

        //activity status
        $registration_status=new RegistrationActivityStatus;
        $registration_status->fanchise_id=$id;
        $registration_status->activity_from_id=Sentinel::getUser()->id;
        $registration_status->activity='PreLaunch Admin Accept KYC';
        $registration_status->remarks='';
        $registration_status->system_ip=CustomHelpers::get_ip();
        $registration_status->date=date('d-m-Y');
        $registration_status->save();
       //
       $new_user = Sentinel::findById($id);
       $new_data['status']=6;
       Sentinel::update($new_user, $new_data);  
       echo 'success';
         
    }
    public function reply(Request $request)
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $uers_data=User::find($id);
        $all_roles = Role::whereIn('slug',['fanchise','masterfanchise'])->get();
        $user_roles=DB::table('role_users')->where('user_id','=',$id)->get();
        $states=State::all(); 
        $booking_data=FanchiseRegistration::where('fanchise_id','=',$id)->first();
        $brands=Brands::all();
        // dd($user_roles);
         return view('admin.fanchises.reply',compact('uers_data','all_roles','user_roles','states','booking_data','brands'));
       
    }
    public function kyc_update(Request $request)
    {
        $id=Sentinel::getUser()->id;
        $data=FanchiseRegistration::where('fanchise_id','=',$id)->first();
        if($request->hasFile("aadhar_card")):
    $adhar_card=$request->file("aadhar_card");
    $adhar_card_name=rand(0, 99999).".".$adhar_card->getClientOriginalExtension();
    $adhar_card_path=public_path("/uploads/fanchise");
    $adhar_card->move($adhar_card_path,$adhar_card_name);
    $data->aadhar_card=$adhar_card_name;
        endif;
         if($request->hasFile("pan_card")):
    $pan_card=$request->file("pan_card");
    $pan_card_name=rand(0, 99999).".".$pan_card->getClientOriginalExtension();
    $pan_card_path=public_path("/uploads/fanchise");
    $pan_card->move($pan_card_path,$pan_card_name);
    $data->pan_card=$pan_card_name;
        endif;
        $data->anniversary=$request->anniversary;
        $data->partener_check=$request->partener_check;
        $data->partener_details=serialize($request->partener);
        $data->kyc_submit_date=date('d-m-Y');
        $data->save();
      //
         $registration_status=new RegistrationActivityStatus;
        $registration_status->fanchise_id=$id;
        $registration_status->activity_from_id=Sentinel::getUser()->id;
        $registration_status->activity='Franchise Upload KYC Documents';
        $registration_status->remarks='';
        $registration_status->system_ip=CustomHelpers::get_ip();
        $registration_status->date=date('d-m-Y');
        $registration_status->save();

        //

         $new_user = Sentinel::findById($id);
         $new_data['status']=5;
         $new_data['birthday']=$request->birthday;
         Sentinel::update($new_user, $new_data); 
         echo 'success'; 

    }
      public function store_kyc_update(Request $request)
    {

        $id=Sentinel::getUser()->id;
        $data=StoreDetails::where('store_id','=',$id)->first();
        if($request->hasFile("aadhar_card")):
    $adhar_card=$request->file("aadhar_card");
    $adhar_card_name=rand(0, 99999).".".$adhar_card->getClientOriginalExtension();
    $adhar_card_path=public_path("/uploads/stores");
    $adhar_card->move($adhar_card_path,$adhar_card_name);
    $data->aadhar_card=$adhar_card_name;
        endif;
         if($request->hasFile("pan_card")):
    $pan_card=$request->file("pan_card");
    $pan_card_name=rand(0, 99999).".".$pan_card->getClientOriginalExtension();
    $pan_card_path=public_path("/uploads/stores");
    $pan_card->move($pan_card_path,$pan_card_name);
    $data->pan_card=$pan_card_name;
        endif;
        $data->date=$request->anniversary;
      
        $data->save();
     

         $new_user = Sentinel::findById($id);
         $new_data['status']=2;
         $new_data['birthday']=$request->birthday;
         Sentinel::update($new_user, $new_data); 
         echo 'success'; 

    }
    public function edit(Request $request)
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $uers_data=User::find($id);
        $all_roles = Role::whereIn('slug',['fanchise','masterfanchise'])->get();
        $user_roles=DB::table('role_users')->where('user_id','=',$id)->get();
        $states=State::all(); 
        $booking_data=FanchiseRegistration::where('fanchise_id','=',$id)->first();
        $brands=Brands::all();
        // dd($user_roles);
         return view('admin.fanchises.edit',compact('uers_data','all_roles','user_roles','states','booking_data','brands'));
       
    }
      public function edit_launched(Request $request)
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $uers_data=User::find($id);
        $all_roles = Role::whereIn('slug',['fanchise'])->get();
        $user_roles=DB::table('role_users')->where('user_id','=',$id)->get();
        $states=State::all(); 
        $booking_data=FanchiseRegistration::where('fanchise_id','=',$id)->first();
        $brands=Brands::all();
        // dd($user_roles);
         return view('admin.fanchises.edit_launched',compact('uers_data','all_roles','user_roles','states','booking_data','brands'));
       
    }
     public function view_actions(Request $request)
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $fanchise_detail =User::find($id);

        return view('admin.fanchises.view_actions',compact('fanchise_detail')); 
    }
     public function update_local_purchase_status(Request $request)
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $registered_fanchise=FanchiseRegistration::where('fanchise_id','=',$id)->first();
        $registered_fanchise->local_purchase_status=$request->value;
        $registered_fanchise->save();
        echo 'success';
        
    }
    public function update_procurement_status(Request $request)
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $registered_fanchise=FanchiseRegistration::where('fanchise_id','=',$id)->first();
        $registered_fanchise->procurement_status=$request->value;
        $registered_fanchise->save();
        echo 'success';
        
    }
    public function update_agreement_status(Request $request)
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $registered_fanchise=FanchiseRegistration::where('fanchise_id','=',$id)->first();
       
      $output='  <input type="hidden" name="id"  value="'.$registered_fanchise->id.'"> 
      <div class="col-lg-12">
       <div class="form-group">
        <label>Status</label>
      <select class="form-control" name="agreementstatus" id="agreementstatus" required>

      <option value="">--Select Status--</option>
        <option value="1"';
        if($registered_fanchise->agreementstatus==1)
        {
            $output.='selected';
        }
         $output.='> Send to franchise</option>
        
        <option value="2" ';
        if($registered_fanchise->agreementstatus==2)
        {
            $output.='selected';
        }
         $output.='> Return From franchise</option>
        </select>

          </div>
        </div><div class="col-lg-12">
 <div class="form-group" id="agreement_return" ';
        if($registered_fanchise->agreementstatus==2)
        {
            $output.='style="display:block;"';
        }
        else
        {
             $output.='style="display:none;"';
        }
         $output.='
         >
        <label>Return Agreement Date</label>
<input type="date" name="agreement_return_date" class="form-control" value="'.$registered_fanchise->agreement_return_date.'">
        </div>
</div><div class="col-lg-12">
 <div class="form-group" id="agreement" ';
        if($registered_fanchise->agreementstatus==2)
        {
            $output.='style="display:block;"';
        }
        else
        {
             $output.='style="display:none;"';
        }
         $output.='>
        <label>Attach Agreement</label>';
 if($registered_fanchise->agreement!='')
 {
   $output.='<br><a target="_blank" href="'.url('public/uploads/agreement/'.$registered_fanchise->agreement).'">view</a>'; 
 }
$output.='<input type="file" name="agreement" class="form-control">
        </div>
</div>';

    
        

        echo $output;
        
    }
    public function store_agreement_status(Request $request)
    {
        $id=$request->id;
        // $id=CustomHelpers::custom_decrypt($id);
        $registered_fanchise=FanchiseRegistration::find($id);

      $registered_fanchise->agreementstatus=$request->agreementstatus;
       if($request->hasFile("agreement")):
    $agreement=$request->file("agreement");
    $agreement_name=rand(0, 99999).".".$agreement->getClientOriginalExtension();
    $agreement_path=public_path("/uploads/agreement");
    $agreement->move($agreement_path,$agreement_name);
    $registered_fanchise->agreement=$agreement_name;
        endif;

    $registered_fanchise->agreement_return_date=$request->agreement_return_date;
    $registered_fanchise->agreement_send_date=date('Y-m-d');
    $registered_fanchise->agreement_admin_id=Sentinel::getUser()->id;
    $registered_fanchise->agreement_admin_system_ip=CustomHelpers::get_ip();
    $registered_fanchise->save();
    echo 'success';

    }
    public function architect_edit(Request $request)
    
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $fanchise_detail =User::find($id);
        $registered_fanchise=FanchiseRegistration::where('fanchise_id','=',$id)->first();

        if($registered_fanchise->prelaunch_action==0 || $registered_fanchise->fanchise_status==0 || $registered_fanchise->architect_status==0 || $registered_fanchise->architect_status==1 || $registered_fanchise->architect_status==2 || $registered_fanchise->social_media_status==0 || $registered_fanchise->social_media_status==1 || $registered_fanchise->social_media_status==2 || $registered_fanchise->procurement_status==0 || $registered_fanchise->accounts_status==0 || $registered_fanchise->accounts_status==1 || $registered_fanchise->accounts_status==2):
        $utensillists=UtensilList::where([['item_type','=','Utensil List'],['thumb','=',$registered_fanchise->brands]])->get();
        $equipmentlists=UtensilList::where([['item_type','=','Equipment List'],['thumb','=',$registered_fanchise->brands]])->get();
        $crockerylists=UtensilList::where([['item_type','=','Crockery List'],['thumb','=',$registered_fanchise->brands]])->get(); 
        
        $all_list=UtensilList::where('thumb','=',$registered_fanchise->brands)->get();
         $slug=\Request::segment(1);
        if($slug=='Procurement-Actions'):
        foreach($all_list as $all_lists):
         $cart=FirstTimeStockCart::where([['fanchise_id','=',$id],['list_id','=',$all_lists->id],['payment_status','=',0]])->first();
        if($cart==''):
          $cart=new FirstTimeStockCart; 
       
        $cart->fanchise_id=$id;
        $cart->list_id=$all_lists->id;
        $cart->qty=$all_lists->initial_qty;
        $rate=CustomHelpers::get_rate_with_gst_first_stock($all_lists->id);
        $cart->amount=$all_lists->initial_qty*$rate;
        $cart->qty_rate=$all_lists->rate_fanchise;
        $cart->extra1=$all_lists->item_type;
        $cart->gst_id=$all_lists->gst_id;
        $cart->extra2=$all_lists->thumb;
        $cart->payment_status=0;
        $cart->purchase_from='Central Supply';
          $cart->save();
          endif;
        endforeach;
        endif;
        $cart_data=FirstTimeStockCart::where([['fanchise_id','=',$id],['payment_status','=',0],['qty','>',0]])->get();
        return view('admin.fanchises.prelaunch.architect_edit',compact('fanchise_detail','utensillists','equipmentlists','crockerylists','cart_data','registered_fanchise')); 
    endif;
    }

    public function architect_add(Request $request)
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $fanchise_detail =User::find($id);
        $registered_fanchise=FanchiseRegistration::where('fanchise_id','=',$id)->first();

        if($registered_fanchise->prelaunch_action==0 || $registered_fanchise->fanchise_status==0 || $registered_fanchise->fanchise_status==1 || $registered_fanchise->fanchise_status==2 || $registered_fanchise->architect_status==0 || $registered_fanchise->social_media_status==0 || $registered_fanchise->procurement_status==0 || $registered_fanchise->accounts_status==0):

            $category_data = DB::table('brand_wise_products')
            ->join('master_products', 'master_products.id', '=', 'brand_wise_products.product_id')
            ->where('brand_wise_products.brand_id','=',(int)$registered_fanchise->brands)
            ->select('master_products.*', 'brand_wise_products.initial_qty', 'brand_wise_products.brand_id')
            ->get()
            ->groupBy('item_type');

        
          $all_list = DB::table('brand_wise_products')
            ->join('master_products', 'master_products.id', '=', 'brand_wise_products.product_id')
            ->where('brand_wise_products.brand_id','=',(int)$registered_fanchise->brands)
            ->select('master_products.*', 'brand_wise_products.initial_qty', 'brand_wise_products.brand_id')
            ->get();


       
         $slug=\Request::segment(1);
       
        if($slug=='Procurement-Actions'):

        foreach($all_list as $all_lists):
         $cart=FirstTimeStockCart::where([['fanchise_id','=',$id],['list_id','=',$all_lists->id],['payment_status','=',0]])->first();
        if($cart==''):
          $cart=new FirstTimeStockCart; 
       
        $cart->fanchise_id=$id;
        $cart->list_id=$all_lists->id;
        $cart->qty=$all_lists->initial_qty;
        $rate=CustomHelpers::get_rate_with_gst_first_stock($all_lists->id);
        if($all_lists->initial_qty!='' && $rate!=''):
          $cart->amount=(float)$all_lists->initial_qty*(float)$rate;
        endif;
        
        $cart->qty_rate=$all_lists->franchise_rate;
        $cart->extra1=$all_lists->item_type;
        $cart->gst_id=$all_lists->gst_id;
        $cart->extra2=(int)$registered_fanchise->brands;
        $cart->payment_status=0;
        $cart->purchase_from='Central Supply';
          $cart->save();
          endif;
        endforeach;
        endif;
        $cart_data=FirstTimeStockCart::where([['fanchise_id','=',$id],['payment_status','=',0],['qty','>',0]])->get();
        return view('admin.fanchises.prelaunch.architect_add',compact('fanchise_detail','category_data','cart_data','registered_fanchise')); 
    endif;
    }
    public function get_first_time_filter_data(Request $request)
    {
       $brand_id=$request->brand_id;
      
       $item_type=$request->value;

        $id=$request->fanchise_id;
        $id=CustomHelpers::custom_decrypt($id);
        $fanchise_detail =User::find($id);


       if($item_type=='all')
       {
  $category_data = DB::table('brand_wise_products')
            ->join('master_products', 'master_products.id', '=', 'brand_wise_products.product_id')
            ->where('brand_wise_products.brand_id','=',(int)$brand_id)
            ->select('master_products.*', 'brand_wise_products.initial_qty', 'brand_wise_products.brand_id')
            ->get()
            ->groupBy('item_type');
       }
       else
       {
$category_data = DB::table('brand_wise_products')
            ->join('master_products', 'master_products.id', '=', 'brand_wise_products.product_id')
            ->where([['brand_wise_products.brand_id','=',(int)$brand_id],['master_products.item_type','=',$item_type]])
            ->select('master_products.*', 'brand_wise_products.initial_qty', 'brand_wise_products.brand_id')
            ->get()
            ->groupBy('item_type');
       }
      
    $options = view('admin.fanchises.prelaunch.first_time_filter_data',compact('category_data','fanchise_detail'))->render();
    echo $options;
    }
    public function add_data_to_cart(Request $request)
    {
        $id=$request->fanchise_id;
        $id=CustomHelpers::custom_decrypt($id);

        $list_id=$request->list_id;
        $list_id=CustomHelpers::custom_decrypt($list_id);

        $cart=FirstTimeStockCart::where([['fanchise_id','=',$id],['list_id','=',$list_id],['payment_status','=',0]])->first(); 
        $cart->qty=$request->new_value;
        $list_data=MasterProduct::find($list_id);
        $cart->amount=$request->new_value*$list_data->franchise_rate;
        $cart->qty_rate=$list_data->franchise_rate;
        $cart->save();
        $cart_data=FirstTimeStockCart::where([['fanchise_id','=',$id],['payment_status','=',0],['qty','>',0]])->get();
        echo count($cart_data);

    }
    public function submit_cart_by_company(Request $request)
    {
        $id=$request->fanchise_id;
        $id=CustomHelpers::custom_decrypt($id);
        $data=FanchiseRegistration::where('fanchise_id','=',$id)->first();
        $data->procurement_status=1;
        $data->procurement_id=Sentinel::getUser()->id;
        $data->procurement_action_date=date('d-m-Y');
        $data->save();
        //activity status
        $registration_status=new RegistrationActivityStatus;
        $registration_status->fanchise_id=$id;
        $registration_status->activity_from_id=Sentinel::getUser()->id;
        $registration_status->activity='Procurement Sended First Time Stock List';
        $registration_status->remarks='';
        $registration_status->system_ip=CustomHelpers::get_ip();
        $registration_status->date=date('d-m-Y');
        $registration_status->save();
        echo 'success';
    }
    public function get_cart_data(Request $request)
    {
        $id=$request->fanchise_id;
        $id=CustomHelpers::custom_decrypt($id);
        $cart_datas=FirstTimeStockCart::where([['fanchise_id','=',$id],['payment_status','=',0],['qty','>',0]])->get();
        $output='<div class="row">
                <div class="col-12 table-responsive">
                <table class="table table-striped">
                <thead>
                <tr>
                    
                      <th>Product</th>
                      <th>Rate</th>
                      <th>Qty</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    ';
                $total=0;
        foreach($cart_datas as $cart_data):

            $image_data=ItemImages::where([['item_id','=',$cart_data->list_id],['default','=',1]])->first();
          if($image_data!='' && $image_data->thumb!=''):
            $path=url('public/uploads/item/thumb/'.$image_data->thumb);
                    $image = '<img src="'.$path.'" width="100px">';
          else:
           $path = url('public/uploads/item/noimage.png');
                    $image = '<img src="'.$path.'" width="100px">';
          endif;

       $output.='<tr>
                      
                      <td>'.CustomHelpers::get_list_data($cart_data->list_id,"product_name").'</td>
                      <td>Rs. '.CustomHelpers::get_rate_with_gst_first_stock($cart_data->list_id).'</td>
                      <td>'.$cart_data->qty.'</td>
                      <td>Rs. '.(float)CustomHelpers::get_rate_with_gst_first_stock($cart_data->list_id)*(float)$cart_data->qty.'</td>
                    </tr>';
                    $total=$total+((float)CustomHelpers::get_rate_with_gst_first_stock($cart_data->list_id)*(float)$cart_data->qty);
        endforeach;

    $output.='
     <tr>
    
     <td></td>
     <td></td>
     <td>Total</td>
     <td>Rs '.$total.'</td>
     </tr>
    </tbody>
                </table>
                </div>
                </div>';
    echo $output;
    }

    
    public function fill_pre_launch(Request $request)
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $fanchise_detail =User::find($id);

        return view('admin.fanchises.prelaunch.fill_pre_launch',compact('fanchise_detail')); 
    }
    
    
    
    public function fanchise_launched_update(Request $request)
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);

         $validator = Validator::make($request->all(), 
              [ 
           'email' => "required|email|unique:users,email,$id",
           
          
           
             ]); 
           if($validator->fails()) 
            {          
           echo "The email id has already been taken.";            
            } 
            else
            {
        $loged_user=Sentinel::getUser();
        $user = Sentinel::findById($id);
        
         if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'view_franchise_details')==1):
        $userData['email']=$request->email;
        $userData['mobile']=$request->mobile;
        $userData['user_id']=$request->user_id;
        $userData['address']=$request->address;
        endif;
        $userData['name']=$request->name;
        
        $userData['birthday']=$request->birthday;
        $userData['state']=$request->state;
        $userData['dist']=$request->dist;
        $userData['city']=$request->city;
        
       
        $user = Sentinel::update($user, $userData);
         $role=DB::table('role_users')
              
               ->where('user_id','=',$id)
               ->first();
        $role_ids=$role->role_id;
        $role_main=DB::table('roles')
              
               ->where('id','=',$role_ids)
               ->first();
       
       $role_pre = Sentinel::findRoleBySlug($role_main->slug); 
       $role_pre->users()->detach($id);
       //
        $role=Sentinel::findRoleBySlug($request->user_role);
        $role_id=Sentinel::findRoleBySlug($request->user_role);
        $role->users()->attach($user);

        // $user=Sentinel::registerAndActivate($userData);
        // $role=Sentinel::findRoleBySlug($request->user_role);
        // $role_id=Sentinel::findRoleBySlug($request->user_role);
        // $role->users()->attach($user);  
        // $user->notify(new UserWelcomeNotification());

        $second_data=$user->id;
        $new_user = Sentinel::findById($second_data);
        if($role_id->id==2):
        $new_data['registration_level']=2;
        elseif($role_id->id==12):
        $new_data['registration_level']=1;
        endif;
         
        $new_data['parent_id']=$second_data;
         Sentinel::update($new_user, $new_data);
       
      
         //FanchiseRegistration
         $registration=FanchiseRegistration::where('fanchise_id','=',$second_data)->first();
        $registration->aurthorise_person_id=Sentinel::getUser()->id;
        $registration->system_ip=CustomHelpers::get_ip();
        $registration->fanchise_id=$second_data;
        $registration->fanchise_type_id=$role_id->id;
        $registration->firm_name=$request->firm_name;
        $registration->gst_number=$request->gst_number;
        $registration->outlet_address=$request->outlet_address;
        $registration->subscription_type=$request->subscription_type;
        $registration->subscription_value=$request->subscription_value;
       
        
         //
        

          
        //
        $registration->save();
        //
  
          //
        //
        echo "success";
         } 
    }
    function add_fund_form(Request $request)
    {
    $id=CustomHelpers::custom_decrypt($request->id);
$fanchise_detail=DB::table('users')
           ->join('fanchise_registrations','fanchise_registrations.fanchise_id','=','users.id')
         
           ->where('users.id','=',$id)
          
           ->select('users.*','fanchise_registrations.subscription_value')
         
           ->first();


$options = view("admin.fanchises.add_fund_form",compact('fanchise_detail'))->render();


echo $options;

    }
    function fund_save(Request $request)
    {
    $id=CustomHelpers::custom_decrypt($request->franchise_id);
$fanchise_detail=DB::table('users')
           ->join('fanchise_registrations','fanchise_registrations.fanchise_id','=','users.id')
         
           ->where('users.id','=',$id)
          
           ->select('users.*','fanchise_registrations.subscription_value','fanchise_registrations.expire_date','fanchise_registrations.subscription_type')
         
           ->first();


   $data=FanchiseRegistration::where('fanchise_id',$id)->first();        
    $subscription_type=$fanchise_detail->subscription_type;
    $minfund=$fanchise_detail->subscription_value;
    $subscription_value=$request->subscription_value;
    if($subscription_value>=$minfund)
    {
    $debit=0;
   $expire_date=$fanchise_detail->expire_date;

   $today=date('Y-m-d');
   if($expire_date<$today)
   {
    if($subscription_type==1)
    {
 $expire_date=date('Y-m-d', strtotime($today. ' + 30 days')); 
    }
    else
    {
 $expire_date=date('Y-m-d', strtotime($today. ' + 365 days')); 
    }
     $debit=$fanchise_detail->subscription_value;
   }

$data->expire_date=$expire_date;
$data->save();
$previous_Bal=CustomHelpers::get_franchise_previous_credit_bal($id);
$remaining_bal=(int)($subscription_value-$debit)+(int)$previous_Bal;
 $credit_history=new FranchiseCreditHistory;
 $credit_history->franchise_id=$id;
 $credit_history->credit=$subscription_value;
 $credit_history->debit=$debit;
 $credit_history->remaining_bal=$remaining_bal;
 $credit_history->action_user_id=Sentinel::getUser()->id;
 $credit_history->remarks='Add Fund';
 $credit_history->save();

echo 'success';

    }
    else
    {
        echo 'Cannot accept less than minimum amount';
    }

    }

    public function fanchise_register(Request $request)
    {

         $validator = Validator::make($request->all(), 
              [ 
           'email'=>"required|unique:users",
           
          
           
             ]); 
           if($validator->fails()) 
            {          
           echo "The email id has already been taken.";            
            } 
            else
            {
        $loged_user=Sentinel::getUser();

        $userData['user_id']=$request->user_id;
        
        
        $userData['email']=$request->email;
        $userData['mobile']=$request->mobile;
      
       
        $userData['name']=$request->name;
       
        $userData['birthday']=$request->birthday;
        $userData['state']=$request->state;
        $userData['dist']=$request->dist;
        $userData['city']=$request->city;
        $userData['address']=$request->address;
       
        $userData['password']='NexBilling@1342';
        $user=Sentinel::registerAndActivate($userData);
        $role=Sentinel::findRoleBySlug($request->user_role);
        $role_id=Sentinel::findRoleBySlug($request->user_role);
        $role->users()->attach($user);  
        try{
       $user->notify(new UserWelcomeNotification());
       }
       catch(\Exception $e){ // Using a generic exception
   
       }

        
        //
        
        //

        $second_data=$user->id;
        $new_user = Sentinel::findById($second_data);
        if($role_id->id==2):
        $new_data['registration_level']=2;
        elseif($role_id->id==12):
        $new_data['registration_level']=1;
        endif;
         
        $new_data['parent_id']=$second_data;
         Sentinel::update($new_user, $new_data);
        //FanchiseRegistrationStep
        $registration_step=new FanchiseRegistrationStep;
        $registration_step->user_id=$second_data;
        $registration_step->system_ip=CustomHelpers::get_ip();
        $registration_step->registration=1;
        $registration_step->save();
        //RegistrationActivityStatus
        $registration_status=new RegistrationActivityStatus;
        $registration_status->fanchise_id=$second_data;
        $registration_status->activity_from_id=Sentinel::getUser()->id;
        $registration_status->activity='Admin initiates New Registration';
        $registration_status->remarks='';
        $registration_status->system_ip=CustomHelpers::get_ip();
        $registration_status->date=date('d-m-Y');
        $registration_status->save();
         //FanchiseRegistration
        $registration=new FanchiseRegistration;
        $registration->aurthorise_person_id=Sentinel::getUser()->id;
        $registration->system_ip=CustomHelpers::get_ip();
        $registration->fanchise_id=$second_data;
        $registration->fanchise_type_id=$role_id->id;
        $registration->firm_name=$request->firm_name;
        $registration->gst_number=$request->gst_number;
        $registration->outlet_address=$request->outlet_address;
        $registration->subscription_type=$request->subscription_type;
        $registration->subscription_value=$request->subscription_value;
        $registration->advance_reveived_date=$request->advance_reveived_date;
        $registration->mode_of_advance=$request->mode_of_advance;
        $registration->ref_no_advance=$request->ref_no_advance;
        $advance_date=$request->advance_reveived_date;
        if($advance_date!='')
        {
            if($request->subscription_type==1)
            {
         $expire_date=date('Y-m-d', strtotime($advance_date. ' + 120 days'));
            }
            else
            {
         $expire_date=date('Y-m-d', strtotime($advance_date. ' + 455 days'));
            }
           
       $credit_history=new FranchiseCreditHistory;
       $credit_history->franchise_id=$second_data;
       $credit_history->credit=$request->subscription_value;
       $credit_history->debit=$request->subscription_value;
       $credit_history->remaining_bal=0;
       $credit_history->action_user_id=Sentinel::getUser()->id;
       $credit_history->remarks='New Registration';
       $credit_history->save();


        }
        else
        {
            $advance_date=date('Y-m-d');
         $expire_date=date('Y-m-d', strtotime($advance_date. ' + 90 days'));   
        }
       $registration->expire_date=$expire_date;
        

        $registration->save();
        //
        echo "success";
         } 
    }

    public function get_fanchise_kyc_data(Request $request)
    {
        $id=CustomHelpers::custom_decrypt($request->id);

        $view_registration=DB::table('fanchise_registrations')->where('fanchise_id','=',$id)->first();
        $output='<input type="hidden" name="id" value="'.$request->id.'">
        <table class="table table-bordered"><tr>
              <td><b>Aadhar Card</b></td>
               <td>';
       if($view_registration->aadhar_card!=''):
        $aadhar_path=url('public/uploads/fanchise/'.$view_registration->aadhar_card);
        $output.='<a href="'.$aadhar_path.'" target="_blank">View</a>';
       endif;
       $output.='</td>
        <td><b>PAN Card</b></td>
         <td>';
            if($view_registration->pan_card!=''):
        $pan_path=url('public/uploads/fanchise/'.$view_registration->pan_card);
        $output.='<a href="'.$pan_path.'" target="_blank">View</a>';
       endif;
        $output.='</td>
            <td><b>Anniversary</b></td>
            <td>'.$view_registration->anniversary.'</td>
           </tr>
           </table>';
if($view_registration->partener_check==1):
$output.='<h5>Partners Details</h5>';
$partener_details=unserialize($view_registration->partener_details);
    $output.=' <table class="table table-bordered">
 <thead>
 <tr>
        <th>Name</th>
        <th>Address</th>
        <th>Mobile</th>
        <th>Share</th>
      </tr>
 </thead>               

  <tbody>';
      foreach($partener_details as $rows=>$col):
       $output.=' <tr>
        <td>'.$col["name"].'</td>
        <td>'.$col["address"].'</td>
        <td>'.$col["mobile"].'</td>
         <td>'.$col["share"].'</td>
      </tr>';
     endforeach;
    $output.='</tbody>


</table>';
  endif;
  $output.='<div class="row">
    <div class="col-md-6">
     <div class="form-group"><label for="">Pre Launch Start Date</label>
     <input type="date" name="fanchise_start_date" id="fanchise_start_date" class="form-control" placeholder="Pre Launch Start Date"><span id="error_launch_start_date" class="text-danger"></span>
        </div> </div>
 <div class="col-md-6">
     <div class="form-group">
          <label for="">Launch Date</label>
          <input type="date" name="fanchise_end_date" id="fanchise_end_date" class="form-control" placeholder="Launch  Date">
          <span id="error_fanchise_end_date" class="text-danger"></span>
        </div>
 </div>


 
 
  </div>
<br>

 <button type="button" name="approve_kyc" id="approve_kyc" class="btn btn-info btn-lg">Save</button>
 ';


       echo $output;
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FanchiseRegistration  $fanchiseRegistration
     * @return \Illuminate\Http\Response
     */
    public function show(FanchiseRegistration $fanchiseRegistration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FanchiseRegistration  $fanchiseRegistration
     * @return \Illuminate\Http\Response
     */
 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FanchiseRegistration  $fanchiseRegistration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FanchiseRegistration $fanchiseRegistration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FanchiseRegistration  $fanchiseRegistration
     * @return \Illuminate\Http\Response
     */
    public function destroy(FanchiseRegistration $fanchiseRegistration)
    {
        //
    }
}
