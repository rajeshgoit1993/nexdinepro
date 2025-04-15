@extends("layouts.backend.master")

@section('maincontent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
 <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
     <?php  
  $request_segments=Request::segment(1);
  ?>
   @if($request_segments=='Manage-Vendor-Orders') 
 <input type="hidden" name="order" id="order" value="1">
    @elseif($request_segments=='Vendor-Orders-Dispatched')
 <input type="hidden" name="order" id="order" value="2">
     @elseif($request_segments=='Vendor-Orders-Delivered')
 <input type="hidden" name="order" id="order" value="3">
    @endif


         <div class="row">

     <div class="col-md-10">

 <select name="store" id="store" class="form-control valid" required>
     <option value="">--Select Vendor--</option>
     @foreach($datas as $data)
     <option value="{{ $data->id }}">{{ $data->name }}</option>
     @endforeach
     </select >

      </div>
   <!--    <div class="col-md-5">

 <select name="order" id="order" class="form-control valid" required>
  
    
     <option value="1">New Order</option>
     <option value="2">Dispatch Order</option>
     <option value="3">Dilivered Order</option>
     </select >

      </div> -->
     <!--    <div class="col-md-5">

 <select name="store" id="store" class="form-control valid" required>
     <option value="">--Select Type--</option>

     <option value="ingredients">Factory Ingredients</option>
     <option value="items">Items</option>
     </select >

      </div> -->

      <div class="col-md-2">
<button class="btn btn-success btn-block find">Find Data</button>

        </div>


</div>


</div>
</section>


<!-- 	<section class="col-lg-12 connectedSortable">
	<div class="card direct-chat direct-chat-primary">
		<div class="flex-container">
  <div class="flex-item-left"><h5>Stores List</h5></div>
  <div class="flex-item-right"><a href="{{URL::route('add_store')}}"><button class="btn btn-success"><span class="fa fa-plus"></span> Add Store</button></a></div>
</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
</div>
</section> -->
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<!-- /.content -->
<table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Product Name</th>
                <th>Order Qty</th>
               
               
                <th width="200px">Action</th>
            </tr>
        </thead>
        <tbody>
        

        </tbody>
    </table>







  <!-- The Modal -->
 <div class="modal fade" id="view_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Order Detail</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        {!! Form::open(["files"=>true,'id'=>"change_status","name"=>"change_status"])!!}
        <div class="modal-body uploads_body">


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
  //
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //
    $("#change_status").submit(function(e){
     e.preventDefault()
       $("#overlay").fadeIn(300);
  var form_data = new FormData($("#change_status")[0]);
 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/update_order_status_vendor',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Status Successfully Changed', "success");
        
        get_store_data('nochange')
     
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
  
$(document).on("click",".take_action",function(){
  var id=$(this).attr('id')
   var APP_URL=$("#APP_URL").val();
 
     $.ajax({
        url:APP_URL+'/get_outlet_order_status_update_by_factory',
        data:{id:id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
            // console.log(data)
         $(".uploads_body").html('').html(data)
         $('#view_modal').modal('toggle');
        },
        error:function(data)
        {

        }
    })


   
  
})

  //
$(document).on("click",".find",function(){

var store=$("#store").val()

if(store=='')
{
  alert('Kindly Select Store')
}
else
{

get_store_data('change')

   } 
})
function get_store_data($statesave)
  {
if($statesave=='change')
{
 $statesave=false;
}
else
{
$statesave=true;
}
   
var store=$("#store").val()
var order_status=$("#order").val()

if ($.fn.DataTable.isDataTable('.yajra-datatable')) {
   $('.yajra-datatable').DataTable().destroy()
}
    
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: $statesave,
        ajax: {
        url: "{{ route('get_vendor_outlet_orders') }}",
        data: {store:store,order_status:order_status},
    },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'order_id', name: 'order_id'},
            {data: 'order_date', name: 'order_date'},
            {data: 'product_name', name: 'product_name'},
            {data: 'qty', name: 'qty'},
        
         
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