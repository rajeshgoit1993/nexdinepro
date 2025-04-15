{!! Form::open(["files"=>true,'id'=>'store_payment_method'])!!}


<!-- Modal content-->
<div class="">

<div class="modal-body">
    <div class="row">
<div class="col-lg-6">
    <div class="form-group">
<label for="" class="required">Payment Method</label>
{!! Form::text("name",null,["class"=>"form-control","placeholder"=>"Enter Payment Method","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('name') }}</span>   
</div>
</div>


<div class="col-lg-6">
    <div class="form-group">
<label for="">Description</label>
{!! Form::text("description",null,["class"=>"form-control","placeholder"=>"Enter  Description"]) !!}
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