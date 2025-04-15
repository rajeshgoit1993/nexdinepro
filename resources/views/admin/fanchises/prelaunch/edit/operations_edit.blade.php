<input type="hidden" id="level" name="level" value="4">
  <div class="col-md-4">

  <label class="required">FSSAI License</label>
<select class="form-control status" name="agreement" id="agreement">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->agreement!='' && $fanchise_pre_launch_data->agreement=='Yes') selected  @endif>Yes</option>
<option value="No"  @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->agreement!='' && $fanchise_pre_launch_data->agreement=='No') selected  @endif>No</option>
</select>
<span id="error_agreement" class="text-danger"></span>
<div class="status_remarks" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->agreement!='' && $fanchise_pre_launch_data->agreement=='Yes') style='display:block'  @endif>
<label>Doc</label>
<?php 
$docs=DB::table('pre_launch_docs')->where([['fanchise_id','=',$fanchise_detail->id],['doc_name','=','agreement_doc']])->get();
$a=1;
?>

@foreach($docs as $doc)
<a href="{{url('public/uploads/fanchise_doc/'.$doc->doc)}}"  target="_blank" style="color: blue;">View{{$a++}}</a>
@endforeach
<input type="file" name="agreement_doc[]"  @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->agreement!='' && $fanchise_pre_launch_data->agreement=='Yes') @else  id="agreement_doc"  @endif class="form-control" multiple>
<span id="error_agreement_doc" class="text-danger"></span>
</div>


</div>
<!---->
 <div class="col-md-4">

  <label class="required">GST</label>
<select class="form-control status" name="gst_ops" id="gst_ops">
<option value="">--Select--</option>
<option value="Yes"  @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->gst_ops!='' && $fanchise_pre_launch_data->gst_ops=='Yes') selected  @endif>Yes</option>

<option value="No"  @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->gst_ops!='' && $fanchise_pre_launch_data->gst_ops=='No') selected  @endif>No</option>

</select>
<span id="error_gst_ops" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!---->
 <div class="col-md-4">

  <label class="required">Zomato Onboarding</label>
<select class="form-control status" name="zomato" id="zomato">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->zomato!='' && $fanchise_pre_launch_data->zomato=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->zomato!='' && $fanchise_pre_launch_data->zomato=='No') selected  @endif>No</option>
<option value="NA" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->zomato!='' && $fanchise_pre_launch_data->zomato=='NA') selected  @endif>NA</option>
</select>
<span id="error_zomato" class="text-danger"></span>
<div class="status_remarks" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->zomato!='' && $fanchise_pre_launch_data->zomato=='Yes') style='display:block'  @endif>
<label>Zomato Resturant ID</label>
<input type="text" name="zomato_text" id="zomato_text" class="form-control" value="{{$fanchise_pre_launch_data->zomato_text}}" placeholder="Zomato Resturant ID">
<span id="error_zomato_text" class="text-danger"></span>
</div>


</div>
<!---->
  <div class="col-md-4">

  <label class="required">Swiggy Onboarding</label>
<select class="form-control status" name="swiggy" id="swiggy">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->swiggy!='' && $fanchise_pre_launch_data->swiggy=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->swiggy!='' && $fanchise_pre_launch_data->swiggy=='No') selected  @endif>No</option>
<option value="NA" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->swiggy!='' && $fanchise_pre_launch_data->swiggy=='NA') selected  @endif>NA</option>
</select>
<span id="error_swiggy" class="text-danger"></span>
<div class="status_remarks" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->swiggy!='' && $fanchise_pre_launch_data->swiggy=='Yes') style='display:block'  @endif>
<label>Swiggy Restaurant ID</label>
<input type="text" name="swiggy_text" id="swiggy_text" class="form-control" value="{{$fanchise_pre_launch_data->swiggy_text}}" placeholder="Swiggy Restaurant ID">
<span id="error_swiggy_text" class="text-danger" ></span>
</div>


</div>
<!---->
<div class="col-md-4">

  <label class="required">Local Food Partner </label>
<select class="form-control status" name="local_food" id="local_food">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->local_food!='' && $fanchise_pre_launch_data->local_food=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->local_food!='' && $fanchise_pre_launch_data->local_food=='No') selected  @endif>No</option>
<option value="NA" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->local_food!='' && $fanchise_pre_launch_data->local_food=='NA') selected  @endif>NA</option>
</select>
<span id="error_local_food" class="text-danger"></span>
<div class="status_remarks" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->local_food!='' && $fanchise_pre_launch_data->local_food=='Yes') style='display:block'  @endif>
<label>Resturant ID</label>
<input type="text" name="local_food_text" id="local_food_text" class="form-control" value="{{$fanchise_pre_launch_data->local_food_text}}" placeholder="Resturant ID">
<span id="error_local_food_text" class="text-danger"></span>
</div>


</div>
<!---->
<div class="col-md-4">

  <label class="required">Manpower MOU (With Franchisee) </label>
<select class="form-control status" name="man_power_mou" id="man_power_mou">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->man_power_mou!='' && $fanchise_pre_launch_data->man_power_mou=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->man_power_mou!='' && $fanchise_pre_launch_data->man_power_mou=='No') selected  @endif>No</option>
</select>
<span id="error_man_power_mou" class="text-danger"></span>
<div class="status_remarks"  @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->man_power_mou!='' && $fanchise_pre_launch_data->man_power_mou=='Yes') style='display:block'  @endif>
<label>Doc</label>
<?php 
$docs=DB::table('pre_launch_docs')->where([['fanchise_id','=',$fanchise_detail->id],['doc_name','=','man_power_mou_doc']])->get();
$a=1;
?>

@foreach($docs as $doc)
<a href="{{url('public/uploads/fanchise_doc/'.$doc->doc)}}"  target="_blank" style="color: blue;">View{{$a++}}</a>
@endforeach
<input type="file" name="man_power_mou_doc[]"  @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->man_power_mou!='' && $fanchise_pre_launch_data->man_power_mou=='Yes')  @else id="man_power_mou_doc"  @endif  class="form-control" multiple>
<span id="error_man_power_mou_doc" class="text-danger"></span>
</div>


</div>
<!---->
<div class="col-md-4">

  <label class="required">Billing Software installation</label>
<select class="form-control status" name="billing_software" id="billing_software">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->billing_software!='' && $fanchise_pre_launch_data->billing_software=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->billing_software!='' && $fanchise_pre_launch_data->billing_software=='No') selected  @endif>No</option>
</select>
<span id="error_billing_software" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!---->
<div class="col-md-4">

  <label class="required">EDC Machine/ UPI QR Installation</label>
<select class="form-control status" name="edc_machine" id="edc_machine">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->edc_machine!='' && $fanchise_pre_launch_data->edc_machine=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->edc_machine!='' && $fanchise_pre_launch_data->edc_machine=='No') selected  @endif>No</option>
</select>
<span id="error_edc_machine" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!----> 
  <div class="col-md-4">

  <label class="required">CCTV Access </label>
<select class="form-control status" name="cctv_access" id="cctv_access">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->cctv_access!='' && $fanchise_pre_launch_data->cctv_access=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->cctv_access!='' && $fanchise_pre_launch_data->cctv_access=='No') selected  @endif>No</option>
</select>
<span id="error_cctv_access" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!---->
<div class="col-md-4">

  <label class="required">SOPs</label>
<select class="form-control status" name="sops" id="sops">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->sops!='' && $fanchise_pre_launch_data->sops=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->sops!='' && $fanchise_pre_launch_data->sops=='No') selected  @endif>No</option>
</select>
<span id="error_sops" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!---->
<div class="col-md-4">

  <label class="required">Chef Travel Plan</label>
<select class="form-control status" name="chef_travel_plan" id="chef_travel_plan">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->chef_travel_plan!='' && $fanchise_pre_launch_data->chef_travel_plan=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->chef_travel_plan!='' && $fanchise_pre_launch_data->chef_travel_plan=='No') selected  @endif>No</option>
</select>
<span id="error_chef_travel_plan" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!---->

<div class="col-md-4">

  <label class="required">Dry-run </label>
<select class="form-control status" name="dry_run" id="dry_run">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->dry_run!='' && $fanchise_pre_launch_data->dry_run=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->dry_run!='' && $fanchise_pre_launch_data->dry_run=='No') selected  @endif>No</option>
</select>
<span id="error_dry_run" class="text-danger"></span>
<div class="status_remarks" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->dry_run!='' && $fanchise_pre_launch_data->dry_run=='Yes') style='display:block'  @endif>
<label>Dry-run Text</label>
<input type="text" name="dry_run_text" id="dry_run_text" class="form-control" value="{{$fanchise_pre_launch_data->dry_run_text}}">
<span id="error_dry_run_text" class="text-danger"></span>
</div>


</div>
<!---->
<div class="col-md-4">

  <label class="required">Food bloggers</label>
<select class="form-control status" name="cutlery" id="cutlery">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->cutlery!='' && $fanchise_pre_launch_data->cutlery=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->cutlery!='' && $fanchise_pre_launch_data->cutlery=='No') selected  @endif>No</option>
</select>
<span id="error_cutlery" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!---->
<div class="col-md-4">

  <label class="required">Manual Billbook</label>
<select class="form-control status" name="uniforms" id="uniforms">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->uniforms!='' && $fanchise_pre_launch_data->uniforms=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->uniforms!='' && $fanchise_pre_launch_data->uniforms=='No') selected  @endif>No</option>
</select>
<span id="error_uniforms" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!----> 
<div class="col-md-4">

  <label class="required">Visitors diary</label>
<select class="form-control status" name="central_supply" id="central_supply">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->central_supply!='' && $fanchise_pre_launch_data->central_supply=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->central_supply!='' && $fanchise_pre_launch_data->central_supply=='No') selected  @endif>No</option>
</select>
<span id="error_central_supply" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!---->  
 <div class="col-md-4">

  <label class="required">Stationary & First Aid</label>
<select class="form-control status" name="temple" id="temple">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->temple!='' && $fanchise_pre_launch_data->temple=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->temple!='' && $fanchise_pre_launch_data->temple=='No') selected  @endif>No</option>
</select>
<span id="error_temple" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!----> 
  <div class="col-md-4">

  <label class="required">Manpower Hiring</label>
<select class="form-control status" name="man_power" id="man_power">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->man_power!='' && $fanchise_pre_launch_data->man_power=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->man_power!='' && $fanchise_pre_launch_data->man_power=='No') selected  @endif>No</option>
</select>
<span id="error_man_power" class="text-danger"></span>
<div class="status_remarks">
<!-- <label>Doc</label>
<input type="file" name="newspaper_ad" id="newspaper_ad" class="form-control" > -->
</div>


</div>
<!---->
<!---->
  
  
 <div class="col-md-4">

  <label class="required">Staff Room</label>
<select class="form-control status" name="local_purchase" id="local_purchase">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->local_purchase!='' && $fanchise_pre_launch_data->local_purchase=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->local_purchase!='' && $fanchise_pre_launch_data->local_purchase=='No') selected  @endif>No</option>
</select>
<span id="error_local_purchase" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!----> 




 