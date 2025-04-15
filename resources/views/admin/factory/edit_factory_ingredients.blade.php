
<!-- /.content -->

<!---->
{!! Form::open(["files"=>true,'id'=>'update_factory_ingredients'])!!}

<input type="hidden" name="id" value="{{$data->id}}">

<div class="modal-body">
<div class="row">
<!-- <div class="col-lg-3">
<div class="form-group">
<label for="" >Item Type</label>
<select class="form-control" name="item_type" required>
<option value="">--Choose Item--</option>

<option value="Utensil">Utensil</option>
<option value="Equipment">Equipment</option>
<option value="Disposable">Disposable</option>
<option value="Frozen">Frozen</option>
<option value="Masala">Masala</option>
</select>
 
</div>
</div> -->
<div class="col-lg-3">
<div class="form-group">
<label for="" >Item Name</label>
{!! Form::text("product_name",$data->product_name,["class"=>"form-control","placeholder"=>"Enter  Name","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('product_name') }}</span>   
</div>
</div>
<!-- <div class="col-lg-4">
<div class="form-group">
<label for="" >Item Images</label>
{!! Form::file("images[]",["class"=>"form-control","required"=>"","multiple"=>'',"accept"=>"image/png, image/gif, image/jpeg"]) !!}
<span class="text-danger">{{ $errors->first('images') }}</span>   
</div>
</div> -->
<div class="col-lg-3">
<div class="form-group">
<label for="" >Unit</label>
<select class="form-control" name="unit" required>
<option value="">--Choose unit--</option>
@foreach($units as $unit)
<option value="{{$unit->id}}" @if($unit->id==$data->unit) selected @endif>{{$unit->unit}}</option>
@endforeach
</select>
<span class="text-danger">{{ $errors->first('unit') }}</span>  
</div>
</div>
<!-- <div class="col-lg-3">
<div class="form-group">
<label for="" >GST</label>
<select class="form-control" name="gst_id" required>
<option value="">--Choose GST--</option>
@foreach($gsts as $gst)
<option value="{{$gst->id}}" @if($gst->id==$data->gst_id) selected @endif>{{$gst->gst_name}}</option>
@endforeach
</select>
<span class="text-danger">{{ $errors->first('gst_id') }}</span>   
</div>
</div> -->
<div class="col-lg-3">
<div class="form-group">
<label for="" > Rate</label>
{!! Form::text("rate_margin",$data->rate_margin,["class"=>"form-control number_test","placeholder"=>"Enter  Company Rate","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('rate_margin') }}</span>   
</div>
</div>
<!-- <div class="col-lg-3">
<div class="form-group">
<label for="" >Fanchise Rate</label>
{!! Form::text("rate_fanchise",$data->rate_fanchise,["class"=>"form-control number_test","placeholder"=>"Enter  Fanchise Rate","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('rate_fanchise') }}</span>   
</div>
</div> -->

<div class="col-lg-3">
<div class="form-group">
<label for="" >Threshold Quantity</label>
{!! Form::text("threshold_qty",$data->threshold_qty,["class"=>"form-control number_test","placeholder"=>"Enter Threshold  Quantity","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('threshold_qty') }}</span>   
</div>
</div>

<div class="col-lg-3">
<div class="form-group">
<label for="" >Available QTY</label>
{!! Form::text("avl_qty",$data->avl_qty,["class"=>"form-control number_test","placeholder"=>"Available Quantity","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('avl_qty') }}</span>   
</div>
</div>


<div class="col-lg-3">
<div class="form-group">
<label for="" >Select Vendor</label>
<select class="form-control select2" name="vendor[]" multiple>

@foreach($vendors as $vendor)
<?php  
$factory_data=CustomHelpers::get_factory_vendor_data($vendor->id,'vendor_second');
?>
<option value="{{$vendor->id}}" @foreach($factory_data as $fact) @if($fact->factory_vendor_id==$vendor->id && $fact->product_id==$data->id) selected @endif @endforeach>{{$vendor->name}}</option>
@endforeach
</select>
 
</div>
</div>
<div class="col-lg-12">
<div class="form-group">
<label for="" >Description</label>
{!! Form::textarea("description",$data->description,["class"=>"form-control","placeholder"=>"Enter  Description","rows"=>"2"]) !!}
<span class="text-danger">{{ $errors->first('description') }}</span>   
</div>
</div>
</div>




</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}

</div>



{!! Form::close() !!}


