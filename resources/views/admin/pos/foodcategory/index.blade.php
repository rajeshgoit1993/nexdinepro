@extends("layouts.backend.master")

@section('maincontent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
     @if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1) 

    <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
   

 <div class="row">
   <div class="col-lg-3">
      <label>Select Region</label>
      <select name="region" id="region" class="form-control">
        <option value="0">All</option>
        @foreach($regions as $region)
    <option value="{{$region->id}}">{{$region->region_name}}</option>
        @endforeach
 
     </select>
      </div>
   <div class="col-lg-3">
      <label>Select City</label>
      <select name="city" id="city" class="form-control">
        <option value="0">All</option>
        @foreach($cities as $city)
    <option value="{{$city}}">{{$city}}</option>
        @endforeach
 
     </select>
      </div>
     <div class="col-lg-4">
      <label>Select Outlet</label>
      <select name="outlet" id="outlet" class="form-control">
    <option value="">--Select Outlet--</option>
   @include('report.pos.outlets')
     </select>
      </div>
        
      <div class="col-lg-2">
   <label style="visibility: hidden;">NA</label>
 <button class="btn btn-success btn-block find">Find </button>
      </div>
     

   

</div>


        


</div>
</section>

@elseif(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise')) 
 
        
<input type="hidden" id="outlet" name="" value="{{Sentinel::getUser()->parent_id}}">
<input type="hidden" id="city" name="" value="NA">
<input type="hidden" id="region" name="" value="NA">
  
  



@endif

  <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    <div class="flex-container">
  <div class="flex-item-left"><h5>Food Menu Categories</h5></div>
  <div class="flex-item-right"><a href="#"><button class="btn btn-success add_food_menu"><span class="fa fa-plus"></span> Add Food Menu Category</button></a></div>
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
                <th>Category Name</th>
              
                <th>Description</th>
              
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
<div class="modal fade" id="session_modal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Food Manu Category</h4>
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
<script src="{{url('resources/assets/admin-lte/js/outlet_by_change.js')}}" type="text/javascript"></script>
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
        url:APP_URL+'/delete_food_menu',
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
      $(document).on("submit", "#update_store_food_menu", function (event) {

  event.preventDefault();

   $('#session_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#update_store_food_menu")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/update_store_food_menu',
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
        url:APP_URL+'/edit_food_menu',
        data:{id:id},
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
  

     //update_first_stock
    $(document).on("submit", "#store_food_menu", function (event) {

  event.preventDefault();

   $('#session_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#store_food_menu")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/store_food_menu',
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
  $(document).on("click",".add_food_menu",function(){
 var outlet_id=$("#outlet").val()
if(outlet_id=='')
{
    alert('Select Any Outlet')
}
else
{
 var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/add_food_menu',
        data:{outlet_id:outlet_id},
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
}

   
  })
  $(document).on("click",".find",function(){
  var outlet_id=$("#outlet").val()
if(outlet_id=='')
{
    alert('Select Any Outlet')
}
else
{
  get_data('change')  
}
})
$(document).ready(function(){
get_data('change')
})

  //
  function get_data($statesave)
{

var outlet_id=$("#outlet").val()
if(outlet_id!='')
{
 if ($.fn.DataTable.isDataTable('.yajra-datatable')) {
   $('.yajra-datatable').DataTable().destroy()
}

     var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: $statesave,
        ajax: {
        url: "{{ route('get_food_category') }}",
         data: {outlet_id:outlet_id},
    },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'category_name', name: 'category_name'},
           
            {data: 'description', name: 'description'},
          
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });    
}

  
}
 
</script>

@endsection