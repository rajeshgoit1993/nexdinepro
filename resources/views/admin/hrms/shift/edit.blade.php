{!! Form::open(["files"=>true,'id'=>'update_shift'])!!}
<input type="hidden" name="id" value="{{$data->id}}">

<!-- Modal content-->
<div class="">

<div class="modal-body">

<div class="form-group">
<label for="" class="required">Shift Name</label>
<input type="text" name="shift_name" value="{{$data->shift_name}}" required class="form-control" placeholder="Shift Name">
</div>

<div class="form-group">
<label for="" class="required">Login Time</label>
<input type="time" name="login_time" value="{{$data->login_time}}" required class="form-control" >
</div>

<div class="form-group">
<label for="" class="required">Lunch Start Time</label>
<input type="time" name="lunch_start_time" value="{{$data->lunch_start_time}}" required class="form-control" >
</div>

<div class="form-group">
<label for="" class="required">Lunch End Time</label>
<input type="time" name="lunch_end_time" value="{{$data->lunch_end_time}}" required class="form-control" >
</div>

<div class="form-group">
<label for="" class="required">Logout Time</label>
<input type="time" name="logout_time" value="{{$data->logout_time}}" required class="form-control" >
</div>

<!-- <div class="form-group">
<label for="" class="required">Lunch Duration(In Minutes)</label>
<input type="text" name="lunch_duration" value="{{$data->lunch_duration}}" required class="form-control" placeholder="Lunch Duration(In Minutes)">
</div> -->

<div class="form-group">
<label for="" class="required">Time Variances(In Minutes)</label>
<input type="text" name="login_variance" value="{{$data->login_variance}}"  required class="form-control" placeholder="Time Variances(In Minutes)">
</div>



</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}