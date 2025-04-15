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
  <div class="flex-item-left"><h5>Add Brand</h5></div>
  <div class="flex-item-right"><a href="{{URL::route('brand_list')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
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
<div class="col-lg-4">
<div class="form-group">
<label for="" >Brand Logo</label>
{!! Form::file("brand_logo",["class"=>"form-control","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('brand_logo') }}</span>   
</div>
</div>
<div class="col-lg-4">
<div class="form-group">
<label for="" >Brand Name</label>

{!! Form::text("brand",null,["class"=>"form-control","placeholder"=>"Brand Name","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('brand') }}</span>   
</div>
</div>
<div class="col-lg-4">
<div class="form-group">
<label for="" >Terms</label>

{!! Form::text("terms",null,["class"=>"form-control","placeholder"=>"Enter Terms","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('terms') }}</span>   
</div>
</div>
<div class="col-lg-12">
<div class="form-group">
<label for="" >Extra Policy</label>

  <textarea class="form-control checking input_check"  name="extra_policy" rows="4" placeholder="Enter Meta Description"></textarea> 
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
<script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>

<script type="text/javascript">
	CKEDITOR.replace( 'extra_policy' );
</script>
@endsection