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
  @include('admin.fanchises.step')

  
   <form method="post" id="registration_form" name="register_form">
<input type="hidden" name="id" value="{{CustomHelpers::custom_encrypt($uers_data->id)}}">
 
  
<div class="tab-pane active" id="login_details">
      <div class="panel panel-default">
       <div class="panel-heading"></div>
       <div class="panel-body">

  @include('admin.fanchises.edit_page.basicdetails')
     
<!---->


<span  @if(Sentinel::getUser()->roles[0]->id==1 || Sentinel::getUser()->roles[0]->id==16 || Sentinel::getUser()->roles[0]->id==6 || Sentinel::getUser()->roles[0]->id==7 || $uers_data->aurthorise_person_id==Sentinel::getUser()->id)  @else style="display:none" @endif>

 @include('admin.fanchises.edit_page.feedetails')
  
</span>


<!---->
@if($uers_data->status>=5)
 @include('admin.fanchises.edit_page.kycdetails')
@endif
        <br />

<!---->

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

      //laptop_part laptop_check
$('.partener_check').click(function(){
    if (this.checked) {
      $(".partener_part").css("display","block")

  var APP_URL=$("#APP_URL").val();
}
 else
    {
      $(".partener_part").css("display","none")
      }
})

    
   

 $('#add_more').click(function(e){
    e.preventDefault()
var name_count1=$(".laptop_dynamic").children("div:last").attr("id").slice(8)
var name_count=parseInt(name_count1)-"1";
name_count1++
name_count++

$(".laptop_dynamic").append('<div id="thirdrow'+name_count1+'"><div class="row"><div class="col-md-2"><div class="form-group"><label for="" class="required">Name</label><input type="text" id="holder0" name="partener['+name_count+'][name]" class="form-control" placeholder="Name"></div></div><div class="col-md-2"><div class="form-group"><label for="" class="required">Address</label> <input type="text" name="partener['+name_count+'][address]" class="form-control" placeholder="Address"></div></div><div class="col-md-2"><div class="form-group"><label for="" class="required">Mobile</label> <input type="text" name="partener['+name_count+'][mobile]" class="form-control" placeholder="Mobile"></div></div><div class="col-md-2"><div class="form-group"><label for="" class="required">DOB</label> <input type="date" name="partener['+name_count+'][dob]" class="form-control" placeholder="DOB">  </div></div><div class="col-md-2"><div class="form-group"><label for="" class="required">Anniversary</label> <input type="date" name="partener['+name_count+'][anniversary]" class="form-control" placeholder="Anniversary">  </div></div><div class="col-md-1"><div class="form-group"><label for="" class="required">Share</label> <input type="text" name="partener['+name_count+'][share]" class="form-control" placeholder="Share">  </div></div> <div class="col-md-1"><label for="" class="required" style="visibility:hidden">Share</label> <button type="button" name="remove" id="'+name_count1+'" class="btn btn-danger btn_remove_third" style="display:block">X </button></div> </div> </div>');

  })
 $(document).on('click', '.btn_remove_third', function() {
      var button_id = $(this).attr("id");
      $('#thirdrow'+button_id+'').remove();
      }
      );
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

  var gst=$(".gst").val();
  if(gst=='2')
  {
    $(".gst_percentage").css("display","none")
  }
  else
  {
    $(".gst_percentage").css("display","none")
  }
  $(".gst").change(function(){
      var gst=$(this).val();
      if(gst=='2')
  {
    $(".gst_percentage").css("display","none")
  }
  else
  {
    $(".gst_percentage").css("display","none")
  }
 //
 //
    
  //
 

  })
  //
  var royality=$(".royality").val();
    if(royality=='2')
    {
        $(".royality_percentage").css("display","block")
    }
    else
    {
        $(".royality_percentage").css("display","none")
    }
    $(".royality").change(function(){
            var royality=$(this).val();
            if(royality=='2')
    {
        $(".royality_percentage").css("display","block")
    }
    else
    {
        $(".royality_percentage").css("display","none")
    }
     })
  //
  $(document).on("keyup change",".booking_amount , .gst  , .gst_percentage , .gst_amount  ,  .total_booking_amount ,.first_installment,.seoond_installment,.third_installment , .total_received_amount , .total_pending_amount,.advance,.discount_amount,.advance_reveived,.first_installment_reveived,.second_installment_reveived,.third_installment_reveived",function(){
  var booking_amount=$(".booking_amount").val(); 
   if(booking_amount=='')
   {
    var booking_amount=0;
   }  
     var discount_amount=$(".discount_amount").val()
  if(discount_amount=='')
  {
      var discount_amount=0;
  }
   var booking_amount=parseFloat(booking_amount)-parseFloat(discount_amount);
   var gst=$(".gst").val();   
   var gst_percentage=$(".gst_percentage").val();
   var gst_amount=$(".gst_amount").val();
   var royality=$(".royality").val();
   var royality_percentage=$(".royality_percentage").val();
   var royality_amount=$(".royality_amount").val();
   var total_received_amount=$(".total_received_amount").val();
   var gst_amount=0;
   var royality_amount=0;
   if(gst==2)
   {
    if(booking_amount!='' && gst_percentage!='')
    {
    var gst_amount=booking_amount*gst_percentage/100;
      $(".gst_amount").val('').val(parseFloat(gst_amount))
    }
   }
   // if(royality==2)
   // {
   //  if(booking_amount!='' && royality_percentage!='')
   //  {
   //  var royality_amount=booking_amount*royality_percentage/100;
   //    $(".royality_amount").val('').val(parseFloat(royality_amount))
   //  }
   // }
  var total='0';
  if(booking_amount!='')
  {
    var total=parseFloat(total)+parseFloat(booking_amount)
  }
  if($(".gst_amount").val()!='')
  {
    var total=parseFloat(total)+parseFloat($(".gst_amount").val())
  }
  
  $(".total_booking_amount").val('').val(parseFloat(total))


  $(".balance_amount").val('').val(parseFloat(total))
 $(".advance").val($(".advance_reveived").val())
  var advance=$(".advance").val();
 var first_installment=$(".first_installment").val();
 var seoond_installment=$(".seoond_installment").val();
 var third_installment=$(".third_installment").val();

var installments_amounts=0;
if($(".advance").val()!='')
  {
    var installments_amounts=parseFloat(installments_amounts)+parseFloat($(".advance").val())
  } 
if($(".first_installment").val()!='')
  {
    var installments_amounts=parseFloat(installments_amounts)+parseFloat($(".first_installment").val())
  } 
if($(".seoond_installment").val()!='')
  {
    var installments_amounts=parseFloat(installments_amounts)+parseFloat($(".seoond_installment").val())
  } 

  if($(".third_installment").val()!='')
  {
    var installments_amounts=parseFloat(installments_amounts)+parseFloat($(".third_installment").val())
  }
$(".total_installments_amount").val('').val(parseFloat(installments_amounts))

var received_amount=0;
if($(".advance_reveived").val()!='')
  {
    var received_amount=parseFloat(received_amount)+parseFloat($(".advance_reveived").val())
  } 
if($(".first_installment_reveived").val()!='')
  {
    var received_amount=parseFloat(received_amount)+parseFloat($(".first_installment_reveived").val())
  } 
if($(".second_installment_reveived").val()!='')
  {
    var received_amount=parseFloat(received_amount)+parseFloat($(".second_installment_reveived").val())
  } 

  if($(".third_installment_reveived").val()!='')
  {
    var received_amount=parseFloat(received_amount)+parseFloat($(".third_installment_reveived").val())
  } 

$(".total_received_amount").val('').val(parseFloat(received_amount))

var pending=0;
if($(".balance_amount").val()!='')
  {
    var pending=parseFloat(pending)+parseFloat($(".balance_amount").val())
  } 
 if($(".total_received_amount").val()!='')
  {
    var pending=parseFloat(pending)-parseFloat($(".total_received_amount").val())
  } 
 $(".total_pending_amount").val('').val(parseFloat(pending))

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

//
$('#btn_login_details').click(function(){
  
  var error_brands = '';
  var error_email = '';
  var error_user_id = '';
  var error_name = '';
  var error_user_role = '';
  var error_mobile = '';

  var error_state = '';
  var error_dist = '';
  var error_city = '';
  var error_address = '';
  var error_booking_amount = '';
  var error_advance_date=''
  var error_mode_of_advance=''
  var error_ref_no_advance=''
  var error_first_installment_date = '';
  var error_mode_of_first_installment = '';
  var error_ref_first_installment = '';
  var error_second_installment_date = '';
  var error_mode_of_second_installment = '';
  var error_ref_no_second_installment = '';
  var error_third_installment_date = '';
  var error_mode_of_third_installment = '';
  var error_ref_no_ref_no_third_installment = '';

  var error_advance_reveived_date = '';
  var error_first_installment_reveived_date = '';
  var error_second_installment_reveived_date = '';
  var error_third_installment_reveived_date = '';
         
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
   
   
    if($.trim($('#brands').val()).length == 0)
  {
   error_brands = 'Kindly Select Brands';
   $('#error_brands').text(error_brands);
   $('#brands').addClass('has-error');
  }
  else
  {
   error_brands = '';
   $('#error_brands').text(error_brands);
   $('#brands').removeClass('has-error');
  }

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
   if($.trim($('#booking_amount').val()).length == 0)
  {
   error_booking_amount = 'Kindly Enter Booking Amount';
   $('#error_booking_amount').text(error_booking_amount);
   $('#booking_amount').addClass('has-error');
  }
  else
  {
   error_booking_amount = '';
   $('#error_booking_amount').text(error_booking_amount);
   $('#booking_amount').removeClass('has-error');
  }
  //
 //  if($.trim($('#advance').val()).length != 0 && $.trim($('#advance_date').val()).length == 0)
 // {
 //   error_advance_date = 'Select Date';
 //   $('#error_advance_date').text(error_advance_date);
 //   $('#advance_date').addClass('has-error');
 // }
 // else
 //  {
 //   error_advance_date = '';
 //   $('#error_advance_date').text(error_advance_date);
 //   $('#advance_date').removeClass('has-error');
 //  }

  if($.trim($('#advance_reveived').val()).length != 0 && $.trim($('#advance_reveived_date').val()).length == 0)
 {
   error_advance_reveived_date = 'Select Date';
   $('#error_advance_reveived_date').text(error_advance_reveived_date);
   $('#advance_reveived_date').addClass('has-error');
 }
 else
  {
   error_advance_reveived_date = '';
   $('#error_advance_reveived_date').text(error_advance_reveived_date);
   $('#advance_reveived_date').removeClass('has-error');
  }

  if($.trim($('#advance_reveived').val()).length != 0 && $.trim($('#mode_of_advance').val()).length == 0)
 {
   error_mode_of_advance = 'Enter Mode Of Payment';
   $('#error_mode_of_advance').text(error_mode_of_advance);
   $('#mode_of_advance').addClass('has-error');
 }
 else
  {
   error_mode_of_advance = '';
   $('#error_mode_of_advance').text(error_mode_of_advance);
   $('#mode_of_advance').removeClass('has-error');
  }
  if($.trim($('#advance_reveived').val()).length != 0 && $.trim($('#ref_no_advance').val()).length == 0)
 {
   error_ref_no_advance = 'Enter Ref No';
   $('#error_ref_no_advance').text(error_ref_no_advance);
   $('#ref_no_advance').addClass('has-error');
 }
 else
  {
   error_ref_no_advance = '';
   $('#error_ref_no_advance').text(error_ref_no_advance);
   $('#ref_no_advance').removeClass('has-error');
  }
  //
 if($.trim($('#first_installment').val()).length != 0 && $.trim($('#first_installment_date').val()).length == 0)
 {
   error_first_installment_date = 'Select Date';
   $('#error_first_installment_date').text(error_first_installment_date);
   $('#first_installment_date').addClass('has-error');
 }
 else
  {
   error_first_installment_date = '';
   $('#error_first_installment_date').text(error_first_installment_date);
   $('#first_installment_date').removeClass('has-error');
  }

   if($.trim($('#first_installment_reveived').val()).length != 0 && $.trim($('#first_installment_reveived_date').val()).length == 0)
 {
   error_first_installment_reveived_date = 'Select Date';
   $('#error_first_installment_reveived_date').text(error_first_installment_reveived_date);
   $('#first_installment_reveived_date').addClass('has-error');
 }
 else
  {
   error_first_installment_reveived_date = '';
   $('#error_first_installment_reveived_date').text(error_first_installment_reveived_date);
   $('#first_installment_reveived_date').removeClass('has-error');
  }

  if($.trim($('#first_installment_reveived').val()).length != 0 && $.trim($('#mode_of_first_installment').val()).length == 0)
 {
   error_mode_of_first_installment = 'Enter Mode Of Payment';
   $('#error_mode_of_first_installment').text(error_mode_of_first_installment);
   $('#mode_of_first_installment').addClass('has-error');
 }
 else
  {
   error_mode_of_first_installment = '';
   $('#error_mode_of_first_installment').text(error_mode_of_first_installment);
   $('#mode_of_first_installment').removeClass('has-error');
  }
  if($.trim($('#first_installment_reveived').val()).length != 0 && $.trim($('#ref_first_installment').val()).length == 0)
 {
   error_ref_first_installment = 'Enter Ref No';
   $('#error_ref_first_installment').text(error_ref_first_installment);
   $('#ref_first_installment').addClass('has-error');
 }
 else
  {
   error_ref_first_installment = '';
   $('#error_ref_first_installment').text(error_ref_first_installment);
   $('#ref_first_installment').removeClass('has-error');
  }
  //
  if($.trim($('#seoond_installment').val()).length != 0 && $.trim($('#second_installment_date').val()).length == 0)
 {
   error_second_installment_date = 'Select Date';
   $('#error_second_installment_date').text(error_second_installment_date);
   $('#second_installment_date').addClass('has-error');
 }
 else
  {
   error_second_installment_date = '';
   $('#error_second_installment_date').text(error_second_installment_date);
   $('#second_installment_date').removeClass('has-error');
  }

   if($.trim($('#second_installment_reveived').val()).length != 0 && $.trim($('#second_installment_reveived_date').val()).length == 0)
 {
   error_second_installment_reveived_date = 'Select Date';
   $('#error_second_installment_reveived_date').text(error_second_installment_reveived_date);
   $('#second_installment_reveived_date').addClass('has-error');
 }
 else
  {
   error_second_installment_reveived_date = '';
   $('#error_second_installment_reveived_date').text(error_second_installment_reveived_date);
   $('#second_installment_reveived_date').removeClass('has-error');
  }

  if($.trim($('#second_installment_reveived').val()).length != 0 && $.trim($('#mode_of_second_installment').val()).length == 0)
 {
   error_mode_of_second_installment = 'Enter Mode Of Payment';
   $('#error_mode_of_second_installment').text(error_mode_of_second_installment);
   $('#mode_of_second_installment').addClass('has-error');
 }
 else
  {
   error_mode_of_second_installment = '';
   $('#error_mode_of_second_installment').text(error_mode_of_second_installment);
   $('#mode_of_second_installment').removeClass('has-error');
  }
  if($.trim($('#second_installment_reveived').val()).length != 0 && $.trim($('#ref_no_second_installment').val()).length == 0)
 {
   error_ref_no_second_installment = 'Enter Ref No';
   $('#error_ref_no_second_installment').text(error_ref_no_second_installment);
   $('#ref_no_second_installment').addClass('has-error');
 }
 else
  {
   error_ref_no_second_installment = '';
   $('#error_ref_no_second_installment').text(error_ref_no_second_installment);
   $('#ref_no_second_installment').removeClass('has-error');
  }
  //
   if($.trim($('#third_installment').val()).length != 0 && $.trim($('#third_installment_date').val()).length == 0)
 {
   error_third_installment_date = 'Select Date';
   $('#error_third_installment_date').text(error_third_installment_date);
   $('#third_installment_date').addClass('has-error');
 }
 else
  {
   error_third_installment_date = '';
   $('#error_third_installment_date').text(error_third_installment_date);
   $('#third_installment_date').removeClass('has-error');
  }
  if($.trim($('#third_installment_reveived').val()).length != 0 && $.trim($('#third_installment_reveived_date').val()).length == 0)
 {
   error_third_installment_reveived_date = 'Select Date';
   $('#error_third_installment_reveived_date').text(error_third_installment_reveived_date);
   $('#third_installment_reveived_date').addClass('has-error');
 }
 else
  {
   error_third_installment_reveived_date = '';
   $('#error_third_installment_reveived_date').text(error_third_installment_reveived_date);
   $('#third_installment_reveived_date').removeClass('has-error');
  }

  if($.trim($('#third_installment_reveived').val()).length != 0 && $.trim($('#mode_of_third_installment').val()).length == 0)
 {
   error_mode_of_third_installment = 'Enter Mode Of Payment';
   $('#error_mode_of_third_installment').text(error_mode_of_third_installment);
   $('#mode_of_third_installment').addClass('has-error');
 }
 else
  {
   error_mode_of_third_installment = '';
   $('#error_mode_of_third_installment').text(error_mode_of_third_installment);
   $('#mode_of_third_installment').removeClass('has-error');
  }
  if($.trim($('#third_installment_reveived').val()).length != 0 && $.trim($('#ref_no_third_installment').val()).length == 0)
 {
   error_ref_no_ref_no_third_installment = 'Enter Ref No';
   $('#error_ref_no_ref_no_third_installment').text(error_ref_no_ref_no_third_installment);
   $('#ref_no_third_installment').addClass('has-error');
 }
 else
  {
   error_ref_no_ref_no_third_installment = '';
   $('#error_ref_no_ref_no_third_installment').text(error_ref_no_ref_no_third_installment);
   $('#ref_no_third_installment').removeClass('has-error');
  }
  //error_email
  if(error_user_role != '' || error_user_id != ''  || error_name != '' || error_mobile != '' ||  error_state != '' || error_dist != '' || error_city != '' || error_address != '' || error_brands != '' || error_booking_amount != '' || error_first_installment_date != '' || error_second_installment_date != '' || error_third_installment_date != ''  || error_mode_of_advance != '' || error_ref_no_advance != '' || error_mode_of_first_installment != '' || error_ref_first_installment != '' || error_mode_of_second_installment != '' || error_ref_no_second_installment != '' || error_mode_of_third_installment != '' || error_ref_no_ref_no_third_installment != '' || error_advance_reveived_date != '' || error_first_installment_reveived_date != '' || error_second_installment_reveived_date != '' || error_third_installment_reveived_date != '')
  {
   return false;
  }
  else
  {
    $("#overlay").fadeIn(300);
  var form_data = new FormData($("#registration_form")[0]);
 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/fanchise_register_update',
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
          @if($request_segments=='Edit-Ongoing-Pre-Launch') 
        var url=APP_URL+'/Ongoing-Pre-launch';
        @elseif($request_segments=='Edit-Ongoing-Kyc-Inactive')
        var url=APP_URL+'/Ongoing-KYC-Inactive';
        @else
 var url=APP_URL+'/Active-Newly-Submitted';
        @endif
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