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
  <div class="flex-item-left"><h5>Wastage List</h5></div>
  <div class="flex-item-right">
    <a href="{{URL::route('add_ingredients_waste')}}"><button class="btn btn-info"><span class="fa fa-plus"></span> Add Ingredients Waste</button></a>
   
   <a href="{{URL::route('add_food_menu_waste')}}"><button class="btn btn-success"><span class="fa fa-plus"></span> Add Food Menu Waste</button></a>

</div>
</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
@if(Session::get('error'))
<div class="alert alert-danger" role="alert">
  {{ Session::get('error') }}
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
                <th >S.No.</th>
                <th>Date</th>
                <th>Total Loss</th> 
                <th>Loss Type</th> 
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>


 




  <!-- Edit Modal -->
  <div class="modal fade" id="edit_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">View</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
       <div class="add_body"></div>
        <!-- Modal footer -->
       
        
      </div>
    </div>
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
<script type="text/javascript">
$(document).on("keyup change",".number_test",function(){
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');

})
//
</script>
<script type="text/javascript">
    //
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     //
  
     //
$(document).on("click",".delete",function(){
var id=$(this).attr('id')
if(confirm("Are you sure?"))
    {
  $("#overlay").fadeIn(300);
var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/delete_waste_purchase',
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
    $(document).on("click",".view",function(){
    var id=$(this).attr('id');
    var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/view_waste_purchase',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
           
          $(".add_body").html('').html(data)
         
        },
        error:function(data)
        {

        }
    })

     $('#edit_modal').modal('toggle');

    })

       //


  //
$(document).ready(function(){
get_data('change')
})
$(document).on("click",".find",function(){
  get_data('change')  
})
function get_data($statesave)
{
// var brand=$("#brand").val()
// if(brand=='')
// {
//     var brand='NA';
// }
var item_type=$("#item_type").val()
var val=0
if(item_type=='')
{
    var item_type='NA';
}
var brand='NA';


if ($.fn.DataTable.isDataTable('.yajra-datatable')) {
   $('.yajra-datatable').DataTable().destroy()
}

     var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: $statesave,
        ajax: {
        url: "{{ route('get_waste_list') }}",
        data: {brand:brand,item_type:item_type},
    },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
           
          
            
            {data: 'date', name: 'date'},
            {data: 'total_loss', name: 'total_loss'},
            {data: 'loss_type', name: 'loss_type'},
           
        
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