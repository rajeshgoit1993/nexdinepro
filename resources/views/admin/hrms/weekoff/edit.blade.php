{!! Form::open(["files"=>true,'id'=>'update_weekoff'])!!}
<input type="hidden" name="id" value="{{$data->id}}">

<!-- Modal content-->
<div class="">

<div class="modal-body">


<div class="form-group">
<label for="" class="required">Select Day</label>
<select class="form-control" name="week_day" required>   
 <option value="">--Select Day--</option> 
 <option value="Sunday" @if($data->week_day=='Sunday') selected @endif>Sunday</option>
 <option value="Monday" @if($data->week_day=='Monday') selected @endif>Monday</option>
 <option value="Tuesday" @if($data->week_day=='Tuesday') selected @endif>Tuesday</option>
 <option value="Wednesday" @if($data->week_day=='Wednesday') selected @endif>Wednesday</option>
 <option value="Thursday" @if($data->week_day=='Thursday') selected @endif>Thursday</option>
 <option value="Friday" @if($data->week_day=='Friday') selected @endif>Friday</option>
 <option value="Saturday" @if($data->week_day=='Saturday') selected @endif>Saturday</option>
</select>
</div>



</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}