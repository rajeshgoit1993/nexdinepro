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
  <div class="flex-item-left"><h5>My Account</h5></div>
 <!--   <div class="flex-item-right"><a href="{{URL::route('add_user')}}"><button class="btn btn-success"><span class="fa fa-plus"></span> Add User</button></a></div> -->
</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
</div>
</section>
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
      <th>Actions</th>
    </tr>
  
  </thead>
   <tbody>
  
       

                  <tr id="">
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

<a href="#" class="view" data-toggle="modal" data-target="#view_modal_{{preg_replace('/[<=>]+/', '',CustomHelpers::custom_encrypt($fanchise_detail->id))}}" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><button class="btn btn-primary"><span class="fa fa-eye"></span> View</button></a>

                    @if($fanchise_detail->status!=2)

          <a href="#" class="edit" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><button class="btn btn-success"><span class="glyphicon glyphicon-edit"></span> Edit</button></a>
              @endif
  


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
      
 @include("admin.multidepartmentuser.user_details")
       
         
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
  //
  $(document).on("click",".edit",function(){
    var id=$(this).attr('id')
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Edit-User-Account";
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
$(document).on("click",".remove",function(){
   var r = confirm("Are you sure ?");

     
       if (r === false) {
           return false;
        }
})
  //

  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
       
       
       
    });
    
  });
</script>

@endsection