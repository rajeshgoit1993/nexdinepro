{!! Form::open(["files"=>true,'id'=>'store_holiday'])!!}


<!-- Modal content-->
<div class="">

<div class="modal-body">

<div class="form-group">
<label for="" class="required">Date</label>
<input type="date" name="date" required class="form-control">
</div>

<div class="form-group">
<label for="" class="required">Holiday</label>
<input type="text" name="holiday" required class="form-control">
</div>

<div class="form-group">
<label for="" class="required">Holiday Type</label>
<select class="form-control" name="holiday_type" required>   
 
 <option value="1">Company Holiday</option>
 <option value="2">Optional Holiday</option>
 <option value="3">National Holiday</option>
  <option value="4">Leaving early at 05:00 PM</option>
  <option value="5">Late Coming at 11:30 AM</option>
</select>
</div>




<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}