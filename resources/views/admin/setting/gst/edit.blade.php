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
  <div class="flex-item-left"><h5>Edit GST</h5></div>
  <div class="flex-item-right"><a href="{{URL::route('gst_list')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
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
<div class="col-lg-6">
<div class="form-group">
<label for="" >GST Value</label>

{!! Form::text("gst_value",$data->gst_value,["class"=>"form-control","placeholder"=>"Enter  GST Value","required"=>"",'min'=>1]) !!}
<span class="text-danger">{{ $errors->first('gst_value') }}</span>   
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label for="" >GST Name</label>
{!! Form::text("gst_name",$data->gst_name,["class"=>"form-control","placeholder"=>"Enter  GST Name","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('initial_qty') }}</span>   
</div>
</div>
</div>




</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Update',["class"=>"btn btn-success"]) !!}

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

@endsection