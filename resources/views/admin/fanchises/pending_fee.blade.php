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
  <div class="flex-item-left"><h5>Pending Fee List</h5></div>

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
      <th>Mobile No</th>
      <th>State</th>
      <th>District </th>
      <th>City</th>
      <th>Received</th>
      <th>Pending</th>
      <th>Actions</th>
    </tr>
  
  </thead>
   <tbody>
    <?php
$sn=1;
    ?>
    @foreach($data as $fanchise_detail)  
   <?php 

$booking_data=DB::table('fanchise_registrations')->where('fanchise_id','=',$fanchise_detail->id)->first();
   ?>
@if(CustomHelpers::get_amount($booking_data->id,'balance')>0)

  <tr>
  <td>{{$fanchise_detail->email}}</td>
  <td><span>{{$fanchise_detail->name}}</span></td>
  <td><span>{{$fanchise_detail->mobile}}</span></td>
  <td><span>{{$fanchise_detail->state}}</span></td>
  <td><span>{{$fanchise_detail->dist}}</span></td>
  <td><span>{{$fanchise_detail->city}}</span></td>                    
   <td><span>

<p style="color:green">Rs.   {{ CustomHelpers::get_amount($booking_data->id,'received') }}</p>


  </span></td>                  
  <td><span>

  <p style="color:red">Rs. {{ CustomHelpers::get_amount($booking_data->id,'balance') }}</p>


  </span></td>             
            
                   <td>

      <a href="#" class="view" data-toggle="modal" data-target="#view_modal_{{preg_replace('/[<=>]+/', '',CustomHelpers::custom_encrypt($fanchise_detail->id))}}" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><button class="btn btn-primary"><span class="fa fa-eye"></span> View</button></a>

          <a href="#" class="edit" id="{{CustomHelpers::custom_encrypt($booking_data->id)}}"><button class="btn btn-success"><span class="fa fa-edit"></span> Edit</button></a>

           



                    </td>

                  </tr>
@endif
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
<!---->
  <!-- Button to Open the Modal -->
    <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Booking Amount</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
     {!! Form::open(["files"=>true,'id'=>"page_access_form","name"=>"page_access_form"])!!}
   
        <!-- Modal body -->
        <div class="modal-body page_access_data">
         <!---->

<!---->
   
         <!---->
        </div>
       <div style="text-align:center;">
<button type="button" name="submit" id="submit" class="btn btn-info mb-2">Save</button>
       </div>

      {!! Form::close() !!}
  
        <!-- Modal footer -->
        <div class="modal-footer">
       
        </div>
        
      </div>
    </div>
  </div>


  <!-- The Modal -->
<!-- The Modal -->
    <div class="modal fade" id="ongoing_data">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body ongoing_data">
       
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
@endsection
@section('custom_js')
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/accordian.js')}}"></script>
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/timeline.js')}}"></script>

<script type="text/javascript">
  //
// $(document).on("click",".view",function(){
//   var id=$(this).attr('id')
//    var APP_URL=$("#APP_URL").val();
//    var url= 'aaa';
//      window.open(url,"_blank", "toolbar=no,scrollbars=yes,resizable=yes,width=1200,height=400");
//   $('#view_modal').modal('toggle');
// })
  //
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     //
     //
$(document).on("click",".view",function(){
var id=$(this).attr('id')
   var APP_URL=$("#APP_URL").val();
     var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/get_fanchise_basic_data',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
          
          $(".ongoing_data").html('').html(data)
         $('#ongoing_data').modal('toggle');

        },
        error:function(data)
        {

        }
    })


})

  //submit
  $('#submit').click(function(e){
e.preventDefault()
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
  if($.trim($('#advance').val()).length != 0 && $.trim($('#advance_date').val()).length == 0)
 {
   error_advance_date = 'Select Date';
   $('#error_advance_date').text(error_advance_date);
   $('#advance_date').addClass('has-error');
 }
 else
  {
   error_advance_date = '';
   $('#error_advance_date').text(error_advance_date);
   $('#advance_date').removeClass('has-error');
  }

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
  //
  if( error_booking_amount != '' || error_first_installment_date != '' || error_second_installment_date != '' || error_third_installment_date != '' || error_advance_date != '' || error_mode_of_advance != '' || error_ref_no_advance != '' || error_mode_of_first_installment != '' || error_ref_first_installment != '' || error_mode_of_second_installment != '' || error_ref_no_second_installment != '' || error_mode_of_third_installment != '' || error_ref_no_ref_no_third_installment != '' || error_advance_reveived_date != '' || error_first_installment_reveived_date != '' || error_second_installment_reveived_date != '' || error_third_installment_reveived_date != '')
  {
   return false;
  }
  else
  {
    $("#overlay").fadeIn(300);
  var form_data = new FormData($("#page_access_form")[0]);
 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/update_amount',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Updated', "success");
        var url=APP_URL+'/Pending-Fee';
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
  $(document).on("click",".edit",function(){
    var id=$(this).attr('id')

    var APP_URL=$("#APP_URL").val();
 $.ajax({
        url:APP_URL+'/get_booking_amount_data',
        data:{id:id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
         $(".page_access_data").html('').html(data)
        
        $('#myModal').modal('toggle');
                                
         //
        
         
        },
        error:function(data)
        {

        }
    })


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
  //
    $(document).on("keyup change",".number_test",function(){
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');

})

  $(document).ready(function(){

  
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
</script>

@endsection