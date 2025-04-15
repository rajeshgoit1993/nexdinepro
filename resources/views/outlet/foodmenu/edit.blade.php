
{!! Form::open(["files"=>true,'id'=>'update_product_list'])!!}

<input type="hidden" name="id" value="{{CustomHelpers::custom_encrypt($data->id)}}">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">


</div>
<div class="modal-body">
<div class="row">


<div class="col-lg-6">
<div class="form-group">
<label for="" >Food Menu Name</label>
<?php 
$product_name=CustomHelpers::get_master_table_data('food_menus','id',$data->food_menu_id,'name');
?>
{!! Form::text("product_name",$product_name,["class"=>"form-control","placeholder"=>"Food Menu Name","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('product_name') }}</span>   
</div>
</div>



<div class="col-lg-6">
<div class="form-group">
<label for="" >Sale Price</label>
{!! Form::text("sale_price",$data->sale_price,["class"=>"form-control number_test","placeholder"=>"Sale Price","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('sale_price') }}</span>   
</div>
</div>
 <?php 

$gst_data=json_decode($data->tax_information);
$gst_id=$gst_data[0]->tax_field_id;

    ?>
  <div class="col-lg-6">
<div class="form-group">
<label for="" class="required">GST </label>
<select class="form-control" name="tax_information" required>
<option value="">--Choose GST--</option>
@foreach($gsts as $gst)
<option value="{{$gst->id}}" @if($gst_id==$gst->id) selected @endif>{{$gst->gst_name}}</option>
@endforeach
</select>  
</div>
</div>  

</div>




</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}




