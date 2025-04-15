<input type="hidden" id="level" name="level" value="5">
 <div class="col-md-12">

  <label class="required">No Dues clearance</label>
<select class="form-control status" name="no_dues" id="no_dues">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->no_dues!='' && $fanchise_pre_launch_data->no_dues=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->no_dues!='' && $fanchise_pre_launch_data->no_dues=='No') selected  @endif>No</option>
</select>
<span id="error_no_dues" class="text-danger"></span>
<div class="status_remarks" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->no_dues!='' && $fanchise_pre_launch_data->no_dues=='Yes') style='display:block'  @endif>
<label>Payment and Agreement</label>
<?php 
$docs=DB::table('pre_launch_docs')->where([['fanchise_id','=',$fanchise_detail->id],['doc_name','=','payment_clearance']])->get();
$a=1;
?>

@foreach($docs as $doc)
<a href="{{url('public/uploads/fanchise_doc/'.$doc->doc)}}"  target="_blank" style="color: blue;">View{{$a++}}</a>
@endforeach
<input type="file" name="payment_clearance[]" id="payment_clearance" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->no_dues!='' && $fanchise_pre_launch_data->no_dues=='Yes') @else id="payment_clearance"   @endif class="form-control" multiple>
<span id="error_payment_clearance" class="text-danger"></span>
</div>


</div>
 <div class="col-md-12">
<hr>
</div>
<div class="col-lg-4">
       <div class="form-group">
        <label class="required">Royalty PDC </label>
      <select class="form-control" name="royalty_pdc" id="royalty_pdc">

      <option value="">--Select Status--</option>
        <option value="2" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->royalty_pdc!='' && $fanchise_pre_launch_data->royalty_pdc==2) selected  @endif> Yes</option>
        
        <option value="1" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->royalty_pdc!='' && $fanchise_pre_launch_data->royalty_pdc==1) selected  @endif>No</option>
        </select>
<span id="error_royalty_pdc" class="text-danger"></span>
          </div>
        </div>
        <div class="col-lg-4">
 <div class="form-group" id="royalty_pdc_text" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->royalty_pdc!='' && $fanchise_pre_launch_data->royalty_pdc==2) style='display:block'  @else style="display: none;" @endif  >
        <label>Royalty PDC Text</label>
<input type="text" name="royalty_pdc_text_data" id="royalty_pdc_text_data" class="form-control" value="{{$fanchise_pre_launch_data->royalty_pdc_text_data}}" >
<span id="error_royalty_pdc_text_data" class="text-danger"></span>
        </div>
</div>
<div class="col-lg-4">
 <div class="form-group" id="royalty_pdc_agreement" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->royalty_pdc!='' && $fanchise_pre_launch_data->royalty_pdc==2) style='display:block'  @else style="display: none;" @endif >
<label>Royalty PDC  Attachment </label>
<?php 
$docs=DB::table('pre_launch_docs')->where([['fanchise_id','=',$fanchise_detail->id],['doc_name','=','royalty_pdc_agreement_data']])->get();
$a=1;
?>

@foreach($docs as $doc)
<a href="{{url('public/uploads/fanchise_doc/'.$doc->doc)}}"  target="_blank" style="color: blue;">View{{$a++}}</a>
@endforeach

<input type="file" name="royalty_pdc_agreement_data[]" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->royalty_pdc!='' && $fanchise_pre_launch_data->royalty_pdc==2)  @else id="royalty_pdc_agreement_data" @endif  class="form-control">
<span id="error_royalty_pdc_agreement_data" class="text-danger"></span>
</div>
</div>
 <div class="col-md-12">
<hr>
</div>
<div class="col-lg-4">
       <div class="form-group">
        <label class="required">Agreement send status</label>
      <select class="form-control" name="agreementstatus" id="agreementstatus">

      <option value="">--Select Status--</option>
        <option value="1" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->agreementstatus!='' && $fanchise_pre_launch_data->agreementstatus==1) selected  @endif> Send to franchise</option>
        
        <option value="2" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->agreementstatus!='' && $fanchise_pre_launch_data->agreementstatus==2) selected  @endif> Return From franchise</option>
        </select>
<span id="error_agreementstatus" class="text-danger"></span>
          </div>
        </div>
        <div class="col-lg-4">
 <div class="form-group" id="agreement_return" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->agreementstatus!='' && $fanchise_pre_launch_data->agreementstatus==2) style='display:block'  @else style="display: none;" @endif>
        <label>Return Agreement Date</label>
<input type="date" name="agreement_return_date" id="agreement_return_date" class="form-control" value="{{$fanchise_pre_launch_data->agreement_return_date}}">
<span id="error_agreement_return_date" class="text-danger"></span>
        </div>
</div>
<div class="col-lg-4">
 <div class="form-group" id="agreement_account_doc" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->agreementstatus!='' && $fanchise_pre_launch_data->agreementstatus==2) style='display:block'  @else style="display: none;" @endif>
        <label>Attach Agreement</label>

<?php 
$docs=DB::table('pre_launch_docs')->where([['fanchise_id','=',$fanchise_detail->id],['doc_name','=','agreement']])->get();
$a=1;
?>

@foreach($docs as $doc)
<a href="{{url('public/uploads/fanchise_doc/'.$doc->doc)}}"  target="_blank" style="color: blue;">View{{$a++}}</a>
@endforeach
        <input type="file" name="agreement[]"  @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->agreementstatus!='' && $fanchise_pre_launch_data->agreementstatus==2)   @else id="agreement" @endif class="form-control">
        <span id="error_agreement" class="text-danger"></span>
        </div>
</div>