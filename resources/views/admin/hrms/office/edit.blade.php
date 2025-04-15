{!! Form::open(["files"=>true,'id'=>'update_office'])!!}
<input type="hidden" name="id" value="{{$data->id}}">

<!-- Modal content-->
<div class="">

<div class="modal-body">



<div class="form-group">
<label for="" class="required">Office Address</label>
<input type="text" name="location" value="{{$data->location}}" required class="form-control" placeholder="Office Address">
</div>


<div class="form-group">
<label for="" class="required">Office Latitude</label>
<input type="text" name="latitude" value="{{$data->latitude}}" required class="form-control" placeholder="Office Latitude">
</div>

<div class="form-group">
<label for="" class="required">Office Longitude</label>
<input type="text" name="longitude" value="{{$data->longitude}}" required class="form-control" placeholder="Office Longitude">
</div>



</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}