{!! Form::open(["files"=>true,'id'=>'store_designation'])!!}


<!-- Modal content-->
<div class="">

<div class="modal-body">
<div class="form-group">
<label for="" class="required">Designation</label>
{!! Form::text("designation",null,["class"=>"form-control","placeholder"=>"Enter Designation","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('designation') }}</span>   
</div>


<div class="form-group">
<label for="" class="required">Designation Level</label>
<select class="form-control" name="designation_level" required>
	
	<option value="Head Of Department">Head Of Department</option>
	<option value="CEO">CEO</option>
	<option value="Director">Director</option>
	<option value="Other">Other</option>
</select>  
</div>


<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}