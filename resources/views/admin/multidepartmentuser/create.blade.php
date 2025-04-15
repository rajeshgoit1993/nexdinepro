@extends("layouts.backend.master")

@section('maincontent')
<style>
 

  </style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<div class="flex-container">
<?php
$request_segment=Request::segment(1);

 ?>
 @if($request_segment=='Edit-User')
<div class="flex-item-left"><h5>Edit User</h5></div>
<div class="flex-item-right"><a href="{{URL::route('manage_dept_employee')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
 @elseif($request_segment=='Add-Manage-Multi-Dept-Employee')
<div class="flex-item-left"><h5>Add User</h5></div>
<div class="flex-item-right"><a href="{{URL::route('manage_dept_employee')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
@elseif($request_segment=='Add-Store')
<div class="flex-item-left"><h5>Add Store</h5></div>
<div class="flex-item-right"><a href="{{URL::route('manage_stores')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>

@elseif($request_segment=='Edit-Store')
<div class="flex-item-left"><h5>Edit Store</h5></div>
<div class="flex-item-right"><a href="{{URL::route('manage_stores')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>

@elseif($request_segment=='Add-Vendor')
<div class="flex-item-left"><h5>Add Vendor</h5></div>
<div class="flex-item-right"><a href="{{URL::route('manage_vendor')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>

@elseif($request_segment=='Edit-Vendor')
<div class="flex-item-left"><h5>Edit Vendor</h5></div>
<div class="flex-item-right"><a href="{{URL::route('manage_vendor')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>

@elseif($request_segment=='Add-Factory')
<div class="flex-item-left"><h5>Add Factory</h5></div>
<div class="flex-item-right"><a href="{{URL::route('manage_factory')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>

@elseif($request_segment=='Edit-Factory')
<div class="flex-item-left"><h5>Edit Factory</h5></div>
<div class="flex-item-right"><a href="{{URL::route('manage_factory')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>

@elseif($request_segment=='Add-Staff')
<div class="flex-item-left"><h5>Add Staff</h5></div>
<div class="flex-item-right"><a href="{{URL::route('manage_staff')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
@elseif($request_segment=='Edit-Staff')
<div class="flex-item-left"><h5>Add Staff</h5></div>
<div class="flex-item-right"><a href="{{URL::route('manage_staff')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
@endif







</div>


</div>
</section>
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<!-- /.content -->

<!---->

<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>

<div class="container">
   <br />
<?php
$request_segment=Request::segment(1);

 ?>
  
   <form method="post" id="registration_form" name="register_form">
 @if($request_segment=='Edit-User')
<input type="hidden" name="level" value="1" id="level">
 @elseif($request_segment=='Add-Manage-Multi-Dept-Employee')
<input type="hidden" name="level" value="1" id="level">
@elseif($request_segment=='Add-Store')
<input type="hidden" name="level" value="2" id="level">
@elseif($request_segment=='Edit-Store')
<input type="hidden" name="level" value="2" id="level">

@elseif($request_segment=='Add-Vendor')

<input type="hidden" name="level" value="3" id="level">
@elseif($request_segment=='Edit-Vendor')
<input type="hidden" name="level" value="3" id="level">

@elseif($request_segment=='Add-Factory')
<input type="hidden" name="level" value="4" id="level">
@elseif($request_segment=='Edit-Factory')
<input type="hidden" name="level" value="4" id="level">

@elseif($request_segment=='Add-Staff')
<input type="hidden" name="level" value="5" id="level">
@elseif($request_segment=='Edit-Staff')
<input type="hidden" name="level" value="5" id="level">
@endif

    <ul class="nav nav-tabs">
     <li class="nav-item login_part">
      <a class="nav-link active_tab1" style="border:1px solid #ccc" id="list_login_details">Baisc Details</a>
     </li>
  <!--    <li class="nav-item">
      <a class="nav-link inactive_tab1" id="list_personal_details" style="border:1px solid #ccc">Extra Detail Filled by Employee</a>
     </li> -->
   
   

  
   
    </ul>
    <div class="tab-content" style="margin-top:16px;">
    @include('admin.multidepartmentuser.basicdetails')
    @include('admin.multidepartmentuser.extradetails')
   
    </div>
  

   </form>
  </div>







<!-- /.content -->
</div>
</section>

</div>

</div>
</section>

</div>
@endsection
@section('custom_js')
<!-- <script src="{{asset('/resources/assets/admin-lte/plugins/jsgrid/demos/db.js')}}"></script> -->
<script src="{{asset('/resources/assets/admin-lte/plugins/jsgrid/jsgrid.min.js')}}"></script>
<!-- <script src="{{asset('/resources/assets/admin-lte/js/form_validation.js')}}"></script> -->
<script type="text/javascript">
	//
	 $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
 	// 
 	 


$(document).on("change","#state",function(){
var state_id=$('option:selected', this).attr('state_id')
 $("#overlay").fadeIn(300);
	 var APP_URL=$("#APP_URL").val();
	 $.ajax({
        url:APP_URL+'/get_dist',
        data:{state_id:state_id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
        	  $("#overlay").fadeOut(300);
        	$("#dist").html('').html(data)
           $("#city").html('').html('<option value="">--Select City--</option>')
      
        },
        error:function(data)
        {

        }
    })


})
$(document).on("change","#dist",function(){
var dist_id=$('option:selected', this).attr('dist_id')
$("#overlay").fadeIn(300);
	 var APP_URL=$("#APP_URL").val();
	 $.ajax({
        url:APP_URL+'/get_city',
        data:{dist_id:dist_id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
        	  $("#overlay").fadeOut(300);
        	$("#city").html('').html(data)
           
      
        },
        error:function(data)
        {

        }
    })


})
//
 $('#btn_login_updates').click(function(){
  
  var error_email = '';
  var error_name = '';
  var error_user_role = '';
  var error_mobile = '';
  // var error_birthday = '';
  var error_state = '';
  var error_dist = '';
  var error_city = '';
   var error_address = '';
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  
  if($.trim($('#user_role').val()).length == 0)
  {
   error_user_role = 'Kindly Select Role';
   $('#error_user_role').text(error_user_role);
   $('#user_role').addClass('has-error');
  }
  else
  {
    error_user_role = '';
    $('#error_user_role').text(error_user_role);
    $('#user_role').removeClass('has-error');
  }
  
  if($.trim($('#email').val()).length == 0)
  {
   error_email = 'Email ID is required';
   $('#error_email').text(error_email);
   $('#email').addClass('has-error');
  }
  else
  {
   error_email = '';
   $('#error_email').text(error_email);
   $('#email').removeClass('has-error');
  }
  if($.trim($('#name').val()).length == 0)
  {
   error_name = 'Name is required';
   $('#error_name').text(error_name);
   $('#name').addClass('has-error');
  }
  else
  {
   error_user_id = '';
   $('#error_name').text(error_name);
   $('#name').removeClass('has-error');
  }
   if($.trim($('#mobile').val()).length == 0)
  {
   error_mobile = 'Mobile No is required';
   $('#error_mobile').text(error_mobile);
   $('#mobile').addClass('has-error');
  }
  else
  {
   error_mobile = '';
   $('#error_mobile').text(error_mobile);
   $('#mobile').removeClass('has-error');
  }
  // if($.trim($('#birthday').val()).length == 0)
  // {
  //  error_birthday = 'DOB is required';
  //  $('#error_birthday').text(error_birthday);
  //  $('#birthday').addClass('has-error');
  // }
  // else
  // {
  //  error_birthday = '';
  //  $('#error_birthday').text(error_birthday);
  //  $('#birthday').removeClass('has-error');
  // }
  if($.trim($('#state').val()).length == 0)
  {
   error_state = 'Kindly Select State';
   $('#error_state').text(error_state);
   $('#state').addClass('has-error');
  }
  else
  {
   error_state = '';
   $('#error_state').text(error_state);
   $('#state').removeClass('has-error');
  }
  if($.trim($('#dist').val()).length == 0)
  {
   error_dist = 'Kindly Select District';
   $('#error_dist').text(error_dist);
   $('#dist').addClass('has-error');
  }
  else
  {
   error_dist = '';
   $('#error_dist').text(error_dist);
   $('#dist').removeClass('has-error');
  }
   if($.trim($('#city').val()).length == 0)
  {
   error_city = 'Kindly Select city';
   $('#error_city').text(error_city);
   $('#city').addClass('has-error');
  }
  else
  {
   error_city = '';
   $('#error_city').text(error_city);
   $('#city').removeClass('has-error');
  }
  if($.trim($('#address').val()).length == 0)
  {
   error_address = 'Kindly Enter Address';
   $('#error_address').text(error_address);
   $('#address').addClass('has-error');
  }
  else
  {
   error_address = '';
   $('#error_address').text(error_address);
   $('#address').removeClass('has-error');
  }

  if(error_user_role != '' || error_user_id != '' || error_name != '' || error_mobile != '' ||  error_state != '' || error_dist != '' || error_city != '' || error_address != '')
  {
   return false;
  }
  else
  {
  	$("#overlay").fadeIn(300);
  var form_data = new FormData($("#registration_form")[0]);
 var APP_URL=$("#APP_URL").val();
 var level=$("#level").val()
  $.ajax({
        url:APP_URL+'/user_register_update',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Saved Login Details', "success");
       if(level==1)
        {
        var url=APP_URL+'/Manage-Multi-Dept-Employee';
        window.location.href = url;
        }
        else if(level==2)
        {
        var url=APP_URL+'/Manage-Stores';
        window.location.href = url;
        }
        else if(level==3)
        {
        var url=APP_URL+'/Manage-Vendors';
        window.location.href = url;
        }
        else if(level==4)
        {
        var url=APP_URL+'/Manage-Factory';
        window.location.href = url;
        }
        else if(level==5)
        {
        var url=APP_URL+'/Manage-Staff';
        window.location.href = url;
        }
       }
       else
      {
        swal("Error", data, "error"); 
       
       }

        },
        error:function(data)
        {

        }
    })



  }
 });
//
$('#btn_login_details').click(function(){
  
  var error_email = '';
  var error_name = '';
  var error_user_role = '';
  var error_mobile = '';
  var error_birthday = '';
  var error_state = '';
  var error_dist = '';
  var error_city = '';
   var error_address = '';
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  
  if($.trim($('#user_role').val()).length == 0)
  {
   error_user_role = 'Kindly Select Role';
   $('#error_user_role').text(error_user_role);
   $('#user_role').addClass('has-error');
  }
  else
  {
    error_user_role = '';
    $('#error_user_role').text(error_user_role);
    $('#user_role').removeClass('has-error');
  }
  
  if($.trim($('#email').val()).length == 0)
  {
   error_email = 'Email ID is required';
   $('#error_email').text(error_email);
   $('#email').addClass('has-error');
  }
  else
  {
   error_email = '';
   $('#error_email').text(error_email);
   $('#email').removeClass('has-error');
  }
  if($.trim($('#name').val()).length == 0)
  {
   error_name = 'Name is required';
   $('#error_name').text(error_name);
   $('#name').addClass('has-error');
  }
  else
  {
   error_user_id = '';
   $('#error_name').text(error_name);
   $('#name').removeClass('has-error');
  }
   if($.trim($('#mobile').val()).length == 0)
  {
   error_mobile = 'Mobile No is required';
   $('#error_mobile').text(error_mobile);
   $('#mobile').addClass('has-error');
  }
  else
  {
   error_mobile = '';
   $('#error_mobile').text(error_mobile);
   $('#mobile').removeClass('has-error');
  }
  // if($.trim($('#birthday').val()).length == 0)
  // {
  //  error_birthday = 'DOB is required';
  //  $('#error_birthday').text(error_birthday);
  //  $('#birthday').addClass('has-error');
  // }
  // else
  // {
  //  error_birthday = '';
  //  $('#error_birthday').text(error_birthday);
  //  $('#birthday').removeClass('has-error');
  // }
  if($.trim($('#state').val()).length == 0)
  {
   error_state = 'Kindly Select State';
   $('#error_state').text(error_state);
   $('#state').addClass('has-error');
  }
  else
  {
   error_state = '';
   $('#error_state').text(error_state);
   $('#state').removeClass('has-error');
  }
  if($.trim($('#dist').val()).length == 0)
  {
   error_dist = 'Kindly Select District';
   $('#error_dist').text(error_dist);
   $('#dist').addClass('has-error');
  }
  else
  {
   error_dist = '';
   $('#error_dist').text(error_dist);
   $('#dist').removeClass('has-error');
  }
   if($.trim($('#city').val()).length == 0)
  {
   error_city = 'Kindly Select city';
   $('#error_city').text(error_city);
   $('#city').addClass('has-error');
  }
  else
  {
   error_city = '';
   $('#error_city').text(error_city);
   $('#city').removeClass('has-error');
  }
  if($.trim($('#address').val()).length == 0)
  {
   error_address = 'Kindly Enter Address';
   $('#error_address').text(error_address);
   $('#address').addClass('has-error');
  }
  else
  {
   error_address = '';
   $('#error_address').text(error_address);
   $('#address').removeClass('has-error');
  }

  if(error_user_role != '' || error_user_id != '' || error_name != '' || error_mobile != '' ||  error_state != '' || error_dist != '' || error_city != '' || error_address != '')
  {
   return false;
  }
  else
  {
    $("#overlay").fadeIn(300);
  var form_data = new FormData($("#registration_form")[0]);
 var APP_URL=$("#APP_URL").val();
   var level=$("#level").val()
  $.ajax({
        url:APP_URL+'/user_register',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Saved Login Details', "success");
      
        if(level==1)
        {
        var url=APP_URL+'/Manage-Multi-Dept-Employee';
        window.location.href = url;
        }
        else if(level==2)
        {
        var url=APP_URL+'/Manage-Stores';
        window.location.href = url;
        }
        else if(level==3)
        {
        var url=APP_URL+'/Manage-Vendors';
        window.location.href = url;
        }
        else if(level==4)
        {
        var url=APP_URL+'/Manage-Factory';
        window.location.href = url;
        }
        else if(level==5)
        {
        var url=APP_URL+'/Manage-Staff';
        window.location.href = url;
        }
     
       }
       else
      {
        swal("Error", data, "error"); 
       
       }

        },
        error:function(data)
        {

        }
    })



  }
 });
   //
 
    </script>
@endsection