<?php 
$department_id=$user_details->department;

$designation_id=$user_details->designation;
$designation=CustomHelpers::get_master_table_data('designations','id',$designation_id,'designation');
$designation_level=CustomHelpers::get_master_table_data('designations','id',$designation_id,'designation_level');
$user_id=[];
if($designation_level=='Head Of Department'):
$user_id=DB::table('user_extra_details')->where([['department','=',$department_id],['store_id','!=',Sentinel::getUser()->id]])->pluck('store_id');
elseif($designation_level=='CEO'):
$user_id=DB::table('user_extra_details')->where('store_id','!=',Sentinel::getUser()->id)->pluck('store_id');
elseif($designation_level=='Director' || Sentinel::getUser()->inRole('superadmin')):
$user_id=DB::table('user_extra_details')->where('store_id','!=',Sentinel::getUser()->id)->pluck('store_id');
endif;
$all_users =DB::table('users')->whereIn('id',$user_id)->whereIn('status',[1,2])->get();


?>
<section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
        <div class="flex-container" style="padding:0px">


</div>


         <div class="row">

     <div class="col-md-10">
  
 <select name="brand" id="user_id" class="form-control valid" required>
   
    <option value="{{CustomHelpers::custom_encrypt(Sentinel::getUser()->id)}}">My Task</option>
@foreach($all_users as $user)
  <?php
    $sevtinel_activated=Sentinel::findById($user->id);

      ?>
    @if($activation = Activation::completed($sevtinel_activated))

    <option value="{{CustomHelpers::custom_encrypt($user->id)}}">{{$user->name}}</option>

     @endif



@endforeach

     </select >

      </div>
    

      <div class="col-md-2">
<button class="btn btn-success btn-block find">Find Task</button>

        </div>


</div>


</div>
</section>