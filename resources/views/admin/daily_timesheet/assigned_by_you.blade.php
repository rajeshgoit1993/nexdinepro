@extends("layouts.backend.master")

@section('maincontent')
<style type="text/css">
  .select2-container
  {
    display: block !important;
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
  <div class="flex-item-left"><h5>Daily Timesheet</h5></div>
  <div class="flex-item-right">
    <a href="#"><button class="btn btn-success add_meeting"><span class="fa fa-plus"></span> Add Meeting</button></a>
 <a href="#"><button class="btn btn-success assign_task"><span class="fa fa-plus"></span> Assign Task</button></a>

  </div>
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

  <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th width="50px">S.No.</th>
                <th>Task Type</th>
                <th>Desc of task</th>
                <th>Date Time</th>
                <th>Assign To</th>
                <th>Assign By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

 








<!-- /.content -->

</div>
</section>

</div>

</div>
</section>

</div>


<div class="modal fade" id="session_modal_daily_work_view">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">View</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="session_modal_daily_work_view">
         
        </div>
        
        <!-- Modal footer -->
       
        
      </div>
    </div>
  </div>
<!---->
<div class="modal fade" id="session_modal_daily_work">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Meeting</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="session_modal_daily_work">
         
        </div>
        
        <!-- Modal footer -->
       
        
      </div>
    </div>
  </div>
<!---->
<div class="modal fade" id="session_modal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Meeting</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="session_modal">
         
        </div>
        
        <!-- Modal footer -->
       
        
      </div>
    </div>
  </div>
<!---->
  <!-- Button to Open the Modal -->
   <div class="modal fade" id="add_meet">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Meeting</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        {!! Form::open(["files"=>true,'id'=>"store_meeting","name"=>"store_meeting"])!!}
        <div class="modal-body uploads_body">
  <div class="row">
  <!--     <div class="col-md-12">
         <div class="form-group">
  <label for="" class="required">Department</label>
      <select class="form-control" name="dept">
<option value="All">--All--</option>
@foreach($department as $d)
 <option value="{{$d->id}}">{{$d->department}}</option>
@endforeach

</select> 
   </div> 
             
          
      </div> -->

       <div class="col-md-12">
         <div class="form-group">
  <label for="" class="required">Description of Meeting</label>
      <textarea class="form-control" name="desc_of_task" required></textarea>
   </div> 
                    
      </div>


 <div class="col-md-12">
         <div class="form-group">
  <label for="" class="required">Select User</label>
      <select class="form-control select2" name="assign_user[]" multiple required>
<option value="">--Select User--</option>
@foreach($users as $user)
  <?php
    $sevtinel_activated=Sentinel::findById($user->id);
      ?>
    @if($activation = Activation::completed($sevtinel_activated))

    <option value="{{$user->id}}">{{$user->name}}</option>

     @endif



@endforeach

</select> 
   </div> 
             
          
      </div>

<div class="col-md-6">
         <div class="form-group">
  <label for="" class="required">Meeting Start Time</label>
    <input type="datetime-local" name="meeting_start" class="form-control" min="{{date('Y-m-d H:i')}}" value="{{date('Y-m-d H:i')}}">
   </div> 
                    
      </div>


<div class="col-md-6">
         <div class="form-group">
  <label for="" class="required">Meeting End Time</label>
    <input type="datetime-local" name="meeting_end" class="form-control" min="{{date('Y-m-d H:i')}}" value="{{date('Y-m-d H:i')}}">
   </div> 
                    
      </div>


    </div>


{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}
        </div>
          {!! Form::close() !!} 
        <!-- Modal footer -->
      
        
      </div>
    </div>
  </div>

  <!-- The Modal -->


 <div class="modal fade" id="assign_t">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Task</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        {!! Form::open(["files"=>true,'id'=>"store_task","name"=>"store_task"])!!}
        <div class="modal-body uploads_body">
  <div class="row">
  <!--     <div class="col-md-12">
         <div class="form-group">
  <label for="" class="required">Department</label>
      <select class="form-control" name="dept">
<option value="All">--All--</option>
@foreach($department as $d)
 <option value="{{$d->id}}">{{$d->department}}</option>
@endforeach

</select> 
   </div> 
             
          
      </div> -->

       <div class="col-md-12">
         <div class="form-group">
  <label for="" class="required">Description of Task</label>
      <textarea class="form-control" name="desc_of_task" required></textarea>
   </div> 
                    
      </div>


 <div class="col-md-6">
         <div class="form-group">
  <label for="" class="required">Assign Employee</label>
      <select class="form-control" name="assign_user"  required>
<option value="{{Sentinel::getUser()->id}}">Self Assign</option>
@foreach($users as $user)
  <?php
    $sevtinel_activated=Sentinel::findById($user->id);
      ?>
    @if($activation = Activation::completed($sevtinel_activated))

    <option value="{{$user->id}}">{{$user->name}}</option>

     @endif



@endforeach

</select> 
   </div> 
             
          
      </div>

<div class="col-md-6">
         <div class="form-group">
  <label for="" class="required">Priority</label>
     <select class="form-control" name="priority"  required>
      <option value="High">High</option>
      <option value="Medium">Medium</option>
      <option value="Low">Low</option>
     </select>
   </div> 
                    
      </div>
<div class="col-md-6">
         <div class="form-group">
  <label for="" >Any Attachments</label>
    <input type="file" name="doc" class="form-control">
   </div> 
                    
      </div>

<div class="col-md-6">
         <div class="form-group">
  <label for="" class="required">Completed By</label>
    <input type="date" name="completed_by" class="form-control" required>
   </div> 
                    
      </div>


    </div>


{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}
        </div>
          {!! Form::close() !!} 
        <!-- Modal footer -->
      
        
      </div>
    </div>
  </div>
@endsection

@section('custom_js')


<script>
    //
     //
   $(document).on("click",".colplete_daily_work",function(){
var id=$(this).attr('id')
if(confirm("Are you sure?"))
    {
  $("#overlay").fadeIn(300);
var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/colplete_daily_work',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {

         $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Updated', "success");
        get_data('nochange')
        
      
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
  $(document).on("click",".delete",function(){
var id=$(this).attr('id')
if(confirm("Are you sure?"))
    {
  $("#overlay").fadeIn(300);
var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/delete_daily_meeting',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {

         $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Deleted', "success");
        get_data('nochange')
        
      
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
 $(document).on("submit", "#update_meeting", function (event) {

  event.preventDefault();

   $('#session_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#update_meeting")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/update_meeting',
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
        get_data('nochange')
        
      
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

$(document).on("click",".edit",function(){
var id=$(this).attr('id')

var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/edit_daily_meeting',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {


       $(".session_modal").html('').html(data)
       $('#session_modal').modal('toggle');
$('.select2').select2();
        },
        error:function(data)
        {

        }
    })
   
  })
  
     //update_first_stock
    $(document).on("submit", "#store_meeting", function (event) {

  event.preventDefault();

   $('#session_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#store_meeting")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/store_meeting',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
        swal("Done !", 'Successfully Added', "success");
     
        get_data('nochange')
        // var url=APP_URL+'/Utensil-List';
        // window.location.href = url;
     get_data('nochange')  
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
  //view_daily_work

    $(document).on("click",".view_daily_work",function(){
var id=$(this).attr('id')

var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/view_daily_work',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {


       $(".session_modal_daily_work_view").html('').html(data)
       $('#session_modal_daily_work_view').modal('toggle');

        },
        error:function(data)
        {

        }
    })
   
  })
    //update_daily_task

     $(document).on("submit", "#update_daily_task", function (event) {

  event.preventDefault();

   $('#session_modal_daily_work').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#update_daily_task")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/update_daily_task',
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
        get_data('nochange')
        
      
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

    //edit_daily_work
    $(document).on("click",".edit_daily_work",function(){
var id=$(this).attr('id')

var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/edit_daily_work',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {


       $(".session_modal_daily_work").html('').html(data)
       $('#session_modal_daily_work').modal('toggle');
$('.select2').select2();
        },
        error:function(data)
        {

        }
    })
   
  })
//store_task
 $(document).on("submit", "#store_task", function (event) {

  event.preventDefault();

   $('#session_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#store_task")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/store_task',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
        swal("Done !", 'Successfully Added', "success");
     
        get_data('nochange')
        // var url=APP_URL+'/Utensil-List';
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
});
  //assign_task
  $(document).on("click",".assign_task",function(){
$('#assign_t').modal('toggle');
$('.select2').select2();
})
  //
$(document).on("click",".add_meeting",function(){
$('#add_meet').modal('toggle');
$('.select2').select2();
})
//

$(document).ready(function(){
get_data('change')
})

  //
  function get_data($statesave)
{



if ($.fn.DataTable.isDataTable('.yajra-datatable')) {
   $('.yajra-datatable').DataTable().destroy()
}

     var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: $statesave,
        ajax: {
        url: "{{ route('get_assigned_task') }}",
         data: {a:'2'},
    },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'task_type', name: 'task_type'},
           {data: 'task_desc', name: 'task_desc'},
           {data: 'time', name: 'time'},
           {data: 'assign_person', name: 'assign_person'},
           {data: 'assign_by', name: 'assign_by'},
          
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });   
}  

</script>

@endsection