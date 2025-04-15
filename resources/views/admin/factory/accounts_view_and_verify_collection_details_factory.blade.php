
<style type="text/css">
    .form-group p
    {
        border:1px solid lightgray;border-radius: 5px;padding: 5px;
    }
</style>

<input type="hidden" name="id" value="{{CustomHelpers::custom_encrypt($data->id)}}">


<div class="row">


<div class="col-lg-6">
<div class="form-group">
<label for="" >Factory Name</label>
<p>  {{ CustomHelpers::get_master_table_data('stores','id',$data->factory_id,'name') }} </p>
</div>
</div>


<div class="col-lg-6">
<div class="form-group">
<label for="" >Product Name</label>
  <p> {{CustomHelpers::get_master_table_data('factory_ingredients','id',$data->product_id,'product_name')}}</p>
</div>
</div>

<div class="col-lg-4">
<div class="form-group">
<label for="" >Order Qty</label>
<p>  {{ $data->qty }}  </p>
</div>
</div>

<div class="col-lg-4">
<div class="form-group">
<label for="" >Assign Type</label>
@if($data->assign_type=='factory')
<p> Factory  </p>
@else
<p> Vendor  </p>
@endif
</div>
</div>
<div class="col-lg-4">
<div class="form-group">
    @if($data->assign_type=='factory')
<label for="" >Factory</label>
<p> {{CustomHelpers::get_master_table_data('stores','id',$data->factory_vendor_id,'name')}}  </p>
@else
<label for="" >Vendor</label>
<p> {{CustomHelpers::get_master_table_data('users','id',$data->factory_vendor_id,'name')}}  </p>
@endif

</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label for="" >Estimated cost</label>
<p>  {{ $data->est_cost }}  </p>
</div>
</div>

<div class="col-lg-6">
<div class="form-group">
<label for="" >Attachment</label>
<p> 
@if($data->attachment!='') 
<a href="{{url('public/uploads/fanchise/'.$data->attachment)}}" target="_blank">View</a>

 @endif</p>
</div>
</div>


<div class="col-lg-6">
<div class="form-group">
<label for="" >Delivered Date</label>
{!! Form::date("dilivered_date",null,["class"=>"form-control","placeholder"=>"Delivered Date","required"=>""]) !!}

</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label for="" >Delivered Remarks</label>
{!! Form::text("dilivered_remarks",null,["class"=>"form-control","placeholder"=>"Delivered Remarks"]) !!}
<span class="text-danger">{{ $errors->first('threshold_qty') }}</span>   
</div>
</div>
</div>


{!! Form::submit('Update',["class"=>"btn btn-success"]) !!}








