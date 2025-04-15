@extends("layouts.backend.master")

@section('maincontent')
<!-- Content Wrapper. Contains page content -->
<input type="hidden" name="val" id="val" value="{{$val}}">
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">


    <section class="col-lg-12 connectedSortable">
    <div class="card direct-chat direct-chat-primary">
        <div class="flex-container">
  <div class="flex-item-left"><h5>
    @if($val==0)
New Physical Request
    @else
Completed Physical Request
    @endif
   
</h5></div>
  <div class="flex-item-right">

    <!-- <a href="{{route('export_stock')}}" id="750" class="export_stock  btn btn-default "><i class="fas fa-file-export"></i> Export Stock</a> -->

    <!-- <a href="#" class="import_stock btn btn-primary "><i class="fas fa-file-import"></i> Import Stock</a> -->

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
                <th>Outlet Details</th>
              
                <th>Details</th>
               
                
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
          <h4 class="modal-title">Upload Stock</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
       {!! Form::open(["files"=>true,'id'=>'store_admin_stock_by_excel'])!!}


<!-- Modal content-->
<div class="">

<div class="modal-body">
<div class="row">
 

  
   
     <div class="col-lg-12">
        

<div class="form-group upload_form">
  
</div>


    </div>
     


</div>



</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}

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


     $(document).on("submit", "#store_admin_stock_by_excel", function (event) {

  event.preventDefault();

   
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#store_admin_stock_by_excel")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/store_admin_stock_by_excel',
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

    
    //update_first_stock


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
var val=$("#val").val()

if ($.fn.DataTable.isDataTable('.yajra-datatable')) {
   $('.yajra-datatable').DataTable().destroy()
}

     var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: $statesave,
        ajax: {
        url: "{{ route('get_physical_request') }}",
        data: {brand:brand,item_type:item_type,val:val},
    },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'outlet_details', name: 'outlet_details'},
          
            {data: 'details', name: 'details'},
          
           
        ]
    });   
}
 
</script>

@endsection