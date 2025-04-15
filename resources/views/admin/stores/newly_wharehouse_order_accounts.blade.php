@extends("layouts.backend.master")

@section('maincontent')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">


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
               
              <th>Wharehouse Name</th>
               <th>No of items</th>
              
             
               <th>Status</th>
               <th>Action</th>
            </tr>
        </thead>
        <tbody>
             <?php
$sn=1;
    ?>
            @foreach($orders as $order)
           <tr>
                <td>{{$sn++}}</td>
                <td> {{ CustomHelpers::get_master_table_data('stores','id',$order->wharehouse_id,'name') }}  </td>
                <td> 
                <?php 
                $order_items=DB::table('wharehouse_order_details')->where('wharehouse_order_id','=',$order->id)->get();
                ?>
                {{count($order_items)}} Items
                 </td>
                
               
                <td>
                    
                 Pending

                </td>
                <td>
                    
                 <a href="{{url('Wharehouse-Order-Assign/'.CustomHelpers::custom_encrypt($order->id))}}" class="btn btn-sm btn-success"><span class="fa fa-eye"></span> Take Action</a>

                </td>

           </tr>
            @endforeach
       </tbody>
    </table>









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
    $(function () {
    
    var table = $('.yajra-datatable').DataTable({
       
       
       
    });
    
  });
  //
// $(document).on("click",".find",function(){

// var store=$("#store").val()

// if(store=='')
// {
//   alert('Kindly Select Store')
// }
// else
// {

// get_store_data('change')

//    } 
// })
// $(document).ready(function(){
//    get_store_data('change')
    
// })
// function get_store_data($statesave)
//   {
// if($statesave=='change')
// {
//  $statesave=false;
// }
// else
// {
// $statesave=true;
// }
   
// var store=$("#store").val()

// if ($.fn.DataTable.isDataTable('.yajra-datatable')) {
//    $('.yajra-datatable').DataTable().destroy()
// }
    
//     var table = $('.yajra-datatable').DataTable({
//         processing: true,
//         serverSide: true,
//         stateSave: $statesave,
//         ajax: {
//         url: "{{ route('get_store_new_order') }}",
//         data: {store:store},
//     },
       
//         columns: [
//             {data: 'DT_RowIndex', name: 'DT_RowIndex'},
         
           
//             {data: 'name', name: 'name'},
//             {data: 'unit', name: 'unit'},
//             {data: 'qty', name: 'qty'},
         
//             {data: 'status', name: 'status'},
            
//         ]
      
//     });
//     //

//   }
</script>

@endsection