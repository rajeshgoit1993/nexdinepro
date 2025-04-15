@extends("layouts.backend.master")

@section('maincontent')
<style type="text/css">
 
    hr 
    {
      margin-top: .3rem !important;
      margin-bottom: .3rem !important;
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
  <div class="flex-item-left"><h5>New WorkList</h5></div>

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
       <th>Brands</th>
      <th>Contact Details</th>
     
      
      <th>Location</th>
      
   
      <th>Status</th>
 
  
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


  <tr>
<td>{{CustomHelpers::get_brand_name($booking_data->brands)}}</td>
  <td>
    <b>ID:</b> {{$fanchise_detail->email}}
   <hr>
   <b>Name:</b> {{$fanchise_detail->name}}
   <hr>
   <b>Mobile:</b> {{$fanchise_detail->mobile}}
  </td>

  <td>
<b>State:</b> {{$fanchise_detail->state}}
<hr>
<b>City:</b> {{$fanchise_detail->city}}
   </td>                
  <td><span>
  @if($fanchise_detail->status==5)
   KYC Uploaded See and Approved <button class="btn btn-sm btn-primary <!-- view_kyc -->" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}" > <span class="fa fa-eye"></span></button>

 
  @endif
    

  </span>
   @if($fanchise_detail->status==6)    
<b>Pre Launch Date</b>

  <?php
$last_date=$booking_data->fanchise_end_date;
$today=date('Y-m-d');

  ?>
<p style="margin-bottom:0px !important">  {{date("d-m-Y", strtotime($booking_data->fanchise_start_date )) }}</p> to 
<p @if($last_date<$today) style='color:red' @endif> {{ date("d-m-Y", strtotime($booking_data->fanchise_end_date )) }} 
</span>

</p>
<!-- <button class="btn btn-success btn-sm change_date" id="{{CustomHelpers::custom_encrypt($booking_data->id)}}">
Change

</button> -->

 <div class="card-body custom_body" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}">
                <canvas class="pieChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
              </div>


@endif

</td>                          
             
            
                   <td>

      <a href="#" class="view" data-toggle="modal" data-target="#view_modal_{{preg_replace('/[<=>]+/', '',CustomHelpers::custom_encrypt($fanchise_detail->id))}}" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-primary"><span class="fa fa-eye"></span> View</button></a>
        

  <div class="modal fade" id="view_modal_{{preg_replace('/[<=>]+/', '',CustomHelpers::custom_encrypt($fanchise_detail->id))}}">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          @include("admin.fanchises.accordian")
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
 @if($fanchise_detail->status==6)
   <a href="#" class="view_actions" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><button class="btn btn-success" style="display:inline-block;margin-top:5px;width:100%"><span class="fa fa-edit"></span> View/Take Actions</button></a>
 @endif

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
<!---->
  <!-- Button to Open the Modal -->
   <div class="modal fade" id="view_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">View KYC Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        {!! Form::open(["files"=>true,'id'=>"accept_kyc","name"=>"accept_kyc"])!!}
        <div class="modal-body uploads_body">


        </div>
          {!! Form::close() !!} 
        <!-- Modal footer -->
      
        
      </div>
    </div>
  </div>

  <!-- The Modal -->

@endsection
@section('custom_js')
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/accordian.js')}}"></script>
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/timeline.js')}}"></script>
<script>
  $(function () {

$(".custom_body").each(function() {
var id=$(this).attr('id');
var APP_URL=$("#APP_URL").val();
var button=$(this)
     $.ajax({
        url:APP_URL+'/get_chart_data',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {

    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = button.children('.pieChart').get(0).getContext('2d')
    var pieData_architech        = {
      labels: [
         
       
          'Franchise',
          'Interior Work',
          'Social Media',
          'Procurement',
          'Operations',
          'Accounts',
         
          'Local Purchase',
          
      ],
      datasets: [
        {
          data: [1,1,1,1,1,1,1],
          backgroundColor : [data.franchise_color,data.architect_color,data.social_color,data.procurement_color,data.operations_color,data.accounts_color,data.local_purchase_color],
        }
      ]
    };
      var pieOptions     = {
      maintainAspectRatio : false,
      plugins: {
            legend: false // Hide legend
        },
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData_architech,
      options: pieOptions
    })

        },
        error:function(data)
        {

        }
    })

   
});
  

    //
  })

</script>
<script type="text/javascript">
  
$(document).on("click",".view_kyc",function(){
  var id=$(this).attr('id')
   var APP_URL=$("#APP_URL").val();
     var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/get_fanchise_kyc_data',
        data:{id:id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
            console.log(data)
          $(".uploads_body").html('').html(data)
         $('#view_modal').modal('toggle');
        },
        error:function(data)
        {

        }
    })


   
  
})
//
//
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  //
 $(document).on("click",".view_actions",function(){
    var id=$(this).attr('id')
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "get";
   form.action = "view-actions";
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
$(document).on("click","#approve_kyc",function(){ 

  
  var error_launch_start_date = '';
  var error_email = '';
  
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
   
    if($.trim($('#fanchise_start_date').val()).length == 0)
  {
   error_launch_start_date = 'Select Start Date';
   $('#error_launch_start_date').text(error_launch_start_date);
   $('#fanchise_start_date').addClass('has-error');
  }
  else
  {
   error_launch_start_date = '';
   $('#error_launch_start_date').text(error_launch_start_date);
   $('#fanchise_start_date').removeClass('has-error');
  }

  if($.trim($('#fanchise_end_date').val()).length == 0)
  {
   error_fanchise_end_date = 'Select Date';
   $('#error_fanchise_end_date').text(error_fanchise_end_date);
   $('#fanchise_end_date').addClass('has-error');
  }
  else
  {
    error_fanchise_end_date = '';
    $('#error_fanchise_end_date').text(error_fanchise_end_date);
    $('#fanchise_end_date').removeClass('has-error');
  }
  
 
  //
  if(error_launch_start_date != '' || error_fanchise_end_date != '')
  {
   return false;
  }
  else
  {
     // $('#view_modal').modal('hide');
    $("#overlay").fadeIn(300);
  var form_data = new FormData($("#accept_kyc")[0]);
 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/approve_kyc_by_admin',
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
        var url=APP_URL+'/Newly-Submitted';
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