
{!! Form::open(["files"=>true,'id'=>'update_wharehouse_product_list'])!!}

<input type="hidden" name="id" value="{{CustomHelpers::custom_encrypt($data->id)}}">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">


</div>
<div class="modal-body">
<div class="row">


<div class="col-lg-6">
<div class="form-group">
<label for="" >Product Name</label>
<?php 
$product_name=CustomHelpers::get_master_table_data('master_products','id',$data->product_id,'product_name');
?>
{!! Form::text("product_name",$product_name,["class"=>"form-control","placeholder"=>"Enter  Name","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('product_name') }}</span>   
</div>
</div>



<div class="col-lg-6">
<div class="form-group">
<label for="" >Edit QTY</label>
{!! Form::text("available_qty",$data->available_qty,["class"=>"form-control number_test","placeholder"=>"Edit QTY","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('available_qty') }}</span>   
</div>
</div>

    

</div>




</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}




