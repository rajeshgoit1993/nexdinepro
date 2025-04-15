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
  <div class="flex-item-left"><h5>Add Region</h5></div>
  <div class="flex-item-right"><a href="{{URL::route('region')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
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
<label for="" >Enter Region</label>
{!! Form::text("region_name",null,["class"=>"form-control","placeholder"=>"Enter Region","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('region_name') }}</span>   
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label for="" >Assign Area Manager</label>
<select class="form-control"  name="assign_area_manager">
 <option value="">--Select Area Manager--</option>  
 @foreach($users as $user)
<option value="{{$user->id}}"> {{$user->name}}</option>
 @endforeach
</select>
</div>
</div>
<div class="col-lg-12">
<div class="form-group">
<label for="" >Select Outlet</label>
<select class="form-control select2" name="assign_outlet[]" multiple>	
 @foreach($data as $datas)
    @if(!in_array($datas->id, $previous_ids))
  
     <option value="{{$datas->id}}">{{ $datas->name }} ({{$datas->city}}) </option>
     @endif
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