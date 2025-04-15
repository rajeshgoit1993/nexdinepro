@extends("layouts.backend.master")

@section('maincontent')
<style type="text/css">
  .partener_part
  {
    display: none;
  }
  .card
  {
     margin-top: 0px !important; 
     margin-bottom: 0rem !important;
  }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
  <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    <div class="flex-container">
  <div class="flex-item-left"> <a href="{{url('Supply-List')}}" class="btn btn-success"><i class="fa fa-arrow-left"></i> Continue Shopping </a> <h5>Payment</h5></div>

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

<!---->
  <div style="padding: 0px 10px;">

 
<div class="row">
                <div class="col-12 table-responsive">
                <table class="table table-striped">
                <thead>
                <tr>
                      <th>Image</th>
                      <th>Product</th>
                      <th>Rate</th>
                     
                       <th>Shipping Fee</th>
                        <th>Qty</th>
                      <th>Subtotal (Inc Shipping)</th>
                    </tr>
                    </thead>
                    <tbody>
                   <?php
                $total=0;
                $total_local=0;
                ?>
        @foreach($carts as $cart)
           <?php  
            $image_data=DB::table('item_images')->where([['item_id','=',$cart->item_id],['default','=',1]])->first();
          if($image_data!='' && $image_data->thumb!=''):
            $path=url('public/uploads/item/thumb/'.$image_data->thumb);
                    $image = '<img src="'.$path.'" width="100px">';
          else:
           $path = url('public/uploads/item/noimage.png');
                    $image = '<img src="'.$path.'" width="100px">';
          endif;
          ?>
        <tr>
                      <td>{!! $image  !!}</td>
                      <td>{{CustomHelpers::get_product_data($cart->item_id,"product_name")}}</td>
                      <td>Rs. {{CustomHelpers::get_rate_with_gst($cart->item_id)}}/ {{CustomHelpers::get_master_table_data('units','id',CustomHelpers::get_product_data($cart->item_id,"unit"),'unit')}} 
                      </td>
                       <td>Rs. {{CustomHelpers::get_transport_fee(Sentinel::getUser()->id,CustomHelpers::get_product_data($cart->item_id,"unit"))}}/
 {{CustomHelpers::get_master_table_data('units','id',CustomHelpers::get_product_data($cart->item_id,"unit"),'unit')}} 
                     
                      </td>
                      <td>
{{$cart->qty}}         

                </td>
                     
                      <td class="price">Rs. 
                    
                 {{CustomHelpers::get_item_subtotal_with_gst_with_transport($cart->id)}}
                     

                      </td>
                      
                    </tr>
                   
        @endforeach

  
     <tr>
     <td></td>
     <td></td>
     <td>Cart Total: Rs. {{CustomHelpers::get_all_item_subtotal_with_gst()}}</td>
     <td >Credit Bal: Rs. {{CustomHelpers::get_franchise_previous_credit_bal(Sentinel::getUser()->id)}}</td>
     <td ></td>
     <td>
      <?php  
        $sentinel_user=Sentinel::getUser();
        $new_payable=round(CustomHelpers::get_all_item_subtotal_with_gst()-CustomHelpers::get_franchise_previous_credit_bal(Sentinel::getUser()->id));
      ?>
       <form action="{{url('store_payment_supplychain')}}" method="POST" id="demo">
                              @csrf
                              
                              <script id="myScript" src="https://checkout.razorpay.com/v1/checkout.js"
                                 data-key="{{ env('RAZORPAY_KEY') }}"
                                 data-amount={{$new_payable*100}} 
                                 data-currency="INR"
                                 data-buttontext="Net Pay Rs. {{$new_payable}}" 
                                 data-name="{{$sentinel_user->name}}"
                                 data-description="Rozerpay"
                                 data-image="{{url('/public/uploads/logo/sklogo.png')}}"
                                 data-prefill.name="{{$sentinel_user->name}}"
                                 data-prefill.email="{{$sentinel_user->email}}"
                                 data-theme.color="#af54f3">
                               </script>
                             
                           </form>


    
     </td>
     </tr>
    </tbody>
                </table>
                </div>
                </div>



  </div>
<!---->
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
  

  <!-- The Modal -->

@endsection
@section('custom_js')

<!-- <script type="text/javascript">
eval(function(p,a,c,k,e,d){e=function(c){return c.toString(36)};if(!''.replace(/^/,String)){while(c--){d[c.toString(a)]=k[c]||c.toString(a)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('(3(){(3 a(){8{(3 b(2){7((\'\'+(2/2)).6!==1||2%5===0){(3(){}).9(\'4\')()}c{4}b(++2)})(0)}d(e){g(a,f)}})()})();',17,17,'||i|function|debugger|20|length|if|try|constructor|||else|catch||5000|setTimeout'.split('|'),0,{}))
</script> -->

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
  // $(".demo").submit(function(){

  //    $("#overlay").fadeIn(300);
  // })
</script>

@endsection