{!! Form::open(["files"=>true,'id'=>'update_meeting'])!!}
<input type="hidden" name="id" value="{{$data->id}}">

<!-- Modal content-->
<div class="">

<div class="modal-body">
	<div class="row">
 <div class="col-md-12">
         <div class="form-group">
  <label for="" class="required">Description of Meeting</label>
      <textarea class="form-control" name="desc_of_task" required>{{$data->desc_of_task}}</textarea>
   </div> 
                    
      </div>


 <div class="col-md-12">
         <div class="form-group">
  <label for="" class="required">Select User</label>
      <select class="form-control select2" name="assign_user[]" multiple required>
<option value="">--Select User--</option>
@foreach($users as $user)
  <?php
    $sevtinel_activated=Sentinel::findById($user->id);

      ?>
    @if($activation = Activation::completed($sevtinel_activated))

    <option value="{{$user->id}}" @if(in_array($user->id,$assign_person_ids)) selected @endif>{{$user->name}}</option>

     @endif



@endforeach

</select> 
   </div> 
             
          
      </div>

<div class="col-md-6">
         <div class="form-group">
  <label for="" class="required">Meeting Start Time</label>
    <input type="datetime-local" name="meeting_start" class="form-control" min="{{date('Y-m-d H:i')}}" value="{{$data->meeting_start}}">
   </div> 
                    
      </div>


<div class="col-md-6">
         <div class="form-group">
  <label for="" class="required">Meeting End Time</label>
    <input type="datetime-local" name="meeting_end" class="form-control" min="{{date('Y-m-d H:i')}}" value="{{$data->meeting_end}}">
   </div> 
                    
      </div>

	</div>













</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Update',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}