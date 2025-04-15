<?php  
$fanchise_pre_launch_data=DB::table('pre_launches')->where('fanchise_id','=',$fanchise_detail->id)->first();

?>
@if(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise'))
<input type="hidden" id="level" name="level" value="6">
@else
<input type="hidden" id="level" name="level" value="7">
@endif
 <div class="col-md-6">

  <label>Firm's Registered name</label>
<input type="text" name="firm_name" id="firm_name" class="form-control" @if($fanchise_pre_launch_data!='') value="{{$fanchise_pre_launch_data->firm_name}}" @endif>
<span id="error_firm_name" class="text-danger"></span>
</div>
<div class="col-md-6">
<label>Doc</label>
<?php 
$docs=DB::table('pre_launch_docs')->where([['fanchise_id','=',$fanchise_detail->id],['doc_name','=','registration_doc']])->get();
$a=1;
?>

@foreach($docs as $doc)
<a href="{{url('public/uploads/fanchise_doc/'.$doc->doc)}}"  download="" style="color: blue;">View{{$a++}}</a>
@endforeach

<input type="file" name="registration_doc[]" id="registration_doc" class="form-control" multiple>
<span id="error_registration_doc" class="text-danger"></span>



</div>
<div class="col-md-12">
  <hr>
  <div class="form-check">
  <label class="form-check-label">
    <input type="checkbox" name="shop_check" class="form-check-input partener_check" value="1" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->shop_aggrement!='')  checked @endif>Do you have a shop ?
  </label>
</div>
</div>
<div class="outlet_detail" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->shop_aggrement!='')  style='display:block' @endif>
  <div class="col-lg-12">
   <div class="row">

 <div class="col-md-6">

  <label>Shop agreement</label>

<input type="text" @if($fanchise_pre_launch_data!='') value="{{$fanchise_pre_launch_data->shop_aggrement}}" @endif  name="shop_aggrement" id="shop_aggrement" class="form-control" >
<span id="error_shop_aggrement" class="text-danger"></span>
</div>
<div class="col-md-6">
<label>Pics /Layout(sample)</label>
<?php 
$docs=DB::table('pre_launch_docs')->where([['fanchise_id','=',$fanchise_detail->id],['doc_name','=','shop_aggrement_doc']])->get();
$a=1;
?>

@foreach($docs as $doc)
<a href="{{url('public/uploads/fanchise_doc/'.$doc->doc)}}"  download="" style="color: blue;">View{{$a++}}</a>
@endforeach
<input type="file" name="shop_aggrement_doc[]" id="shop_aggrement_doc" class="form-control" multiple>
<span id="error_shop_aggrement_doc" class="text-danger"></span>



</div>

 <div class="col-md-6">

  <label>Outlet Address</label>
<input type="text" @if($fanchise_pre_launch_data!='') value="{{$fanchise_pre_launch_data->outlet_address}}" @endif name="outlet_address" id="outlet_address" class="form-control" >
<span id="error_outlet_address" class="text-danger"></span>
</div>
<div class="col-md-6">
<label>Outlet Address Doc</label>
<?php 
$docs=DB::table('pre_launch_docs')->where([['fanchise_id','=',$fanchise_detail->id],['doc_name','=','outlet_address_doc']])->get();
$a=1;
?>

@foreach($docs as $doc)
<a href="{{url('public/uploads/fanchise_doc/'.$doc->doc)}}"  download="" style="color: blue;">View{{$a++}}</a>
@endforeach
<input type="file" name="outlet_address_doc[]" id="outlet_address_doc" class="form-control" multiple>
<span id="error_outlet_address_doc" class="text-danger"></span>



</div>

 <div class="col-md-6">

  <label>Personal mail ID </label>
<input type="text" @if($fanchise_pre_launch_data!='') value="{{$fanchise_pre_launch_data->outlet_mail}}" @endif name="outlet_mail" id="outlet_mail" class="form-control">
<span id="error_outlet_mail" class="text-danger"></span>
</div>


 <div class="col-md-6">

  <label>Outlet Mobile</label>
<input type="text" @if($fanchise_pre_launch_data!='') value="{{$fanchise_pre_launch_data->outlet_mobile}}" @endif name="outlet_mobile" id="outlet_mobile" class="form-control">
<span id="error_outlet_mobile" class="text-danger"></span>
</div>


 <div class="col-md-6">

  <label>GST</label>
<input type="text" @if($fanchise_pre_launch_data!='') value="{{$fanchise_pre_launch_data->gst}}" @endif name="gst" id="gst" class="form-control" >
<span id="error_gst" class="text-danger"></span>
</div>
<div class="col-md-6">
<label>GST Agreement</label>
<?php 
$docs=DB::table('pre_launch_docs')->where([['fanchise_id','=',$fanchise_detail->id],['doc_name','=','gst_doc']])->get();
$a=1;
?>

@foreach($docs as $doc)
<a href="{{url('public/uploads/fanchise_doc/'.$doc->doc)}}"  download="" style="color: blue;">View{{$a++}}</a>
@endforeach
<input type="file" name="gst_doc[]" id="gst_doc" class="form-control" multiple>
<span id="error_gst_doc" class="text-danger"></span>



</div>

 <div class="col-md-6">

  <label>FSSAI License</label>
<input type="text" @if($fanchise_pre_launch_data!='') value="{{$fanchise_pre_launch_data->fssai}}" @endif name="fssai" id="fssai" class="form-control">
<span id="error_fssai" class="text-danger"></span>
</div>
<div class="col-md-6">
<label>FSSAI License Agreement</label>
<?php 
$docs=DB::table('pre_launch_docs')->where([['fanchise_id','=',$fanchise_detail->id],['doc_name','=','fssai_doc']])->get();
$a=1;
?>

@foreach($docs as $doc)
<a href="{{url('public/uploads/fanchise_doc/'.$doc->doc)}}"  download="" style="color: blue;">View{{$a++}}</a>
@endforeach
<input type="file" name="fssai_doc[]" id="fssai_doc" class="form-control" multiple>
<span id="error_fssai_doc" class="text-danger"></span>



</div>

 <div class="col-md-6">

  <label>Electricity load sanction</label>
<input type="text" @if($fanchise_pre_launch_data!='') value="{{$fanchise_pre_launch_data->electricity_load}}" @endif name="electricity_load" id="electricity_load" class="form-control">
<span id="error_electricity_load" class="text-danger"></span>
</div>
<div class="col-md-6">
<label>Electricity load sanction Agreement</label>
<?php 
$docs=DB::table('pre_launch_docs')->where([['fanchise_id','=',$fanchise_detail->id],['doc_name','=','electricity_load_doc']])->get();
$a=1;
?>

@foreach($docs as $doc)
<a href="{{url('public/uploads/fanchise_doc/'.$doc->doc)}}"  download="" style="color: blue;">View{{$a++}}</a>
@endforeach
<input type="file" name="electricity_load_doc[]" id="electricity_load_doc" class="form-control" multiple>
<span id="error_electricity_load_doc" class="text-danger"></span>



</div>

 <div class="col-md-6">

  <label>Current bank a/c details</label>
<input type="text" @if($fanchise_pre_launch_data!='') value="{{$fanchise_pre_launch_data->current_bank}}" @endif name="current_bank" id="current_bank" class="form-control">
<span id="error_current_bank" class="text-danger"></span>
</div>
<div class="col-md-6">
<label>Current bank a/c details doc</label>
<?php 
$docs=DB::table('pre_launch_docs')->where([['fanchise_id','=',$fanchise_detail->id],['doc_name','=','current_bank_doc']])->get();
$a=1;
?>

@foreach($docs as $doc)
<a href="{{url('public/uploads/fanchise_doc/'.$doc->doc)}}"  download="" style="color: blue;">View{{$a++}}</a>
@endforeach
<input type="file" name="current_bank_doc[]" id="current_bank_doc" class="form-control" multiple>
<span id="error_current_bank_doc" class="text-danger"></span>



</div>
</div>
</div>
  </div>