<div class="card">
<div class="card-header">
<h3 class="card-title">Registration Details</h3>
</div>
<!-- /.card-header -->

<!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
<div id="accordion">

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


<tr>
<td><b>User ID</b></td>
<td>{{$fanchise_detail->email}}</td>
<td><b>Name</b></td>
<td>{{$fanchise_detail->name}}</td>
</tr>
<tr>
<td><b>Mobile No.</b></td>
<td>{{$fanchise_detail->mobile}}</td>
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
<td colspan="3">{{$fanchise_detail->address}}</td>

</tr>

</table>
</div>
</div>
</div>

<!---->
 @if($fanchise_detail->status>=2)
<div class="card card-info">
<div class="card-header">
<h4 class="card-title w-100">
<a class="d-block w-100" data-toggle="collapse" href="#collapsefour">
KYC
</a>
</h4>
</div>
<div id="collapsefour" class="collapse" data-parent="#collapsefour">
<div class="card-body">
 <table class="table table-bordered">

  <tr>
    <?php 

    $kyc_data=DB::table('store_details')->where('store_id','=',$fanchise_detail->id)->first();
     ?>
              <td><b>Aadhar Card</b></td>
               <td>
       @if($kyc_data->aadhar_card!='')
       
      <a href="{{url('public/uploads/stores/'.$kyc_data->aadhar_card)}}" target="_blank">View</a>
       @endif
       </td>
        <td><b>PAN Card</b></td>
         <td>
            @if($kyc_data->pan_card!='')
     <a href="{{url('public/uploads/stores/'.$kyc_data->pan_card)}}" target="_blank">View</a>
       @endif
        </td>
            <td><b>Anniversary</b></td>
            <td>{{$kyc_data->date}}</td>
           </tr>
           </table>



</div>
</div>
</div>

@endif
<!---->


</div>

<!-- /.card-body -->
</div>