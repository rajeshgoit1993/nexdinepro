{!! Form::open(["files"=>true,'id'=>'store_table'])!!}


<!-- Modal content-->
<div class="">

<div class="modal-body">
    <div class="row">
<div class="col-lg-6">
    <div class="form-group">
<label for="" class="required">Table Name</label>
{!! Form::text("name",null,["class"=>"form-control","placeholder"=>"Enter  Table Name","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('name') }}</span>   
</div>
</div>
<div class="col-lg-6">
    <div class="form-group">
<label for="" class="required">Seat Capacity</label>
{!! Form::text("sit_capacity",null,["class"=>"form-control number_test","placeholder"=>"Enter Seat Capacity","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('sit_capacity') }}</span>   
</div>
</div>
<div class="col-lg-6">
    <div class="form-group">
<label for="" class="required">Position</label>
{!! Form::text("position",null,["class"=>"form-control","placeholder"=>"Enter  Position","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('position') }}</span>   
</div>
</div>
<div class="col-lg-6">
    <div class="form-group">
<label for="" class="required">Description</label>
{!! Form::text("description",null,["class"=>"form-control","placeholder"=>"Enter  Description","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('description') }}</span>   
</div>
</div>
</div>

</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}