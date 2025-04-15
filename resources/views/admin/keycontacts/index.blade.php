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
  <div class="flex-item-left"><h5>Manage Contacts</h5></div>
  <div class="flex-item-right"><a href="#"><button class="btn btn-success add_contacts"><span class="fa fa-plus"></span> Add Contacts</button></a></div>
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
  <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th width="50px">S.No.</th>
                <th>Contacts Type</th>
                <th>Personal Details</th>
               
                <th>Address</th>
               
                <th>Spouse Details</th>
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
//
<div class="modal fade" id="contact_modal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Manage contacts</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="contact_modal">
         
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

$(document).on("click",".delete",function(){
var id=$(this).attr('id')
if(confirm("Are you sure?"))
    {
  $("#overlay").fadeIn(300);
var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/delete_key_contacts',
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
      $(document).on("submit", "#update_key_contacts", function (event) {

  event.preventDefault();

   $('#contact_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#update_key_contacts")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/update_key_contacts',
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

     //edit

$(document).on("click",".edit",function(){
var id=$(this).attr('id')
var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/edit_key_contacts',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {


       $(".contact_modal").html('').html(data)
       $('#contact_modal').modal('toggle');

        },
        error:function(data)
        {

        }
    })
   
  })
  

     //update_first_stock
    $(document).on("submit", "#store_key_contacts", function (event) {

  event.preventDefault();

   $('#contact_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#store_key_contacts")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/store_key_contacts',
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

//
  $(document).on("click",".add_contacts",function(){

var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/add_key_contacts',
        data:{id:12},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {


       $(".contact_modal").html('').html(data)
       $('#contact_modal').modal('toggle');
        
        },
        error:function(data)
        {

        }
    })
   
  })
  
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
        url: "{{ route('get_key_contacts') }}",
         data: {a:'2'},
    },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'key_contacts_type', name: 'key_contacts_type'},
            {data: 'personal_details', name: 'personal_details'},
            {data: 'address', name: 'address'},
            {data: 'spouse_details', name: 'spouse_details'},
           
       
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