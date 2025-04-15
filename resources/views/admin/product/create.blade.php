
{!! Form::open(["files"=>true,'id'=>'create_product_list'])!!}
<input type="hidden" name="outlet_id" value="{{$outlet_id}}">

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
<option value="Utensil">Utensil</option>
<option value="Equipment">Equipment</option>
<option value="Disposable">Disposable</option>
<option value="Frozen">Frozen</option>
<option value="Masala">Masala</option>
<option value="Grocery">Grocery</option>
<option value="Vegetable">Vegetable</option>
<option value="Syrup">Syrup</option>
<option value="Sauce">Sauce</option>
<option value="Bakery">Bakery</option>
<option value="Crush">Crush</option>
<option value="Dairy">Dairy</option>
</select>  
<span class="text-danger">{{ $errors->first('item_type') }}</span>   
</div>
</div>

<div class="col-lg-3">
<div class="form-group">
<label for="" >Item Code</label>
{!! Form::text("item_code",null,["class"=>"form-control","placeholder"=>"Item Code","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('item_code') }}</span>   
</div>
</div>


<div class="col-lg-3">
<div class="form-group">
<label for="" >Item Name</label>
{!! Form::text("product_name",null,["class"=>"form-control","placeholder"=>"Enter  Name","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('product_name') }}</span>   
</div>
</div>


<div class="col-lg-3">
<div class="form-group">
<label for="" >Unit</label>
<select class="form-control" name="unit" required>
<option value="">--Choose unit--</option>
@foreach($units as $unit)
<option value="{{$unit->id}}">{{$unit->unit}}</option>
@endforeach
</select>
<span class="text-danger">{{ $errors->first('unit') }}</span>  
</div>
</div>
<div class="col-lg-3">
<div class="form-group">
<label for="" >Threshold Quantity</label>
{!! Form::text("threshold_qty",null,["class"=>"form-control number_test","placeholder"=>"Enter  Threshold Quantity","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('threshold_qty') }}</span>   
</div>
</div>
<div class="col-lg-3">
<div class="form-group">
<label for="" >Available Quantity</label>
{!! Form::text("available_qty",null,["class"=>"form-control number_test","placeholder"=>"Enter Available Quantity","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('available_qty') }}</span>   
</div>
</div>
<div class="col-lg-3">
<div class="form-group">
<label for="" >GST</label>
<select class="form-control" name="gst_id" required>
<option value="">--Choose GST--</option>
@foreach($gsts as $gst)
<option value="{{$gst->id}}">{{$gst->gst_name}}</option>
@endforeach
</select>
<span class="text-danger">{{ $errors->first('gst_id') }}</span>   
</div>
</div>

<div class="col-lg-3">
<div class="form-group">
<label for="" >Rate</label>
{!! Form::text("franchise_rate",null,["class"=>"form-control number_test","placeholder"=>"Enter  Rate","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('franchise_rate') }}</span>   
</div>
</div>
<!-- <div class="col-lg-2">
<div class="form-group">
<label for="" >HSN/SAC</label>
{!! Form::text("initial_qty",null,["class"=>"form-control number_test","placeholder"=>"HSN/SAC","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('initial_qty') }}</span>   
</div>
</div> -->


<div class="col-lg-12">
<div class="form-group">
<label for="" >Description</label>
{!! Form::textarea("description",null,["class"=>"form-control","placeholder"=>"Enter  Description","rows"=>"2"]) !!}
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


