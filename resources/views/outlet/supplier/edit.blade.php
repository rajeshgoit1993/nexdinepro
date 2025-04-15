{!! Form::open(["files"=>true,'id'=>'update_supplier'])!!}
<input type="hidden" name="id" value="{{CustomHelpers::custom_encrypt($data->id)}}">

<!-- Modal content-->
<div class="">
<div class="modal-body">

<div class="form-group">
<label for="" class="required">Supplier Name</label>
<input type="text" name="supplier_name" required class="form-control" value="{{$data->supplier_name}}">
</div>

<div class="form-group">
<label for="" class="required">Supplier Phone No.</label>
<input type="text" name="phone_no" required class="form-control" value="{{$data->phone_no}}">
</div>

<div class="form-group">
<label for="" class="required">Supplier Mail ID</label>
<input type="email" name="mail_id" required class="form-control" value="{{$data->mail_id}}">
</div>

<div class="form-group">
<label for="" class="required">Address</label>
<input type="text" name="address" required class="form-control" value="{{$data->address}}">
</div>

<div class="form-group">
<label for="" class="required">Pincode</label>
<input type="text" name="pincode" required class="form-control" value="{{$data->pincode}}">
</div>


<div class="form-group">
<label for="" class="required">GST No.</label>
<input type="text" name="gst_no" required class="form-control" value="{{$data->gst_no}}">
</div>



<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}

</div>
</div>





{!! Form::close() !!}