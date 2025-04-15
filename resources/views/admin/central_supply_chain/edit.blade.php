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
  <div class="flex-item-left"><h5>Edit Central Supply Chain</h5></div>
  <div class="flex-item-right"><a href="{{URL::route('central_supply_chain_list')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
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
<label for="" >Central Supply Chain Name</label>

{!! Form::text("central_supply_chain_name",$data->central_supply_chain_name,["class"=>"form-control","placeholder"=>"Enter  Crockery","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('central_supply_chain_name') }}</span>   
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label for="" >Quantity</label>
{!! Form::text("initial_qty",$data->initial_qty,["class"=>"form-control","placeholder"=>"Enter  Quantity","required"=>""]) !!}
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