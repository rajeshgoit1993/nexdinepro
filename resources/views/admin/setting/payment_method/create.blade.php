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
  <div class="flex-item-left"><h5>Add POS Payment Method</h5></div>
  <div class="flex-item-right"><a href="{{URL::route('pos_payment_menthod')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
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
<label for="" >Payment Method</label>
{!! Form::text("name",null,["class"=>"form-control","placeholder"=>"Payment Method","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('name') }}</span>   
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label for="" >Status</label>
<select class="form-control" name="status">	
<option value="1">Active</option>
<option value="0">Inactive</option>
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