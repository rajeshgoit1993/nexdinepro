@extends("layouts.backend.master")

@section('maincontent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
	<section class="col-lg-12 connectedSortable">
	<div class="card direct-chat direct-chat-primary">
		<div class="flex-container">
  <div class="flex-item-left"><h5>Add Supply list</h5></div>
  <div class="flex-item-right"><a href="{{URL::route('supplyitem_list')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
</div>


</div>
</section>
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<!-- /.content -->

<!---->
{!! Form::open(["files"=>true])!!}


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
</select>
<span class="text-danger">{{ $errors->first('item_type') }}</span>   
</div>
</div>
 <div class="col-lg-3">
          <div class="form-group">
     <label>Brands</label>
     <select class="form-control" name="thumb" id="thumb" required>
      <option value="">--Select Brands--</option>
@foreach($brands as $brand)
<option value="{{$brand->id}}">{{$brand->brand}}</option>
@endforeach
     </select>

        </div> 
     </div>
     


<div class="col-lg-3">
<div class="form-group">
<label for="" >Item Name</label>
{!! Form::text("product_name",null,["class"=>"form-control","placeholder"=>"Enter  Name","required"=>""]) !!}
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
<option value="{{$unit->id}}">{{$unit->unit}}</option>
@endforeach
</select>
<span class="text-danger">{{ $errors->first('unit') }}</span>  
</div>
</div>
<div class="col-lg-2">
<div class="form-group">
<label for="" >Company Rate</label>
{!! Form::text("rate_margin",null,["class"=>"form-control number_test","placeholder"=>"Enter  Company Rate","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('rate_margin') }}</span>   
</div>
</div>
<div class="col-lg-2">
<div class="form-group">
<label for="" >Fanchise Rate</label>
{!! Form::text("rate_fanchise",null,["class"=>"form-control number_test","placeholder"=>"Enter  Fanchise Rate","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('rate_fanchise') }}</span>   
</div>
</div>
<div class="col-lg-2">
<div class="form-group">
<label for="" >Initial Quantity</label>
{!! Form::text("initial_qty",null,["class"=>"form-control number_test","placeholder"=>"Initial Quantity","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('initial_qty') }}</span>   
</div>
</div>
<div class="col-lg-2">
<div class="form-group">
<label for="" >Threshold Quantity</label>
{!! Form::text("threshold_qty",null,["class"=>"form-control number_test","placeholder"=>"Enter  Threshold Quantity","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('threshold_qty') }}</span>   
</div>
</div>
<div class="col-lg-4">
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
<div class="col-lg-6">
<div class="form-group">
<label for="" >Select Factory</label>
<select class="form-control select2" name="factory[]" multiple>

@foreach($factories as $factory)
<option value="{{$factory->id}}">{{$factory->name}}</option>
@endforeach
</select>
 
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label for="" >Select Vendor</label>
<select class="form-control select2" name="vendor[]" multiple>

@foreach($vendors as $vendor)
<option value="{{$vendor->id}}">{{$vendor->name}}</option>
@endforeach
</select>
 
</div>
</div>
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








<!-- /.content -->
</div>
</section>

</div>

</div>
</section>

</div>
@endsection
@section('custom_js')
<script type="text/javascript">
$(document).on("keyup change",".number_test",function(){
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');

})

</script>
@endsection