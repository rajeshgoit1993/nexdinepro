{!! Form::open(["files"=>true,'id'=>'update_designation'])!!}
<input type="hidden" name="id" value="{{$data->id}}">

<!-- Modal content-->
<div class="">

<div class="modal-body">

<div class="form-group">
<label for="" class="required">Designation</label>
{!! Form::text("designation",$data->designation,["class"=>"form-control","placeholder"=>"Enter Designation","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('department') }}</span>   
</div>

<div class="form-group">
<label for="" class="required">Designation Level</label>
<select class="form-control" name="designation_level" required>
	
	<option value="Head Of Department" @if($data->designation_level=='Head Of Department') selected @endif>Head Of Department</option>
	<option value="CEO" @if($data->designation_level=='CEO') selected @endif>CEO</option>
	<option value="Director" @if($data->designation_level=='Director') selected @endif>Director</option>
	<option value="Other" @if($data->designation_level=='Other') selected @endif>Other</option>
</select>  
</div>


</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}