<div class="card">
<div class="card-header">
<h3 class="card-title">Franchise Registration Details</h3>
</div>
<!-- /.card-header -->

<!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
<div id="accordion">
<div class="card card-primary">
<div class="card-header">
<h4 class="card-title w-100">
<a class="d-block w-100" data-toggle="collapse" href="#collapseOne" aria-expanded="true">
Activity
</a>
</h4>
</div>
<div id="collapseOne" class="collapse" data-parent="#accordion" style="">
<div class="card-body">
@include("admin.fanchises.timeline")
</div>
</div>
</div>
<div class="card card-danger">
<div class="card-header">
<h4 class="card-title w-100">
<a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
Basic Details
</a>
</h4>
</div>
<div id="collapseTwo" class="collapse" data-parent="#accordion">
<div class="card-body">
<table class="table table-bordered">
<?php 
$booking_amount=DB::table('fanchise_registrations')->where('fanchise_id','=',$fanchise_detail->id)->first();

?>

<tr>
  <?php  
$email=CustomHelpers::partiallyHideEmail($fanchise_detail->email);
$mobile=CustomHelpers::mask_mobile_no($fanchise_detail->mobile);  
$official_email=CustomHelpers::partiallyHideEmail($fanchise_detail->user_id);
$address=CustomHelpers::partiallyaddress($fanchise_detail->address);
  ?>
<td><b>User ID</b></td>
<td>{{$email}}</td>
<td><b>Name</b></td>
<td>{{$fanchise_detail->name}}</td>
</tr>

<tr>
<td><b>Official Email ID</b></td>
<td>{{$fanchise_detail->user_id}}</td>
<td><b>DOB</b></td>
<td>{{$fanchise_detail->birthday}}</td>
</tr>


<tr>
<td><b>Mobile No.</b></td>
<td>{{$mobile}}</td>
<td><b>State</b></td>
<td>{{$fanchise_detail->state}}</td>
</tr>
<tr>
<td><b>Dist</b></td>
<td>{{$fanchise_detail->dist}}</td>
<td><b>City</b></td>
<td>{{$fanchise_detail->city}}</td>
</tr>
<tr>
<td><b>Address</b></td>
<td colspan="3">{{$address}}</td>

</tr>

</table>
</div>
</div>
</div>



<div class="card card-info">
<div class="card-header">
<h4 class="card-title w-100">
<a class="d-block w-100" data-toggle="collapse" href="#collapsefour">
For POS
</a>
</h4>
</div>
<div id="collapsefour" class="collapse" data-parent="#collapsefour">
<div class="card-body">
 <table class="table table-bordered">
  <tr>
<td><b>Firm's Registered name</b></td>
<td>{{$booking_amount->firm_name}}</td>
<td><b>GST Number</b></td>
<td>{{$booking_amount->gst_number}}</td>
</tr>
<tr>
<td><b>Outlet Address</b></td>
<td colspan="3">{{$booking_amount->outlet_address}}</td>

</tr>

 <tr>
<td><b>Subscription Type</b></td>
<td>@if($booking_amount->subscription_type==1)
Monthly
@else
Yearly
@endif</td>
<td><b>Subscription Value</b></td>
<td>{{$booking_amount->subscription_value}}</td>
</tr>


</table>



</div>
</div>
</div>






<div class="card card-success"   @if(Sentinel::getUser()->roles[0]->id==1 || Sentinel::getUser()->roles[0]->id==16 || Sentinel::getUser()->roles[0]->id==6 || Sentinel::getUser()->roles[0]->id==7 || $fanchise_detail->aurthorise_person_id==Sentinel::getUser()->id)  @else style="display:none" @endif>
<div class="card-header">
<h4 class="card-title w-100">
<a class="d-block w-100" data-toggle="collapse" href="#collapseThree">
Credit History
</a>
</h4>
</div>
<div id="collapseThree" class="collapse" data-parent="#accordion">
<div class="card-body">
<table class="table table-bordered">


 <thead>
            <tr>
                <th>S.No.</th>
                <th>Date</th>
                <th>Credit</th>
                <th>Debit</th>
                <th>Balance</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
          <?php 
$credit_data=DB::table('franchise_credit_histories')->where('franchise_id','=',$fanchise_detail->id)->get();

?>

            <?php  
           $a=1;
          
            ?>
     @foreach($credit_data as $datas)

     <tr>
     <td>{{ $a++ }}</td>
     <td>{{ $datas->created_at }}</td>
      <td style="color:green">Rs. {{ $datas->credit }}</td>
     <td style="color:red">Rs. {{ $datas->debit }}</td>
     <td>Rs. {{ $datas->remaining_bal }}</td>
     <td> {{ $datas->remarks }}
      @if($datas->refund_qty!='')
      <br>
      Refund Qty: {{$datas->refund_qty}}, Refund Order Id: {{$datas->refund_order_id}}, Refund Product: {{CustomHelpers::get_master_table_data('master_products','id',$datas->refund_product_id,'product_name')}},
      @endif
     </td>


     

     </tr>

     @endforeach

</table>
</div>
</div>
</div>
<!---->
 


</div>

<!-- /.card-body -->
</div>