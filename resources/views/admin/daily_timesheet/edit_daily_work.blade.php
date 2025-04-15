{!! Form::open(["files"=>true,'id'=>'update_daily_task'])!!}
<input type="hidden" name="id" value="{{$data->id}}">

<!-- Modal content-->
<div class="">

<div class="modal-body">
	<div class="row">


       <div class="col-md-12">
         <div class="form-group">
  <label for="" class="required">Description of Task</label>
      <textarea class="form-control" name="desc_of_task" required>{{$data->desc_of_task}}</textarea>
   </div> 
                    
      </div>


 <div class="col-md-6">
         <div class="form-group">
  <label for="" class="required">Assign Employee</label>
      <select class="form-control" name="assign_user"  required>
<option value="{{Sentinel::getUser()->id}}">Self Assign</option>
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
  <label for="" class="required">Priority</label>
     <select class="form-control" name="priority"  required>
      <option value="High" @if($data->priority=='High') selected @endif>High</option>
      <option value="Medium" @if($data->priority=='Medium') selected @endif>Medium</option>
      <option value="Low" @if($data->priority=='Low') selected @endif>Low</option>
     </select>
   </div> 
                    
      </div>
<div class="col-md-6">
         <div class="form-group">
  <label for="" >Any Attachments</label>
  @if($data->doc!='')
       
      <a href="{{url('public/uploads/daily_task/'.$data->doc)}}" target="_blank">View</a>
       @endif
    <input type="file" name="doc" class="form-control">
   </div> 
                    
      </div>

<div class="col-md-6">
         <div class="form-group">
  <label for="" class="required">Completed By</label>
    <input type="date" name="completed_by" value="{{$data->completed_by}}" class="form-control" required>
   </div> 
                    
      </div>


	</div>













</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Update',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}