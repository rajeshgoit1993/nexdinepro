@extends("layouts.backend.master")

@section('maincontent')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
       <?php  
  $request_segments=Request::segment(1);
  ?>
   @if($request_segments=='Warehouse-Newly-Submitted-Order') 
 <input type="hidden" name="order" id="order" value="1">
    @elseif($request_segments=='Warehouse-Ongoing-Order')
 <input type="hidden" name="order" id="order" value="2">
     @elseif($request_segments=='Warehouse-Delivered-Order')
 <input type="hidden" name="order" id="order" value="3">
    @endif

 <!-- <section class="col-lg-12 connectedSortable">
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
<button class="btn btn-success btn-block find">Find Data</button>

        </div>


</div>


</div>
</section> -->

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
                <th width="50px">S.No.</th>
               
              
             
               <th>Order ID</th>
               <th>Wharehouse Name</th>
             
               <th>Status</th>
             <th>Action</th>
            </tr>
        </thead>
        <tbody>
       </tbody>
    </table>





 <div class="modal fade" id="whare_house_order">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Order Detail</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        {!! Form::open(["files"=>true,'id'=>"whare_house_order_data","name"=>"whare_house_order_data"])!!}
        <div class="modal-body whare_house_order_body">


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
  //
$(document).on("click",".whare_house_order_view",function(){

      var id=$(this).attr('id')
   var APP_URL=$("#APP_URL").val();
 
     $.ajax({
        url:APP_URL+'/whare_house_order_view',
        data:{id:id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
            // console.log(data)
         $(".whare_house_order_body").html('').html(data)
         $('#whare_house_order').modal('toggle');
        },
        error:function(data)
        {

        }
    })

})
//
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
        url: "{{ route('get_store_new_order') }}",
        data: {store:store,order_status:order_status},
    },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
         
           
          
            {data: 'order_id', name: 'order_id'},
            {data: 'factory_name', name: 'factory_name'},
         
            {data: 'status', name: 'status'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
            
        ]
      
    });
    //

  }
</script>

@endsection