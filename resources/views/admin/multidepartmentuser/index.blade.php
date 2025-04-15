@extends("layouts.backend.master")

@section('maincontent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
<?php  
  $request_segments=Request::segment(1);
  ?>
 @if($request_segments=='Manage-Multi-Dept-Employee') 
 <input type="hidden" name="level" value="1" id="level">
  <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    <div class="flex-container">
  <div class="flex-item-left"><h5>User List</h5></div>
   <div class="flex-item-right"><a href="{{URL::route('add_user')}}"><button class="btn btn-success"><span class="fa fa-plus"></span> Add User</button></a></div>
</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
</div>
</section>
@elseif($request_segments=='Manage-Stores')
<input type="hidden" name="level" value="2" id="level">
  <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    <div class="flex-container">
  <div class="flex-item-left"><h5>Stores List</h5></div>
   <div class="flex-item-right"><a href="{{URL::route('add_store')}}"><button class="btn btn-success"><span class="fa fa-plus"></span> Add Store</button></a></div>
</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
</div>
</section>
@elseif($request_segments=='Manage-Vendors')
<input type="hidden" name="level" value="3" id="level">
  <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    <div class="flex-container">
  <div class="flex-item-left"><h5>Vendors List</h5></div>
   <div class="flex-item-right"><a href="{{URL::route('add_vendor')}}"><button class="btn btn-success"><span class="fa fa-plus"></span> Add Vendor</button></a></div>
</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
</div>
</section>
@elseif($request_segments=='Manage-Factory')
<input type="hidden" name="level" value="4" id="level">
  <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    <div class="flex-container">
  <div class="flex-item-left"><h5>Factory List</h5></div>
   <div class="flex-item-right"><a href="{{URL::route('add_factory')}}"><button class="btn btn-success"><span class="fa fa-plus"></span> Add Factory</button></a></div>
</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
</div>
</section>
@elseif($request_segments=='Manage-Staff')
<input type="hidden" name="level" value="5" id="level">
  <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    <div class="flex-container">
  <div class="flex-item-left"><h5>Staff List</h5></div>
   <div class="flex-item-right"><a href="{{URL::route('add_staff')}}"><button class="btn btn-success"><span class="fa fa-plus"></span> Add Staff</button></a></div>
</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
</div>
</section>
@endif
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<!-- /.content -->
<div class="table-responsive">
  <table class="table table-bordered yajra-datatable">
        <thead>
    <tr>
      <th>Login ID</th>
      
      <th>Name</th>
    <!--   <th>Division</th> -->
      <th>Roles</th>
      <th>Status</th>
      <th>Kyc Status</th>
      <th>Actions</th>
    </tr>
  
  </thead>
   <tbody>
    <?php
$sn=1;
    ?>
    @foreach($user as $fanchise_detail)          

                  <tr id="role_{{$fanchise_detail->id}}">
                    <td>{{$fanchise_detail->email}}</td>
                      <td>
                      <span>{{$fanchise_detail->name}}
                    
                       
                      </span>
                    </td>
                    

                  

                    <td class="role_created_date">
                    <?php
                    $user_roles=DB::table('role_users')->where('user_id','=',$fanchise_detail->id)->get();
                        foreach($user_roles as $user_role):
      $role_slug = DB::table('roles')
            ->select('slug')
            ->where('id',$user_role->role_id)
            ->first();
           
     
    echo "<span style='display:block'>$role_slug->slug</span>";
     endforeach;
                    ?>
                      
                        
                      
                    </td>
                    <td>
  <?php
    $sevtinel_activated=Sentinel::findById($fanchise_detail->id);
    if ($activation = Activation::completed($sevtinel_activated))
    {
    echo "<p style='background:green;color:white;padding:2px 5px;text-align:center'>Activated</p>";
    }
   else
   {
    echo "<p style='background:#dd4b39;color:white;padding:2px 5px;text-align:center'>Not Act.</p>";
   }
  ?>
</td>
      <td>
<?php
    
    if ($fanchise_detail->status==2)
    {
    echo "<p style='background:green;color:white;padding:2px 5px;text-align:center'>Completed</p>";
    }
   else
   {
    echo "<p style='background:#dd4b39;color:white;padding:2px 5px;text-align:center'>Not Comp.</p>";
   }
  ?>
 
      </td>    



                   <td>
<div class="button_flex"> 

   @if($request_segments=='Manage-Vendors')
 <a href="#" class="edit_vendors button_left" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><button class="btn btn-default btn-sm" style="display:inline-block;margin-top:5px;width:100%"><span class="fa fa-edit"></span> KYC</button></a>
  @elseif($request_segments=='Manage-Staff')
  <a href="#" class="edit_staff button_left" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><button class="btn btn-default btn-sm" style="display:inline-block;margin-top:5px;width:100%"><span class="fa fa-edit"></span> KYC</button></a>

  @else
 <a href="#" class="edit_user button_left" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><button class="btn btn-default btn-sm" style="display:inline-block;margin-top:5px;width:100%"><span class="fa fa-edit"></span> KYC</button></a>
  @endif

<a href="#" class="view button_left"  data-toggle="modal" data-target="#view_modal_{{preg_replace('/[<=>]+/', '',CustomHelpers::custom_encrypt($fanchise_detail->id))}}" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-primary btn-sm"><span class="fa fa-eye"></span> View</button></a>

          <a href="#"  class="edit button_left" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}">
            <button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-success btn-sm"><span class="fa fa-edit"></span> Edit</button></a>
           <a href="#" class="button_left"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-danger delete btn-sm" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}" onclick="return confirm('Are you sure?');" ><span class="fa fa-archive"></span> Delete</button></a>
                 
  <?php
    $sevtinel_activated=Sentinel::findById($fanchise_detail->id);
      ?>
    @if ($activation = Activation::completed($sevtinel_activated))
  
    <a href="#" class="button_left"><button  style="display:inline-block;margin-top:5px;width:100%" class="btn btn-warning disable btn-sm" onclick="return confirm('Are you sure?');" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><span class="fa fa-times"></span> Disable </button></a>
   
   @else

    <a href="#" class="button_left"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-success enable btn-sm" onclick="return confirm('Are you sure?');" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><span class="fa fa-check"></span> Enable</button></a>
   
  
  @endif
 </div>


 
  <div class="modal fade" id="view_modal_{{preg_replace('/[<=>]+/', '',CustomHelpers::custom_encrypt($fanchise_detail->id))}}">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
           @if($request_segments=='Manage-Multi-Dept-Employee') 
 @include("admin.multidepartmentuser.user_details")
           @else
 @include("admin.multidepartmentuser.store_details")
           @endif
         
        </div>
       
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>

  
                    </td>

                  </tr>

                @endforeach
                </tbody>
    </table>










<!-- /.content -->
</div>
</div>
</section>

</div>

</div>
</section>

</div>

<div class="form">

</div>
@endsection
@section('custom_js')
<script type="text/javascript">
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     //disable
   $(document).on("click",".disable",function(){
    var id=$(this).attr('id')

     var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/disable_user',
        data:{id:id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
    
         swal("Done !", 'Successfully Updated', "success");
        setTimeout(function(){ location.reload(); }, 1000);
        },
        error:function(data)
        {

        }
    })
    })  
     //enable
   $(document).on("click",".enable",function(){
    var id=$(this).attr('id')

     var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/enable_user',
        data:{id:id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
    
         swal("Done !", 'Successfully Updated', "success");
        setTimeout(function(){ location.reload(); }, 1000);
        },
        error:function(data)
        {

        }
    })
    }) 
  //delete 
     $(document).on("click",".delete",function(){
    var id=$(this).attr('id')

     var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/delete_user',
        data:{id:id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
    
         swal("Done !", 'Successfully Updated', "success");
        setTimeout(function(){ location.reload(); }, 1000);
        },
        error:function(data)
        {

        }
    })
    }) 
     //edit_staff
        $(document).on("click",".edit_staff",function(){
    var id=$(this).attr('id')
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Edit-Franchise-Staff";
     var element2 = document.createElement("INPUT");         
    element2.name="_token"
    element2.value = $('meta[name="csrf-token"]').attr('content')
    element2.type = 'hidden'
    form.appendChild(element2);

   var element1 = document.createElement("INPUT");         
    element1.name="id"
    element1.value = id;
    element1.type = 'hidden'
    form.appendChild(element1);
  
    form.submit();

  })
     //edit_vendors
     $(document).on("click",".edit_vendors",function(){
    var id=$(this).attr('id')
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Edit-Vendor-Account";
     var element2 = document.createElement("INPUT");         
    element2.name="_token"
    element2.value = $('meta[name="csrf-token"]').attr('content')
    element2.type = 'hidden'
    form.appendChild(element2);

   var element1 = document.createElement("INPUT");         
    element1.name="id"
    element1.value = id;
    element1.type = 'hidden'
    form.appendChild(element1);
  
    form.submit();

  })
       //
  $(document).on("click",".edit_user",function(){
    var id=$(this).attr('id')
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Edit-Account";
     var element2 = document.createElement("INPUT");         
    element2.name="_token"
    element2.value = $('meta[name="csrf-token"]').attr('content')
    element2.type = 'hidden'
    form.appendChild(element2);

   var element1 = document.createElement("INPUT");         
    element1.name="id"
    element1.value = id;
    element1.type = 'hidden'
    form.appendChild(element1);
  
    form.submit();

  })
  //
  $(document).on("click",".edit",function(){
    var level=$("#level").val()
    if(level==1)
    {
        var id=$(this).attr('id')
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Edit-User";
     var element2 = document.createElement("INPUT");         
    element2.name="_token"
    element2.value = $('meta[name="csrf-token"]').attr('content')
    element2.type = 'hidden'
    form.appendChild(element2);

   var element1 = document.createElement("INPUT");         
    element1.name="id"
    element1.value = id;
    element1.type = 'hidden'
    form.appendChild(element1);
  
    form.submit();
    }
    else if(level==2)
    {
        var id=$(this).attr('id')
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Edit-Store";
     var element2 = document.createElement("INPUT");         
    element2.name="_token"
    element2.value = $('meta[name="csrf-token"]').attr('content')
    element2.type = 'hidden'
    form.appendChild(element2);

   var element1 = document.createElement("INPUT");         
    element1.name="id"
    element1.value = id;
    element1.type = 'hidden'
    form.appendChild(element1);
  
    form.submit();
    }
    else if(level==3)
    {
        var id=$(this).attr('id')
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Edit-Vendor";
     var element2 = document.createElement("INPUT");         
    element2.name="_token"
    element2.value = $('meta[name="csrf-token"]').attr('content')
    element2.type = 'hidden'
    form.appendChild(element2);

   var element1 = document.createElement("INPUT");         
    element1.name="id"
    element1.value = id;
    element1.type = 'hidden'
    form.appendChild(element1);
  
    form.submit();
    }
    else if(level==4)
    {
    var id=$(this).attr('id')
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Edit-Factory";
     var element2 = document.createElement("INPUT");         
    element2.name="_token"
    element2.value = $('meta[name="csrf-token"]').attr('content')
    element2.type = 'hidden'
    form.appendChild(element2);

   var element1 = document.createElement("INPUT");         
    element1.name="id"
    element1.value = id;
    element1.type = 'hidden'
    form.appendChild(element1);
  
    form.submit();
    }
  else if(level==5)
    {
    var id=$(this).attr('id')
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Edit-Staff";
     var element2 = document.createElement("INPUT");         
    element2.name="_token"
    element2.value = $('meta[name="csrf-token"]').attr('content')
    element2.type = 'hidden'
    form.appendChild(element2);

   var element1 = document.createElement("INPUT");         
    element1.name="id"
    element1.value = id;
    element1.type = 'hidden'
    form.appendChild(element1);
  
    form.submit();
    }
  

  })
    //
$(document).on("click",".remove",function(){
   var r = confirm("Are you sure ?");

     
       if (r === false) {
           return false;
        }
})
  //

  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
       
       order: [[3, 'asc']],
       
    });
    
  });
</script>

@endsection