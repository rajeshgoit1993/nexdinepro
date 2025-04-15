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
  <div class="flex-item-left"><h5>New Order Payments</h5></div>
 
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
                <th>Franchise ID</th>
                <th>Order ID</th>
           
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
     <td>{{CustomHelpers::get_user_data($datas->fanchise_id,'email')}}</td>
     <td>{{ $datas->id }}</td>
     <td>{{ $datas->transaction_id }}</td>
     <td>{{ $datas->amount }}</td>
     <td>
        @if($datas->status==0)
          New Order
        @elseif($datas->status==1)
          Order Confirmed
        @elseif($datas->status==2)
        Dispatch
         @elseif($datas->status==3)
         Delivered
         @endif
      

    </td>
     <td>
      <a href="{{url('Order-Invoice/'.CustomHelpers::custom_encrypt($datas->id))}}">
<button class="btn btn-info btn-sm view_invoice" > View Invoice </button>

 
</a>
<!-- <button class="btn btn-sm btn-success take_action" id="{{CustomHelpers::custom_encrypt($datas->id)}}" > <span class="fa fa-eye"></span> Take Action </button> -->
     </td>

     

     </tr>

     @endforeach


        </tbody>
    </table>


 

  <!-- The Modal -->

   <div class="modal fade" id="view_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Order Status Change</h4>
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

  
$(document).on("click",".take_action",function(){
  var id=$(this).attr('id')
   var APP_URL=$("#APP_URL").val();
 
     $.ajax({
        url:APP_URL+'/get_update_order_payment_status',
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
 //
$(document).on("click","#update_survey",function(){ 

  


      $("#overlay").fadeIn(300);
  var form_data = new FormData($("#change_status")[0]);
 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/order_payment_confirm_by_account',
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
        var url=APP_URL+'/New-Order-Payments';
        window.location.href = url;
     
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
</script>

@endsection