{!! Form::open(["files"=>true,'id'=>'update_payment_method'])!!}
<input type="hidden" name="id" value="{{CustomHelpers::custom_encrypt($data->id)}}">

<!-- Modal content-->
<div class="">

<div class="modal-body">
    <div class="row">
<div class="col-lg-6">
    <div class="form-group">
<label for="" class="required">Payment Method</label>
{!! Form::text("name",$data->name,["class"=>"form-control","placeholder"=>"Enter Payment Method","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('name') }}</span>   
</div>
</div>


<div class="col-lg-6">
    <div class="form-group">
<label for="">Description</label>
{!! Form::text("description",$data->description,["class"=>"form-control","placeholder"=>"Enter  Description"]) !!}
<span class="text-danger">{{ $errors->first('description') }}</span>   
</div>
</div>
</div>

</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Update',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}