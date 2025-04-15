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

  
       <div class="col-md-10">

 <select name="item_type" id="item_type" class="form-control valid" required>
     <option value="">--Select Food Category--</option>
     
     @foreach($data as $row=>$col)
<option value="{{$row}}">{{POS_SettingHelpers::get_food_category_name($row)}}</option>
     @endforeach
 
     </select >

      </div>

      <div class="col-md-2">
<button class="btn btn-success btn-block find">Find Menu</button>

        </div>


</div>


</div>
</section>

    <section class="col-lg-12 connectedSortable">
    <div class="card direct-chat direct-chat-primary">
        <div class="flex-container">
  <div class="flex-item-left"><h5>Food Menu</h5></div>
  <div class="flex-item-right"><a href="#"><button class="btn btn-success add_bulk_gst"><span class="fa fa-plus"></span> Update Bulk GST</button></a></div>
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
                <th >S.No.</th>
               
              
                <th>Food Menu Category</th>
                <th>Food Menu </th>
                <th>Price</th>
                <th>GST</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>


 




  <!-- Edit Modal -->
  <div class="modal fade" id="edit_modal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
       <div class="add_body"></div>
        <!-- Modal footer -->
       
        
      </div>
    </div>
  </div>

<!--add_bulk_gst-->
 <div class="modal fade" id="add_bulk_gst">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Update Bulk GST</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
       
{!! Form::open(["files"=>true,'id'=>'update_bulk_gst'])!!}



<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">


</div>
<div class="modal-body">
<div class="row">


  <div class="col-lg-12">
<div class="form-group">
<label for="" class="required">GST </label>
<select class="form-control" name="tax_information" required>
<option value="">--Choose GST--</option>
@foreach($gsts as $gst)
<option value="{{$gst->id}}" >{{$gst->gst_name}}</option>
@endforeach
</select>  
</div>
</div>  

</div>




</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Update',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}
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
     //add_bulk_gst
  
     //
 $(document).on("click",".add_bulk_gst",function(e){
   e.preventDefault();
   $('#add_bulk_gst').modal('toggle');

    })
    //
    $(document).on("click",".edit",function(){
    var id=$(this).attr('id');
    var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/edit_foodmenu_price',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
           
          $(".add_body").html('').html(data)
           $('.select2').select2();
        },
        error:function(data)
        {

        }
    })

     $('#edit_modal').modal('toggle');

    })
    //update_first_stock
    $(document).on("submit", "#update_product_list", function (event) {

  event.preventDefault();

   $('#edit_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#update_product_list")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/update_franchise_foodmenuprice',
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
//update_bulk_gst
       //
  $(document).on("submit", "#update_bulk_gst", function (event) {

  event.preventDefault();

   $('#add_bulk_gst').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#update_bulk_gst")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/update_bulk_gst',
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
        url: "{{ route('get_franchise_food_menu') }}",
        data: {brand:brand,item_type:item_type},
    },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'category_name', name: 'category_name'},
          
            {data: 'name', name: 'name'},
          
            {data: 'price', name: 'price'},
            {data: 'gst', name: 'gst'},
        
        
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