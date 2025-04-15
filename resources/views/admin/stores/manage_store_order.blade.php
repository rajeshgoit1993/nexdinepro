@extends("layouts.backend.master")

@section('maincontent')
  <?php  
  $request_segments=Request::segment(1);
  ?>
   @if($request_segments=='Manage-Warehouse-Orders') 
 <input type="hidden" name="order" id="order" value="1">
    @elseif($request_segments=='Ongoing-Franchise-Orders')
 <input type="hidden" name="order" id="order" value="2">
     @elseif($request_segments=='Completed-Franchise-Orders')
 <input type="hidden" name="order" id="order" value="3">
    @endif

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
    @if(Sentinel::getUser()->inRole('superadmin')):
    <?php  
   $store_count=DB::table('stores')->where('type','=',1)->whereIn('status',[1,2])->get();
    ?>
    @if(count($store_count)>1)
 <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    
         <div class="row">

     <div class="col-md-10">

    <select name="store" id="store" class="form-control valid" required>
     <option value="">--Select Warehouse--</option>
     @foreach($datas as $data)
     <option value="{{ $data->id }}">{{ $data->name }}</option>
     @endforeach
     </select >

      </div>
     
      <div class="col-md-2">
<button class="btn btn-success btn-block find">Find Orders</button>

        </div>


</div>


</div>
</section>

@else
<?php 
 $store=DB::table('stores')->where('type','=',1)->whereIn('status',[1,2])->first();
?>
<input type="hidden" name="" id="store" value="{{$store->id}}">

@endif
 @else
<?php 
  $user_id=Sentinel::getUser()->id;
  $store_ids=DB::table('store_assign_users')->where([['user_id','=',$user_id],['type','=',1]])->pluck('store_id');
     
  $stores=DB::table('stores')->where('type','=',1)->whereIn('status',[1,2])->whereIn('id',$store_ids)->get();
?>
 @if(count($stores)>1)
 <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    
         <div class="row">

     <div class="col-md-10">

    <select name="store" id="store" class="form-control valid" required>
     <option value="">--Select Warehouse--</option>
     @foreach($stores as $data)
     <option value="{{ $data->id }}">{{ $data->name }}</option>
     @endforeach
     </select >

      </div>
     
      <div class="col-md-2">
<button class="btn btn-success btn-block find">Find Orders</button>

        </div>


</div>


</div>
</section>
 @else
    @foreach($stores as $data)
<input type="hidden" name="" id="store" value="{{$data->id}}">
     @endforeach

 @endif
 @endif

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
                <th>Transaction ID</th>
                <th>Amount</th>
                <th>Status</th>
               
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
          

        </tbody>
    </table>




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
function save_status(form_data,this_form)
{

if(confirm("Are you sure?"))
    {
        var button=this_form
       
 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/change_order_status_store',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            if(data=='success')
            {

           alert('Successfully Updated')
            }
            else if(data=='delivered')
            {
             button.html('');
             alert('Successfully Updated')
            }
            else
            {
                alert(data)     
            }
   

        },
        error:function(data)
        {

        }
    })

}
 }


 $(document).on("keyup change",".order_confirm_qty",function(){
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    
})




//
$(document).on("change",".status_order_change",function(){



    var order_id=$(this).siblings('.order_id').val()
    var status=$(this).val()
    var APP_URL=$("#APP_URL").val();
    var button=$(this)
     $.ajax({
        url:APP_URL+'/change_order_status_dynamic_data',
        data:{order_id:order_id,status:status},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
          
           button.parent().parent().siblings('.add_dynamic_form').html('').html(data)
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
        url:APP_URL+'/order_details_with_status_change',
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
$('#view_modal').on('hidden.bs.modal', function () {
   get_store_data('change')
});

 $(document).ready(function()
 {
   var store=$("#store").val() 
   if(store=='')
{
 
}
else
{

get_store_data('change')

   } 
 })

  //
$(document).on("click",".find",function(){

var store=$("#store").val()

if(store=='')
{
  alert('Kindly Select Wharehouse')
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
        url: "{{ route('get_store_order') }}",
        data: {store:store,order_status:order_status},
    },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'order_id', name: 'order_id'},
            {data: 'order_date', name: 'order_date'},
            {data: 'transaction_id', name: 'transaction_id'},
            {data: 'amount', name: 'amount'},
          
            {data: 'status', name: 'status'},
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