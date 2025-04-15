@extends("layouts.backend.master")

@section('maincontent')
<style type="text/css">
 
    hr 
    {
      margin-top: .3rem !important;
      margin-bottom: .3rem !important;
    }
    </style>
    <style type="text/css">

.custom_chart span:after {
  display: inline-block;
  content: "";
  width: 0.8em;
  height: 0.8em;
  margin-left: 0.4em;
  height: 0.8em;
  border-radius: 0.2em;
  background: currentColor;
}
  </style>
     <style type="text/css">
  .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">

<div class="container-fluid">
<div class="row">
  <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
        <div class="flex-container" style="padding:0px">
  <div class="flex-item-left" style="padding:0px"><h5>Ongoing Franchise</h5></div>

</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
         <div class="row">

     <div class="col-md-10">
  
 <select name="brand" id="brand" class="form-control valid" required>
   
     <?php  
$brands=DB::table('brands')->get();

     ?>
     @if(Session::has('current_brand'))
    <?php
$current_brand=Session('current_brand');

?>
     <option value="0"  @if($current_brand==0) selected='' @endif>All</option>
     @foreach($brands as $brand)
     <option value="{{ $brand->id }}" @if($current_brand==$brand->id) selected='' @endif>{{ $brand->brand }}</option>
     @endforeach

     @else
     <option value="0" selected>All</option>
     @foreach($brands as $brand)
     <option value="{{ $brand->id }}">{{ $brand->brand }}</option>
     @endforeach
     @endif

     </select >

      </div>
    

      <div class="col-md-2">
<button class="btn btn-success btn-block find">Find Outlet</button>

        </div>


</div>


</div>
</section>

  
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<!-- /.content -->
<div class="table-responsive">
  <table class="table table-bordered yajra-datatable">
        <thead>
    <tr>
      <th>S.No.</th>
       <th>Brands</th>
      <th>Contact Details</th>
     
      
      <th>Location</th>
      
   
      <th>Status</th>
 
  
      <th>Actions</th>
    </tr>
  
  </thead>
   <tbody>
   
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
<div class="modal fade" id="survey_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Survey Form</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        {!! Form::open(["files"=>true,'id'=>"survey_form","name"=>"survey_form"])!!}


        <div class="modal-body survey_data">
        

        </div>
          {!! Form::close() !!} 
        <!-- Modal footer -->
      
        
      </div>
    </div>
  </div>

<!---->
<div class="modal fade" id="date_change">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Change Pre Launch Date</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        {!! Form::open(["files"=>true,'id'=>"date_changes","name"=>"date_changes"])!!}


        <div class="modal-body data_change_form_data">
        

        </div>
          {!! Form::close() !!} 
        <!-- Modal footer -->
      
        
      </div>
    </div>
  </div>

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
<!---->
 <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Outlet Setting</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
     {!! Form::open(["files"=>true,'id'=>"outlet_setting_form","name"=>"outlet_setting_form"])!!}
  <input type="hidden" name="id" id="outlet_setting_data" value="">   
        <!-- Modal body -->
        <div class="modal-body page_access_data">
         
        </div>
       <div style="text-align:center;">
<button type="button" name="submit" id="submit_outlet_setting_form" class="btn btn-info mb-2">Save</button>
       </div>

      {!! Form::close() !!}
  
        <!-- Modal footer -->
        <div class="modal-footer">
       
        </div>
        
      </div>
    </div>
  </div>

  <input type="hidden" id="type" name="" value="{{$type}}">

@endsection
@section('custom_js')
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/accordian.js')}}"></script>
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/timeline.js')}}"></script>
<script>
  $(function () {

  

    //
  })

</script>
<script type="text/javascript">
  //
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     //
      $(document).on('change','.active_status',function(){

    var status_value=$(this).val()
    var id =$(this).siblings('.fanchise_id').val()
    var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/active_status',
        type:'POST',
        data:{id:id,status_value:status_value},
        success:function(data)
        {
         alert("Status Successfully Changed")
         get_data('change')
        },
        error:function(data)
        {

        }
    })

     
})
       //

$(document).on("click",".open_page",function(e){
  e.preventDefault()
var id=$(this).attr('id')
$("#outlet_setting_data").val('').val(id)

var APP_URL=$("#APP_URL").val();
 $.ajax({
        url:APP_URL+'/get_outlet_setting_data',
        data:{id:id},
        type:'get',
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
//outlet_menu
$(document).on("change",".outlet_menu",function(){
  var menu_id=$(this).val()
if(this.checked) {

       var APP_URL=$("#APP_URL").val();
 $.ajax({
        url:APP_URL+'/outlet_menu_enable',
        data:{menu_id:menu_id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
         
         $(".total_menues").html('').html(data)
        },
        error:function(data)
        {

        }
    })
    }
  else
    {
       var APP_URL=$("#APP_URL").val();
 $.ajax({
        url:APP_URL+'/outlet_menu_disable',
        data:{menu_id:menu_id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
         
         $(".total_menues").html('').html(data)
        },
        error:function(data)
        {

        }
    })   
      
    }
})

//outlet_setting_form
$(document).on("click","#submit_outlet_setting_form",function(){
  var form_data = new FormData($("#outlet_setting_form")[0]);
 var APP_URL=$("#APP_URL").val();
 $('#myModal').modal('hide');
  $.ajax({
        url:APP_URL+'/save_outlet_setting_form',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
         
        if(data=='success')
        {
       swal("Done !", 'Successfully Updated', "success");
        // var url=APP_URL+'/Launch-Franchise';
        // window.location.href = url;
     
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


})
       //
  $(document).on("click",".edit",function(){
    var id=$(this).attr('id')
    var type=$("#type").val()
    if(type=='ongoing_kyc_inactive')
    {
      var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Edit-Ongoing-Kyc-Inactive";
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
    else
    {
    var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Edit-Ongoing-Pre-Launch";
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
  //survey
$(document).on("click",".survey",function(e){
  e.preventDefault()
var id=$(this).attr('id')

var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/check_survey_condation',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {


       $(".survey_data").html('').html(data)
         $('#survey_modal').modal('toggle');

        },
        error:function(data)
        {

        }
    })

})
//
$(document).on("click","#update_survey",function(){ 

  
  var error_survey_date = '';
  var error_survey_remarks = '';
 if($.trim($('#survey_date').val()).length == 0)
  {
   error_survey_date = 'Kindly Enter Date';
   $('#error_survey_date').text(error_survey_date);
   $('#survey_date').addClass('has-error');
  }
  else
  {
   error_survey_date = '';
   $('#error_survey_date').text(error_survey_date);
   $('#survey_date').removeClass('has-error');
  }
 
 if($.trim($('#survey_remarks').val()).length == 0)
  {
   error_survey_remarks = 'Kindly Remarks';
   $('#error_survey_remarks').text(error_survey_remarks);
   $('#survey_remarks').addClass('has-error');
  }
  else
  {
   error_survey_remarks = '';
   $('#error_survey_remarks').text(error_survey_remarks);
   $('#survey_remarks').removeClass('has-error');
  }
  if( error_survey_date != '' || error_survey_remarks != '')
  {
   return false;
  }
  else
  { 

      $("#overlay").fadeIn(300);
  var form_data = new FormData($("#survey_form")[0]);
 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/survey_update',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Changed', "success");
        // var url=APP_URL+'/Launch-Franchise';
        // window.location.href = url;
      get_data('change')
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
  
     // $('#view_modal').modal('hide');
  



 });

  //change_date
$(document).on("click",".change_date",function(){
var id=$(this).attr('id')

var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/get_fanchise_launch_data',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {

          
          $(".data_change_form_data").html('').html(data)
      

         $('#date_change').modal('toggle');

        },
        error:function(data)
        {

        }
    })

})
//
$(document).on("click","#update_date",function(){ 

  
  var error_launch_start_date = '';
  var error_email = '';
 
     // $('#view_modal').modal('hide');
    $("#overlay").fadeIn(300);
  var form_data = new FormData($("#date_changes")[0]);
 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/date_changes',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Changed', "success");
        // var url=APP_URL+'/Ongoing-Request';
        // window.location.href = url;
     get_data('change')
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



 });
//

//
$(document).on("click",".view",function(){
var id=$(this).attr('id')
 
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


//
  
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
        // var url=APP_URL+'/Ongoing-Request';
        // window.location.href = url;
       get_data('change')
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

  // $(function () {
    
  //   var table = $('.yajra-datatable').DataTable({
       
       
       
  //   });
    
  // });
</script>
<script>

$(document).ready(function(){

get_data('change')

})

$(document).on("click",".find",function()
{
get_data('change')
})
function get_data($statesave)
{
var brand=$("#brand").val();
// var APP_URL=$("#APP_URL").val();
var type=$("#type").val();

if ($.fn.DataTable.isDataTable('.yajra-datatable')) {
   $('.yajra-datatable').DataTable().destroy()
}

     var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: $statesave,
        ajax: {
        url: "{{ route('get_ongoing_franchise') }}",
        data: {brand:brand,type:type},
    },
      
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'brand', name: 'brand'},
            {data: 'basic_details', name: 'basic_details'},
            {data: 'location', name: 'location'},
            {data: 'status', name: 'status'},
           
       
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ],
        initComplete: function(settings, json) {

      $(".custom_body").each(function() {
        var id=$(this).attr('id');
      
        
       //
          });
      },  

    });
    //

   
}





</script>
@endsection