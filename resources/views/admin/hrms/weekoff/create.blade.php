{!! Form::open(["files"=>true,'id'=>'store_weekoff'])!!}


<!-- Modal content-->
<div class="">

<div class="modal-body">

<div class="form-group">
<label for="" class="required">Select Day</label>
<select class="form-control" name="week_day" required>   
 <option value="">--Select Day--</option> 
 <option value="Sunday">Sunday</option>
 <option value="Monday">Monday</option>
 <option value="Tuesday">Tuesday</option>
 <option value="Wednesday">Wednesday</option>
 <option value="Thursday">Thursday</option>
 <option value="Friday">Friday</option>
 <option value="Saturday">Saturday</option>
</select>
</div>




<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}