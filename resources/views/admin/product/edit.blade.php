
{!! Form::open(["files"=>true,'id'=>'update_product_list'])!!}
<input type="hidden" name="outlet_id" value="{{$data->outlet_id}}">
<input type="hidden" name="id" value="{{CustomHelpers::custom_encrypt($data->id)}}">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">


</div>
<div class="modal-body">
<div class="row">
<div class="col-lg-3">
<div class="form-group">
<label for="" >Item Type</label>
<select class="form-control" name="item_type" required>
<option value="">--Choose Item--</option>
<!-- <option value="Utensil List">Utensil List</option>
<option value="Equipment List">Equipment List</option>
<option value="Crockery List">Crockery List</option> -->
<option value="Utensil" @if($data->item_type=='Utensil') selected @endif>Utensil</option>
<option value="Equipment" @if($data->item_type=='Equipment') selected @endif>Equipment</option>
<option value="Disposable" @if($data->item_type=='Disposable') selected @endif>Disposable</option>
<option value="Frozen" @if($data->item_type=='Frozen') selected @endif>Frozen</option>
<option value="Masala" @if($data->item_type=='Masala') selected @endif>Masala</option>
<option value="Grocery" @if($data->item_type=='Grocery') selected @endif>Grocery</option>
<option value="Vegetable" @if($data->item_type=='Vegetable') selected @endif>Vegetable</option>
<option value="Syrup" @if($data->item_type=='Syrup') selected @endif>Syrup</option>
<option value="Sauce" @if($data->item_type=='Sauce') selected @endif>Sauce</option>
<option value="Bakery" @if($data->item_type=='Bakery') selected @endif>Bakery</option>
<option value="Crush" @if($data->item_type=='Crush') selected @endif>Crush</option>
<option value="Dairy" @if($data->item_type=='Dairy') selected @endif>Dairy</option>
</select>  
</select>
<span class="text-danger">{{ $errors->first('item_type') }}</span>   
</div>
</div>


<div class="col-lg-3">
<div class="form-group">
<label for="" >Item Code</label>
{!! Form::text("item_code",$data->item_code,["class"=>"form-control","placeholder"=>"Item Code","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('item_code') }}</span>   
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
<div class="col-lg-4">
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

<div class="col-lg-4">
<div class="form-group">
<label for="" >Franchise Rate</label>
{!! Form::text("franchise_rate",$data->franchise_rate,["class"=>"form-control number_test","placeholder"=>"Enter  Franchise Rate","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('franchise_rate') }}</span>   
</div>
</div>
<!-- <div class="col-lg-2">
<div class="form-group">
<label for="" >HSN/SAC</label>
{!! Form::text("initial_qty",$data->initial_qty,["class"=>"form-control number_test","placeholder"=>"HSN/SAC","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('initial_qty') }}</span>   
</div>
</div> -->

<!--  <div class="col-lg-3">
          <div class="form-group">
     <label>Brands</label>
     <select class="form-control" name="thumb" id="thumb" required>
      <option value="">--Select Brands--</option>
@foreach($brands as $brand)
<option value="{{$brand->id}}">{{$brand->brand}}</option>
@endforeach
     </select>

        </div> 
     </div> -->
  



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
</div>


{!! Form::close() !!}




