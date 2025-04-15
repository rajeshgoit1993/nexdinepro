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

<div class="flex-item-left"><h5>Add Basic Details</h5></div>





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

  
   <form method="post" id="registration_form" name="register_form">

 
  
<div class="tab-pane active" id="login_details">
      <div class="panel panel-default">
       <div class="panel-heading"></div>
       <div class="panel-body">
     <div class="row">
             <div class="col-md-6">
      
   <div class="form-group">
<label for="package">Fanchise Type</label>

<select class="form-control" name="user_role" id="user_role">
      <option value="">--Select Role--</option>
  @foreach($all_roles as $role)
<option value="{{$role->slug}}">{{$role->name}}</option>
  @endforeach
</select>
  <span id="error_user_role" class="text-danger"></span>
</div>
    </div> 

     
     <div class="col-lg-6">
          <div class="form-group">
     <label>User ID <span style="font-size: 10px;">(Personal Email ID)</span></label>
     <input type="text" name="email" id="user_id" class="form-control"  placeholder="Enter Franchisee Mail ID" />
     <span id="error_user_id" class="text-danger"></span>
        </div> 
     </div>
     
     <div class="col-lg-6">
          <div class="form-group">
     <label>Official Email ID</label>
     <input type="text" name="user_id" id="email" class="form-control"  placeholder="Enter Official Email ID" />
     <span id="error_email" class="text-danger"></span>
        </div> 
     </div>


     <div class="col-lg-6">
          <div class="form-group">
     <label>Name</label>
     <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" />
     <span id="error_name" class="text-danger"></span>
        </div> 
     </div>

       <div class="col-lg-6">
          <div class="form-group">
     <label>Mobile No</label>
     <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter Mobile No"  />
     <span id="error_mobile" class="text-danger"></span>
        </div> 
     </div>
       
     

    <div class="col-lg-6">
          <div class="form-group">
     <label>DOB</label>
     <input type="date" name="birthday" value=""  id="birthday" class="form-control" placeholder="Enter DOB" />
     <span id="error_birthday" class="text-danger"></span>
        </div> 
     </div>

       <div class="col-lg-6">
          
          <div class="form-group">
     <label>State</label>
     <select name="state" id="state" class="form-control">
     <option value="">--Select State--</option>
     @foreach($states as $state)
     <option value="{{ $state->state_title }}" state_id="{{ $state->id }}">{{ $state->state_title }}</option>
     @endforeach
     </select >

     <span id="error_state" class="text-danger"></span>
        </div> 
     </div>
      <div class="col-lg-6">
          <div class="form-group">
     <label>District</label>
     <select name="dist" id="dist" class="form-control">
     <option value="">--Select District--</option>
   
     </select >

     <span id="error_dist" class="text-danger"></span>
        </div> 
     </div>
      <div class="col-lg-6">
          <div class="form-group">
     <label>City</label>
     <select name="city" id="city" class="form-control">
     <option value="">--Select City--</option>
   
     </select >

     <span id="error_city" class="text-danger"></span>
        </div> 
     </div>
       <div class="col-lg-6 ">
          <div class="form-group fanchise_list">
     <label>Fanchises List</label>
     <select name="fanchise_list" id="fanchise_list" class="form-control ">
     <option value="">--Select Fanchise--</option>
   
     </select >

     <span id="error_city" class="text-danger"></span>
        </div> 
     </div>
       <div class="col-lg-12">
          <div class="form-group">
     <label>Address</label>
     <textarea name="address" id="address" class="form-control"></textarea>
     
     <span id="error_address" class="text-danger"></span>
        </div> 
     </div>
     </div>
     <!---->
<h4>For POS</h4>
<div class="row">

   <div class="col-lg-6">
          <div class="form-group">
     <label>Firm's Registered name</label>
    <input type="text" name="firm_name" id="firm_name" class="form-control" placeholder="Firm's Registered name"  />

     <span id="error_firm_name" class="text-danger"></span>
        </div> 
     </div>
       <div class="col-lg-6 ">
          <div class="form-group">
     <label>GST Number</label>
    <input type="text" name="gst" id="gst" class="form-control" placeholder="Enter GST"  />

     <span id="error_gst" class="text-danger"></span>
        </div> 
     </div>
       <div class="col-lg-12">
          <div class="form-group">
     <label>Outlet Address</label>
     <textarea name="outlet_address" id="outlet_address" class="form-control"></textarea>
     
     <span id="error_outlet_address" class="text-danger"></span>
        </div> 
     </div>

</div>
<!---->
<h4>Franchise Fee</h4>

   <div class="row">
   <div class="col-lg-6">
       <label>Subscription Type</label>
   <select class="form-control royality" name="subscription_type" id="subscription_type" style="">

<option value="1" >Monthly</option>
<option value="2">Yearly</option>
</select>
 <span id="error_subscription_type" class="text-danger"></span>
<!-- <input type="text" class="form-control number_test royality_percentage number_test" name="royality_percentage" placeholder="Enter Royality Percentage"  style="padding: 5px;color: #4a4a4a;min-width: 60px;"> -->
</div>
<div class="col-lg-6">
 <div class="form-group">
         <label>Subscription Value</label>
         <input type="text" name="subscription_value" id="subscription_value" class="form-control number_test subscription_value"  />
         <span id="error_subscription_value" class="text-danger"></span>
        </div>
</div>
   </div>

<h4>Amount Receiving Part</h4>
 <div class="row">



<div class="col-lg-4">
 <div class="form-group">
        <label>Amount Received Date</label>

<input type="date" max="{{date('Y-m-d')}}" class="form-control" name="advance_reveived_date" id="advance_reveived_date" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_advance_reveived_date" class="text-danger"></span> 
        </div>
</div>


<div class="col-lg-4">
 <div class="form-group">
        <label>Mode of Payment</label>

<input type="text" class="form-control" name="mode_of_advance" id="mode_of_advance" placeholder="Mode of Payment" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_mode_of_advance" class="text-danger"></span> 
        </div>
</div>
<div class="col-lg-4">
 <div class="form-group">
        <label>Ref No</label>

<input type="text" class="form-control" name="ref_no_advance" id="ref_no_advance" placeholder="Ref No" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_ref_no_advance" class="text-danger"></span> 
        </div>
</div>
<!---->
 





<!---->
   </div>



<!---->

        <br />

<!---->

        <div align="center">
         <button type="button" name="btn_login_details" id="btn_login_details" class="btn btn-info btn-lg">Save</button>
        </div>
        <br />
       </div>
      </div>
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
  $(document).on("keyup change",".number_test",function(){
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');

})

  $(document).ready(function(){
  //fanchise_list
  var user_role=$("#user_role").val();
  if(user_role=='masterfanchise')
  {
    $(".fanchise_list").css("display","block")
  }
  else
  {
    $(".fanchise_list").css("display","none")
  }
$("#user_role").change(function(){
var user_role=$(this).val()
if(user_role=='masterfanchise')
{
   $(".fanchise_list").css("display","block")
}
else
{
$(".fanchise_list").css("display","none")
}
})



})
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

//
$('#btn_login_details').click(function(){
  


  var error_user_id = '';
  var error_name = '';
  var error_user_role = '';
  var error_mobile = '';

  var error_state = '';
  var error_dist = '';
  var error_city = '';
  var error_address = '';


  var error_outlet_address= '';
  var error_subscription_type= '';
  var error_subscription_value= '';

         
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
  
  if($.trim($('#user_id').val()).length == 0)
  {
   error_user_id = 'User ID is required';
   $('#error_user_id').text(error_user_id);
   $('#user_id').addClass('has-error');
  }
  else
  {
   error_user_id = '';
   $('#error_user_id').text(error_user_id);
   $('#user_id').removeClass('has-error');
  }
   
  if($.trim($('#name').val()).length == 0)
  {
   error_name = 'Name is required';
   $('#error_name').text(error_name);
   $('#name').addClass('has-error');
  }
  else
  {
   error_name = '';
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
  

  if($.trim($('#outlet_address').val()).length == 0)
  {
   error_outlet_address = 'Kindly Enter Outlet Address';
   $('#error_outlet_address').text(error_outlet_address);
   $('#outlet_address').addClass('has-error');
  }
  else
  {
   error_outlet_address = '';
   $('#error_outlet_address').text(error_outlet_address);
   $('#outlet_address').removeClass('has-error');
  }

  if($.trim($('#subscription_type').val()).length == 0)
  {
   error_subscription_type = 'Kindly Select Subscription Type';
   $('#error_subscription_type').text(error_subscription_type);
   $('#subscription_type').addClass('has-error');
  }
  else
  {
   error_subscription_type = '';
   $('#error_subscription_type').text(error_subscription_type);
   $('#subscription_type').removeClass('has-error');
  }

  if($.trim($('#subscription_value').val()).length == 0)
  {
   error_subscription_value = 'Kindly Enter Subscription Value';
   $('#error_subscription_value').text(error_subscription_value);
   $('#subscription_value').addClass('has-error');
  }
  else
  {
   error_subscription_value = '';
   $('#error_subscription_value').text(error_subscription_value);
   $('#subscription_value').removeClass('has-error');
  }
  //
 
  //error_email
  if(error_user_id != '' || error_name != '' ||  error_user_role != '' || error_mobile != '' ||  error_state != '' || error_dist != '' || error_city != '' || error_address != '' || error_outlet_address != '' || error_subscription_type != '' || error_subscription_value != '' )
  {
   return false;
  }
  else
  {
    $("#overlay").fadeIn(300);
  var form_data = new FormData($("#registration_form")[0]);
 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/fanchise_register',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Saved Basic Details', "success");
         var url=APP_URL+'/Running-Franchise';
        window.location.href = url;
     
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