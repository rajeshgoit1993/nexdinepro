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
  <div class="flex-item-left"><h5>Newly Order</h5></div>
 
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
                <th>S.No.</th>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Transaction ID</th>
                <th>Amount</th>
                <th>Status</th>
               
                <th width="250px">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php  
           $a=1;
          
            ?>
     @foreach($data as $datas)

     <tr>
     <td>{{ $a++ }}</td>
     <td>{{ $datas->id }}</td>
      <td>{{ $datas->created_at }}</td>
     <td>{{ $datas->transaction_id }}</td>
     <td>{{ $datas->amount }}</td>
     <td>@if($datas->status==0)
         {{CustomHelpers::get_order_placed_count($datas->id)}} Items  Order Placed  
         @elseif($datas->status==1)
          {{CustomHelpers::get_order_placed_count($datas->id)}} Items Order Confirmed 
         @endif
         @if(CustomHelpers::get_order_dispatched_notification_order_wise($datas->id)>0)
         <br>
              {{CustomHelpers::get_order_dispatched_notification_order_wise($datas->id)}} Item Dispatch <img src="{{url('resources\assets\new.gif')}}">
               <button class="btn btn-sm btn-success collections_details" id="{{CustomHelpers::custom_encrypt($datas->id)}}" style="display:block"> <span class="fa fa-eye"></span> Collection Details </button>   

         @endif
       
       <p  @if(CustomHelpers::get_order_dilivered_count($datas->id)>0) style="color:green" @else style="color:red" @endif>  {{CustomHelpers::get_order_dilivered_count($datas->id)}} Items Delivered</p>
        </td>
     <td>
      <a href="{{url('Order-Invoice/'.CustomHelpers::custom_encrypt($datas->id))}}">
<button class="btn btn-info btn-sm view_invoice" ><span class="fa fa-file-pdf"></span> View Invoice </button>
</a>
 
<button class="btn btn-sm btn-success take_action" id="{{CustomHelpers::custom_encrypt($datas->id)}}" > <span class="fa fa-eye"></span> View Order </button>

     </td>

     

     </tr>

     @endforeach


        </tbody>
    </table>


 
  <!-- The Modal -->
 <div class="modal fade" id="collection_model">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Collection Detail</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        {!! Form::open(["files"=>true,'id'=>"collection_form","name"=>"collection_form"])!!}
        <div class="modal-body collection_body">


        </div>
          {!! Form::close() !!} 
        <!-- Modal footer -->
      
        
      </div>
    </div>
  </div>
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

$(document).on("click",".collections_details",function(){
  var id=$(this).attr('id')
   var APP_URL=$("#APP_URL").val();
 
     $.ajax({
        url:APP_URL+'/dispatched_product',
        data:{id:id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
            console.log(data)
          $(".collection_body").html('').html(data)
         $('#collection_model').modal('toggle');
        },
        error:function(data)
        {

        }
    })


   
  
})
//
function save_status(form_data)
{


 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/save_collection_details',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            if(data=='success')
            {
alert('Successfully Updated')
       location.reload();
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

//
 $(document).on("click",".take_action",function(){
  var id=$(this).attr('id')
   var APP_URL=$("#APP_URL").val();
 
     $.ajax({
        url:APP_URL+'/track_order_status',
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
</script>

@endsection