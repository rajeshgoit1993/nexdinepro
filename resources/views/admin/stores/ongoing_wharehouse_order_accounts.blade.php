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
   @if($request_segments=='Newly-Assigned-Wharehouse-Order') 
 <input type="hidden" name="order" id="order" value="1">
    @elseif($request_segments=='Replied-to-Accounts-Wharehouse-Order')
 <input type="hidden" name="order" id="order" value="2">
     @elseif($request_segments=='Ongoing-Wharehouse-Order-Accounts')
 <input type="hidden" name="order" id="order" value="3">
  @elseif($request_segments=='Dispatched-Wharehouse-Order')
 <input type="hidden" name="order" id="order" value="4">
 @elseif($request_segments=='Completed-Wharehouse-Order-Accounts')
 <input type="hidden" name="order" id="order" value="5">
    @endif


<!-- /.content -->
<table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Order ID</th>
             
                <th>Warehouse Name</th>
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


//
  <!-- The Modal -->
 <div class="modal fade" id="view_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Account Actions</h4>
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


//
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
    $("#change_status").submit(function(e){
     e.preventDefault()
       $("#overlay").fadeIn(300);
  var form_data = new FormData($("#change_status")[0]);
 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/update_wharehouse_order_status_account',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
            $('#view_modal').modal('hide');
       swal("Done !", 'Status Successfully Changed', "success");
        
        get_store_data('change')
     
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
   var status=$("#order").val()
  
 
     $.ajax({
        url:APP_URL+'/wharehouse_order_status_update_by_account',
        data:{id:id,status:status},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
           
          $(".uploads_body").html('').html(data)
         $('#view_modal').modal('toggle');
        },
        error:function(data)
        {

        }
    })


   
  
})
  //
 //
 $(document).ready(function(){
  get_store_data('change')
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
   

var order_status=$("#order").val()

if ($.fn.DataTable.isDataTable('.yajra-datatable')) {
   $('.yajra-datatable').DataTable().destroy()
}
    
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: $statesave,
        ajax: {
        url: "{{ route('get_wharehouse_order_accounts') }}",
        data: {order_status:order_status},
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
  }
</script>

@endsection