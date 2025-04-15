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

<div class="flex-item-left"> <h5>Edit Basic Details </h5></div>





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
   
   <a href="{{url()->previous()}}" class="btn btn-success" style="width: fit-content;"><span class="fa fa-arrow-left"></span> Back</a> 


  
   <form method="post" id="registration_form" name="register_form">
<input type="hidden" name="id" value="{{CustomHelpers::custom_encrypt($uers_data->id)}}">
 
  
<div class="tab-pane active" id="login_details">
      <div class="panel panel-default">
       <div class="panel-heading"></div>
       <div class="panel-body">

  @include('admin.fanchises.edit_page.basicdetails')
     

  


        <br />




        <div align="center">
         <button type="button" name="btn_login_details" id="btn_login_details" class="btn btn-info btn-lg">Update</button>
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
    //



  //

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

 //



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
        url:APP_URL+'/fanchise_launched_update',
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
         <?php  
  $request_segments=Request::segment(1);
         ?>
          
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