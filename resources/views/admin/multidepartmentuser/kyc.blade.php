@extends("layouts.backend.master")

@section('maincontent')
<style type="text/css">
  .partener_part
  {
    display: none;
  }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
  <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    <div class="flex-container">
  <div class="flex-item-left"><h5>Newly-Submitted</h5></div>

</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
</div>
</section>
<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>

<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">

<!-- /.content -->
          @include("admin.multidepartmentuser.store_details")
<!---->
  <div style="padding: 0px 10px;">
<h5>KYC</h5>
 {!! Form::open(["files"=>true,'id'=>"registration_form","name"=>"registration_form"])!!}


<div class="row">
    <div class="col-md-3">
     <div class="form-group">
          <label for="">Aadhar Card</label>
           
         <input type="file" name="aadhar_card" id="aadhar_card" class="form-control">   
          <span id="error_aadhar_card" class="text-danger"></span>
        </div>
 </div>
 <div class="col-md-3">
     <div class="form-group">
          <label for="" class="required">Pan Card</label>
            <input type="file" name="pan_card" id="pan_card" class="form-control">   
         
             <span id="error_pan_card" class="text-danger"></span>
        </div>
 </div>
   <div class="col-lg-3">
          <div class="form-group">
     <label>DOB</label>
     <input type="date" name="birthday" id="birthday" class="form-control" placeholder="Enter DOB" />
     <span id="error_birthday" class="text-danger"></span>
        </div> 
     </div>
 <div class="col-md-3">
     <div class="form-group">
          <label for="" >Anniversary Date</label>
           
           {!! Form::date("anniversary",null,["class"=>"form-control","placeholder"=>"Anniversary Date"]) !!}
            <span class="text-danger">{{ $errors->first('demanddate') }}</span>   
        </div>
 </div>



 
 
  </div>
<br>

 <button type="button" name="btn_login_details" id="btn_login_details" class="btn btn-info btn-lg">Save</button>
  {!! Form::close() !!}    
  </div>
<!---->
</div>
</section>

</div>

</div>
</section>

</div>

<div class="form">

</div>
<!---->
  <!-- Button to Open the Modal -->
  

  <!-- The Modal -->

@endsection
@section('custom_js')
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/accordian.js')}}"></script>
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/timeline.js')}}"></script>

<script type="text/javascript">

    


     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  //

$('#btn_login_details').click(function(){
 var error_aadhar_card = '';
  var error_pan_card = '';
   var error_birthday = '';

  if($.trim($('#aadhar_card').val()).length == 0)
  {
   error_aadhar_card = 'Kindly Choose Aadhar Card';
   $('#error_aadhar_card').text(error_aadhar_card);
   $('#aadhar_card').addClass('has-error');
  }
  else
  {
   error_aadhar_card = '';
   $('#error_aadhar_card').text(error_aadhar_card);
   $('#aadhar_card').removeClass('has-error');
  }
   if($.trim($('#pan_card').val()).length == 0)
  {
   error_pan_card = 'Kindly Choose PAN Card';
   $('#error_pan_card').text(error_pan_card);
   $('#pan_card').addClass('has-error');
  }
  else
  {
   error_pan_card = '';
   $('#error_pan_card').text(error_pan_card);
   $('#pan_card').removeClass('has-error');
  }
 if($.trim($('#birthday').val()).length == 0)
  {
   error_birthday = 'DOB is required';
   $('#error_birthday').text(error_birthday);
   $('#birthday').addClass('has-error');
  }
  else
  {
   error_birthday = '';
   $('#error_birthday').text(error_birthday);
   $('#birthday').removeClass('has-error');
  }

if(error_aadhar_card != '' || error_pan_card != '' || error_birthday != '')
  {
   return false;
  }
  else
  {
       $("#overlay").fadeIn(300);
  var form_data = new FormData($("#registration_form")[0]);
 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/store_kyc_update',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Uploaded KYC', "success");
        var url=APP_URL+'/My-Account';
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
})

  //

  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
       
       
       
    });
    
  });
</script>

@endsection