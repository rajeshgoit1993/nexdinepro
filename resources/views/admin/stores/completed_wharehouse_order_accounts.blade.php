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
               <th>Product Name</th>
               <th>Qty</th>
             
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
                {{CustomHelpers::get_master_table_data('master_products','id',CustomHelpers::get_master_table_data('store_products','id',$order->product_id,'product_id'),'product_name')}}
                 </td>
                
               
                <td>
                    
                 {{$order->qty}}

                </td>
                <td>
                    @if($order->status==1)
                   <span>Assigned</span>
                    @elseif($order->status==2)
                    <span>Dispatched <img src="{{url('resources\assets\new.gif')}}"></span>
                     <br>
                    <a href="#" id="{{CustomHelpers::custom_encrypt($order->id)}}" class="btn btn-sm btn-success accounts_enter_collection"><span class="fa fa-eye"></span> Collection Details</a>

                    @elseif($order->status==3)
                    <span>Delivered</span>
                    @elseif($order->status==4)
                   <span>Replied to Accounts <img src="{{url('resources\assets\new.gif')}}"></span>
                   <br>
                    <a href="#" id="{{CustomHelpers::custom_encrypt($order->id)}}" class="btn btn-sm btn-success accounts_view_and_accept"><span class="fa fa-eye"></span> View & Accept</a>
                    @elseif($order->status==5)
                  <span>Revert To Vendor/Factory </span>
                    @elseif($order->status==6)
                    <span>Accepted By Vendor/Facrory</span>
                    @endif
                    


                </td>
                <td>
                    
                 <a href="#" class="btn btn-sm btn-success whare_house_order_view"  id="{{CustomHelpers::custom_encrypt($order->id)}}" ><span class="fa fa-eye"></span>  View </a>

                </td>

           </tr>
            @endforeach
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



 <div class="modal fade" id="view_modal_second">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Order Detail</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        {!! Form::open(["files"=>true,'id'=>"cost_est_data","name"=>"cost_est_data"])!!}
        <div class="modal-body cost_est_body">


        </div>
          {!! Form::close() !!} 
        <!-- Modal footer -->
      
        
      </div>
    </div>
  </div>


 <div class="modal fade" id="view_modal_first">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Order Detail</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        {!! Form::open(["files"=>true,'id'=>"delivery_data","name"=>"delivery_data"])!!}
        <div class="modal-body delivery_data_body">


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
    $(function () {
    
    var table = $('.yajra-datatable').DataTable({
       
       
       
    });
    
  });
    //
     $("#delivery_data").submit(function(e){
     e.preventDefault()
       $("#overlay").fadeIn(300);
  var form_data = new FormData($("#delivery_data")[0]);
 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/update_delivered_status_by_accounts',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Submitted', "success");
        
       location.reload();
     
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
  $("#cost_est_data").submit(function(e){
     e.preventDefault()
       $("#overlay").fadeIn(300);
  var form_data = new FormData($("#cost_est_data")[0]);
 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/update_accept_status_by_accounts',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Submitted', "success");
        
       location.reload();
     
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
$(document).on("click",".accounts_view_and_accept",function(){

      var id=$(this).attr('id')
   var APP_URL=$("#APP_URL").val();
 
     $.ajax({
        url:APP_URL+'/accounts_view_and_accept_wharehouse_order',
        data:{id:id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
            // console.log(data)
         $(".cost_est_body").html('').html(data)
         $('#view_modal_second').modal('toggle');
        },
        error:function(data)
        {

        }
    })

})
//accounts_enter_collection
$(document).on("click",".accounts_enter_collection",function(){

      var id=$(this).attr('id')
   var APP_URL=$("#APP_URL").val();
 
     $.ajax({
        url:APP_URL+'/accounts_view_and_verify_collection_details',
        data:{id:id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
            // console.log(data)
         $(".delivery_data_body").html('').html(data)
         $('#view_modal_first').modal('toggle');
        },
        error:function(data)
        {

        }
    })

})
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