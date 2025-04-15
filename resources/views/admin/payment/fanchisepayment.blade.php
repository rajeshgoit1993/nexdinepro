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
  <div class="flex-item-left"><a href="{{url('/First-Time-Stock')}}" class="btn btn-success"><i class="fa fa-arrow-left"></i> Back</a> <h5>   First Time Stock List Payment</h5></div>

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
                      <th>Qty</th>
                     
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                   <?php
                $total=0;
                $total_local=0;
                ?>
        @foreach($cart_datas as $cart_data)
           <?php  
            $image_data=DB::table('item_images')->where([['item_id','=',$cart_data->list_id],['default','=',1],['image_type','=',0]])->first();
          if($image_data!='' && $image_data->thumb!=''):
            $path=url('public/uploads/item/thumb/'.$image_data->thumb);
                    $image = '<img src="'.$path.'" width="30px">';
          else:
           $path = url('public/uploads/item/noimage.png');
                    $image = '<img src="'.$path.'" width="30px">';
          endif;
          ?>
        <tr>
                      <td>{!! $image  !!}</td>
                      <td>{{CustomHelpers::get_list_data($cart_data->list_id,"utensil_name")}}</td>
                      <td>Rs. {{$cart_data->qty_rate}}</td>
                      <td>{{$cart_data->qty}}</td>
                     
                      <td class="price">Rs. 
                    
                     @if($cart_data->purchase_from=='Central Supply')
                        {{$cart_data->amount}}
                      @else
                       0
                      @endif
                     

                      </td>
                      
                    </tr>
                    <?php
                    if($cart_data->purchase_from=='Central Supply'):
                    $total=$total+$cart_data->amount;
                  else:
                  $total_local=$total_local+$cart_data->amount;
                    endif;
                    ?>
        @endforeach

  
     <tr>
     
     <td></td>
     <td></td>
     <td></td>
     <td >Total Central Supply Rs <span id="total" style="font-weight: bold;">{{round($total)}}</span></td>
     <td>
      <form action="{{url('store_payment')}}" method="POST" id="demo">
                              @csrf
                              
                              <script id="myScript" src="https://checkout.razorpay.com/v1/checkout.js"
                                 data-key="{{ env('RAZORPAY_KEY') }}"
                                 data-amount={{round($total)*100}} 
                                 data-currency="INR"
                                 data-buttontext="Pay Rs. {{round($total)}}" 
                                 data-name="realprogrammer.in"
                                 data-description="Rozerpay"
                                 data-image="https://realprogrammer.in/wp-content/uploads/2020/10/logo.jpg"
                                 data-prefill.name="name"
                                 data-prefill.email="email"
                                 data-theme.color="#F37254">
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
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/accordian.js')}}"></script>
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/timeline.js')}}"></script>
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

$(document).on("change",".supply_from",function(){
var id=$(this).attr('id')
var supply_from=$(this).val()
var button=$(this).parent().siblings('.price')
if(supply_from=='Central Supply' || supply_from=='Local Purchase')
{
var APP_URL=$("#APP_URL").val();
 $.ajax({
        url:APP_URL+'/change_supply_from',
        data:{id:id,supply_from:supply_from},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
         $("#total").html('').html(data.central)
         $("#local").html('').html(data.local)
         $("#pay").html('').html(data.central)
        
                                
         //
         if(supply_from=='Central Supply')
         {
          button.html('').html('Rs. '+data.price)
         }
         else
         {
          button.html('').html('Rs. 0')
         }
         
        },
        error:function(data)
        {

        }
    })

}

})

  //

  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
       
       
       
    });
    
  });
</script>

@endsection