@extends("layouts.backend.master")

@section('maincontent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">

       <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    
         <div class="row">

  
       <div class="col-md-5">

 <select name="year" id="year" class="form-control valid" required>
     
     @foreach($years as $row=>$col)
<option value="{{$row}}" @if($row==$full_year) selected @endif>{{$row}}</option>
     @endforeach
     
    
</select>  
 

      </div>
<div class="col-md-5">

 <select name="month" id="month" class="form-control valid" required>
     
     @foreach($months as $row=>$col)
<option value="{{$row}}" @if($row==$month) selected @endif>{{CustomHelpers::get_month($row)}}</option>
     @endforeach
     
    
</select>  
 

      </div>
      <div class="col-md-2">
<button class="btn btn-success btn-block find">Find </button>

        </div>


</div>


</div>
</section>


  <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    <div class="flex-container">
  <div class="flex-item-left"><h5>Emp Attendence</h5></div>
  <!-- <div class="flex-item-right"><a href="#"><button class="btn btn-success add_holiday"><span class="fa fa-plus"></span> Add Holiday</button></a></div> -->
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
<div class="table-responsive">


                        <table class="table table-hover table-bordered" id="attendence_data">
                           
                        </table>
                    </div>










<!-- /.content -->
</div>
</section>

</div>

</div>
</section>

</div>
//
<div class="modal fade" id="session_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Attendence Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="session_modal">
         
        </div>
        
        <!-- Modal footer -->
       
        
      </div>
    </div>
  </div>
  
@endsection
@section('custom_js')
<script type="text/javascript">
    //
// $(document).on("click",".remove",function(){
//    var r = confirm("Are you sure ?");

     
//        if (r === false) {
//            return false;
//         }
// })
  //
   //
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     //
     //
      $(document).on("submit", "#store_admin_attendence", function (event) {

  event.preventDefault();

   $('#session_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#store_admin_attendence")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/store_admin_attendence',
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
        get_data();
      
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
$(document).on("click",".date_info",function(){
    var APP_URL=$("#APP_URL").val();
    var user_id=$(this).attr("user_id")
    var date=$(this).attr("date") 
    $.ajax({
        url:APP_URL+'/get_attendence_details',
        data:{user_id:user_id,date:date},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {


       $(".session_modal").html('').html(data)
       $('#session_modal').modal('toggle');
        
        },
        error:function(data)
        {

        }
    })
})

$(document).on("click",".find",function(){
 get_data();   
})
    
$(document).ready(function(){
get_data();
})

  //
  function get_data()
{

 var APP_URL=$("#APP_URL").val();
    var year=$("#year").val()
    var month=$("#month").val()
    $.ajax({
        url:APP_URL+'/get_filter_attendence',
        data:{year:year,month:month},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {

$("#attendence_data").html('').html(data)
        
        },
        error:function(data)
        {

        }
    })

}
 
</script>

@endsection