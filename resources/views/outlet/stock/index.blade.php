@extends("layouts.backend.master")

@section('maincontent')
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
 <!--    <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    
         <div class="row">

  
       <div class="col-md-10">

 <select name="item_type" id="item_type" class="form-control valid" required>
     <option value="">--Select Item Iype--</option>
     
     <option value="Utensil">Utensil</option>
     <option value="Equipment">Equipment</option>
     <option value="Disposable">Disposable</option>
     <option value="Frozen">Frozen</option>
     <option value="Masala">Masala</option>
 
     </select >

      </div>

      <div class="col-md-2">
<button class="btn btn-success btn-block find">Find Item</button>

        </div>


</div>


</div>
</section> -->

    <section class="col-lg-12 connectedSortable">
    <div class="card direct-chat direct-chat-primary">
        <div class="flex-container">
  <div class="flex-item-left"><h5>Stock List</h5></div>
  <div class="flex-item-right">

    <a href="{{route('export_stock')}}" id="750" class="export_stock  btn btn-default "><i class="fas fa-file-export"></i> Export Stock</a>

    <a href="#" class="import_stock btn btn-primary "><i class="fas fa-file-import"></i> Import Stock</a>

    <!-- <a href="{{URL::route('add_product')}}"><button class="btn btn-success"><span class="fa fa-plus"></span> Add Product</button></a> -->

</div>
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
                <th>Image</th>
              
                <th>Product Name</th>
               
                <th>Unit</th>
               
                <th> Thsld QTY</th>
                <th>Avl QTY</th>
                
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

  <!---->
   <!---->
  <div class="modal fade" id="stock_upload">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Release the Stock</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
       {!! Form::open(["files"=>true,'id'=>'store_stock'])!!}


<!-- Modal content-->
<div class="">

<div class="modal-body">
<div class="row">
 

  
   
     <div class="col-lg-12">
        <div class="form-group">
<label for="" >Date</label>
<input type="date" name="date" value="{{date('Y-m-d')}}" max="{{date('Y-m-d')}}" min="{{date('Y-m-d')}}" class="form-control"> 
</div>

<div class="form-group upload_form">
  
</div>


    </div>
     


</div>



</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Release the Stock',["class"=>"btn btn-success"]) !!}

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
     //
   $(document).on("click",".import_stock",function(){


    
   var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/get_import_stock_form',
       
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
       $(".upload_form").html('').html(data)
      $('#stock_upload').modal('toggle');

        },
        error:function(data)
        {

        }
    })


 
  })
     // store_stock


     $(document).on("submit", "#store_stock", function (event) {

  event.preventDefault();

   
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#store_stock")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/store_stock_by_excel',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
            $('#stock_upload').modal('hide');
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
 //

    
    //
    $(document).on("click",".edit",function(){
    var id=$(this).attr('id');
    var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/edit_stock_list',
        data:{id:id},
        type:'post',
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
        url:APP_URL+'/update_stock_list',
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
        url: "{{ route('get_stock_product') }}",
        data: {brand:brand,item_type:item_type},
    },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'image', name: 'image'},
          
            {data: 'product_name', name: 'product_name'},
          
            {data: 'unit', name: 'unit'},
         
            
            {data: 'threshold_qty', name: 'threshold_qty'},
            {data: 'available_qty', name: 'available_qty'},
        
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