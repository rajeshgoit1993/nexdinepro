{!! Form::open(["files"=>true,'id'=>'store_department'])!!}


<!-- Modal content-->
<div class="">

<div class="modal-body">
<div class="form-group">
<label for="" class="required">Department</label>
{!! Form::text("department",null,["class"=>"form-control","placeholder"=>"Enter Department","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('department') }}</span>   
</div>


</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}