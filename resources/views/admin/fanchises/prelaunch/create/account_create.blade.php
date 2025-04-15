<input type="hidden" id="level" name="level" value="5">
 <div class="col-md-12">

  <label class="required">No Dues clearance</label>
<select class="form-control status" name="no_dues" id="no_dues">
<option value="">--Select--</option>
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
<span id="error_no_dues" class="text-danger"></span>
<div class="status_remarks">
<label>Payment and Agreement</label>
<input type="file" name="payment_clearance[]" id="payment_clearance" class="form-control" multiple>
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
        <option value="2"> Yes</option>
        
        <option value="1">No</option>
        </select>
<span id="error_royalty_pdc" class="text-danger"></span>
          </div>
        </div>
        <div class="col-lg-4">
 <div class="form-group" id="royalty_pdc_text" style="display: none;">
        <label class="required">Royalty PDC Text</label>
<input type="text" name="royalty_pdc_text_data" id="royalty_pdc_text_data" class="form-control" value="" >
<span id="error_royalty_pdc_text_data" class="text-danger"></span>
        </div>
</div>
<div class="col-lg-4">
 <div class="form-group" id="royalty_pdc_agreement" style="display: none;">
<label>Royalty PDC  Attachment </label>
<input type="file" name="royalty_pdc_agreement_data[]" id="royalty_pdc_agreement_data" class="form-control">
<span id="error_royalty_pdc_agreement_data" class="text-danger"></span>
</div>
</div>
 <div class="col-md-12">
<hr>
</div>
<div class="col-lg-4">
       <div class="form-group">
        <label>Agreement send status</label>
      <select class="form-control" name="agreementstatus" id="agreementstatus">

      <option value="">--Select Status--</option>
        <option value="1"> Send to franchise</option>
        
        <option value="2"> Return From franchise</option>
        </select>
<span id="error_agreementstatus" class="text-danger"></span>
          </div>
        </div>
        <div class="col-lg-4">
 <div class="form-group" id="agreement_return" style="display: none;">
        <label>Return Agreement Date</label>
<input type="date" name="agreement_return_date" id="agreement_return_date" class="form-control" value="">
<span id="error_agreement_return_date" class="text-danger"></span>
        </div>
</div>
<div class="col-lg-4">
 <div class="form-group" id="agreement_account_doc" style="display: none;">
        <label>Attach Agreement</label><input type="file" name="agreement[]" id="agreement" class="form-control">
        <span id="error_agreement" class="text-danger"></span>
        </div>
</div>