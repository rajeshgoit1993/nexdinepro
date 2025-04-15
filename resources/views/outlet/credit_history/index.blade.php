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
  <div class="flex-item-left"><h5>Credit History</h5></div>

</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
</div>
</section>
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
  
<!-- /.content -->
<div class="table-responsive">
  <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Date</th>
                <th>Credit</th>
                <th>Debit</th>
                <th>Balance</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php  
           $a=1;
          
            ?>
     @foreach($data as $datas)

     <tr>
     <td>{{ $a++ }}</td>
     <td>{{ $datas->created_at }}</td>
      <td style="color:green">Rs. {{ $datas->credit }}</td>
     <td style="color:red">Rs. {{ $datas->debit }}</td>
     <td>Rs. {{ $datas->remaining_bal }}</td>
     <td> {{ $datas->remarks }}
      @if($datas->refund_qty!='')
      <br>
      Refund Qty: {{$datas->refund_qty}}, Refund Order Id: {{$datas->refund_order_id}}, Refund Product: {{CustomHelpers::get_master_table_data('master_products','id',$datas->refund_product_id,'product_name')}},
      @endif
     </td>


     

     </tr>

     @endforeach


        </tbody>
    </table>











<!-- /.content -->
</div>
</div>
</section>

</div>

</div>
</section>

</div>

<div class="form">

</div>
<!---->
  <!-- Button to Open the Modal -->
  
   

@endsection
@section('custom_js')
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/accordian.js')}}"></script>
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/timeline.js')}}"></script>

<script type="text/javascript">

//kyc

  //
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     //
 
    //fill_pre_launch



    //
$(document).on("click",".remove",function(){
   var r = confirm("Are you sure ?");

     
       if (r === false) {
           return false;
        }
})
  //

  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
       
       
       
    });
    
  });
</script>

@endsection