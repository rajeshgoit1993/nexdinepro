

{!! Form::open(["files"=>true,'id'=>'update_supply_list'])!!}

<input type="hidden" name="id" value="{{CustomHelpers::custom_encrypt($data->id)}}">


<div class="modal-body">
<div class="row">
<div class="col-lg-3">
<div class="form-group">
<label for="" >Item Type</label>
<select class="form-control" name="item_type" required>
<option value="">--Choose Item--</option>
<!-- <option value="Utensil List" @if($data->item_type=='Utensil List') selected @endif>Utensil List</option>
<option value="Equipment List" @if($data->item_type=='Equipment List') selected @endif>Equipment List</option>
<option value="Crockery List" @if($data->item_type=='Crockery List') selected @endif>Crockery List</option> -->
<option value="Utensil" @if($data->item_type=='Utensil') selected @endif>Utensil</option>
<option value="Equipment" @if($data->item_type=='Equipment') selected @endif>Equipment</option>
<option value="Disposable" @if($data->item_type=='Disposable') selected @endif>Disposable</option>
<option value="Frozen" @if($data->item_type=='Frozen') selected @endif>Frozen</option>
<option value="Masala" @if($data->item_type=='Masala') selected @endif>Masala</option>

</select>
<span class="text-danger">{{ $errors->first('item_type') }}</span>   
</div>
</div>
 <div class="col-lg-3">
           <div class="form-group">
     <label>Brands</label>
     <select class="form-control" name="thumb" id="thumb" required>
      <option value="">--Select Brands--</option>
 <option value="">--Select Brands--</option>
@foreach($brands as $brand)
<option value="{{$brand->id}}" @if($brand->id==$data->thumb) selected @endif>{{$brand->brand}}</option>
@endforeach
     </select>

        </div>
     </div>
     


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
<div class="col-lg-2">
<div class="form-group">
<label for="" >Company Rate</label>
{!! Form::text("rate_margin",$data->rate_margin,["class"=>"form-control number_test","placeholder"=>"Enter  Company Rate","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('rate_margin') }}</span>   
</div>
</div>
<div class="col-lg-2">
<div class="form-group">
<label for="" >Fanchise Rate</label>
{!! Form::text("rate_fanchise",$data->rate_fanchise,["class"=>"form-control number_test","placeholder"=>"Enter  Fanchise Rate","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('rate_fanchise') }}</span>   
</div>
</div>
<div class="col-lg-2">
<div class="form-group">
<label for="" >Initial Quantity</label>
{!! Form::text("initial_qty",$data->initial_qty,["class"=>"form-control number_test","placeholder"=>"Initial Quantity","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('initial_qty') }}</span>   
</div>
</div>
<div class="col-lg-2">
<div class="form-group">
<label for="" >Threshold Quantity</label>
{!! Form::text("threshold_qty",$data->threshold_qty,["class"=>"form-control number_test","placeholder"=>"Enter  Threshold Quantity","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('threshold_qty') }}</span>   
</div>
</div>
<div class="col-lg-4">
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
</div>
<div class="col-lg-6">
<div class="form-group">
<label for="" >Select Factory</label>
<select class="form-control select2" name="factory[]" multiple>

@foreach($factories as $factory)
<?php  
$factory_data=CustomHelpers::get_factory_vendor_data($factory->id,'factory');
?>
<option value="{{$factory->id}}"  @foreach($factory_data as $fact) @if($fact->factory_vendor_id==$factory->id && $fact->product_id==$data->id) selected @endif @endforeach>{{$factory->name}}</option>
@endforeach
</select>
 
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label for="" >Select Vendor</label>
<select class="form-control select2" name="vendor[]" multiple>


@foreach($vendors as $vendor)
<?php  
$factory_data=CustomHelpers::get_factory_vendor_data($vendor->id,'vendor');
?>
<option value="{{$factory->id}}"  @foreach($factory_data as $fact) @if($fact->factory_vendor_id==$vendor->id && $fact->product_id==$data->id) selected @endif @endforeach>{{$factory->name}}</option>
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




