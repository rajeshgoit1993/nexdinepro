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
<style type="text/css">
  span {cursor:pointer; }
    .number{
      margin:10px;
      text-align: center;
    }
    .minus, .plus{
      width:35px;
      height:35px;
      background:#f2f2f2;
      border-radius:4px;
      padding:8px 5px 8px 5px;
      border:1px solid #ddd;
      display: inline-block;
      vertical-align: middle;
      text-align: center;
    }
    input{
      height:35px;
      width: 100px;
      text-align: center;
      font-size: 26px;
      border:1px solid #ddd;
      border-radius:4px;
      display: inline-block;
      vertical-align: middle;
      
    </style>
  <!--   <style type="text/css">
  .count {
    disabled: true; 
  }
</style> -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
  <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    <div class="flex-container">
  <div class="flex-item-left"> <a href="{{url('Supply-List')}}" class="btn btn-success"><i class="fa fa-arrow-left"></i> Continue Shopping </a> <h5>Order-Placed</h5></div>

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
<h5>Cart List</h5>
 
<div class="row">
                <div class="col-12 table-responsive">
                <table class="table table-striped">
                <thead>
                <tr>
                      <th>Image</th>
                      <th>Product</th>
                      <th>Rate</th>
                      <th>Shipping Fee</th>
                      <th style="text-align:center;">Qty</th>
                   
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
                      <td>Rs. {{CustomHelpers::get_rate_with_gst($cart->item_id)}}/
 {{CustomHelpers::get_master_table_data('units','id',CustomHelpers::get_product_data($cart->item_id,"unit"),'unit')}} 
                     
                      </td>

                      <td>Rs. {{CustomHelpers::get_transport_fee(Sentinel::getUser()->id,CustomHelpers::get_product_data($cart->item_id,"unit"))}}/
 {{CustomHelpers::get_master_table_data('units','id',CustomHelpers::get_product_data($cart->item_id,"unit"),'unit')}} 
                     
                      </td>
                      <td>
 <div class="number" style="line-height: 1;">
<span class="minus"  cart_id="{{CustomHelpers::custom_encrypt($cart->id)}}">-</span>
  <input type="text" class="count" value="{{$cart->qty}}"/>
  <span class="plus" cart_id="{{CustomHelpers::custom_encrypt($cart->id)}}">+</span>
  </div>
                     

                </td>
                     
                      <td class="price">Rs. 
                    
                 {{CustomHelpers::get_item_subtotal_with_gst_with_transport($cart->id)}}
                     

                      </td>
                      
                    </tr>
                   
        @endforeach

  
     <tr>
     <td></td>
     <td></td>
     <td></td>

     <td ></td>
     <td ></td>
     <td>
    <!-- <form action="{{url('/Order-Checkout')}}" method="post"> 
      @csrf
   <button type="submit" class="btn btn-success">Pay Rs. <span style="font-weight: bold;" id="pay">{{CustomHelpers::get_all_item_subtotal_with_gst()}}</span></button>
     </form>   -->
     <form action="{{url('/Order_Payment')}}" method="post"> 
      @csrf
   <button type="submit" class="btn btn-success">Pay Rs. <span style="font-weight: bold;" id="pay">{{CustomHelpers::get_all_item_subtotal_with_gst()}}</span></button>
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

     //
     $(document).on("keyup change",".count",function(){
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    var count_value=$(this).val();
     if(count_value>=1)
     {
      var current=$(this)
        //
        var new_value=count_value;
        var APP_URL=$("#APP_URL").val();

        var cart_id=$(this).siblings('.plus').attr('cart_id')
  $.ajax({
        url:APP_URL+'/add_supply_to_cart',
        data:{cart_id:cart_id,new_value:new_value},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
           current.parent().parent().siblings('.price').html('').html('Rs '+data.subtotal)
         $('#pay').html('').html('Rs '+data.get_all_item_subtotal_with_gst) 
        },
        error:function(data)
        {

        }
    })


     }
   
})
 $(document).on("focusout",".count",function(){
   
    var count_value=$(this).val();
   if(count_value<1)
   {
  
    //
        var current=$(this)
        var new_value=count_value;
        var APP_URL=$("#APP_URL").val();

        var cart_id=$(this).siblings('.plus').attr('cart_id')
  $.ajax({
        url:APP_URL+'/add_supply_to_cart',
        data:{cart_id:cart_id,new_value:new_value},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
          if(data.button!='')
          {
current.parent().parent().parent().css('display','none')
current.parent().html('')
          }
         current.parent().parent().siblings('.price').html('').html('Rs '+data.subtotal)
         $('#pay').html('').html('Rs '+data.get_all_item_subtotal_with_gst)
        },
        error:function(data)
        {

        }
    })


  
   }
   
})
  //
    $(document).ready(function() {
        // $('.count').prop('disabled', true);

   $(document).on('click','.minus',function(){
      var current=$(this)
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        count = count < 0 ? 0 : count;
        $input.val(count);
        $input.change();
         //
        var new_value=$input.val();
        var APP_URL=$("#APP_URL").val();
      
         var cart_id=$(this).attr('cart_id')
  $.ajax({
        url:APP_URL+'/add_supply_to_cart',
        data:{cart_id:cart_id,new_value:new_value},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
          if(data.button!='')
          {
current.parent().parent().parent().css('display','none')
current.parent().html('')
          }
         current.parent().parent().siblings('.price').html('').html('Rs '+data.subtotal)
         $('#pay').html('').html('Rs '+data.get_all_item_subtotal_with_gst)
        },
        error:function(data)
        {

        }
    })
    //
        return false;
      });
      $(document).on('click','.plus',function(){
         var current=$(this)
  // $('.count').prop('disabled', true);
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        //
        var new_value=$input.val();
        var APP_URL=$("#APP_URL").val();

        var cart_id=$(this).attr('cart_id')
  $.ajax({
        url:APP_URL+'/add_supply_to_cart',
        data:{cart_id:cart_id,new_value:new_value},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
          current.parent().parent().siblings('.price').html('').html('Rs '+data.subtotal)
         $('#pay').html('').html('Rs '+data.get_all_item_subtotal_with_gst) 
        },
        error:function(data)
        {

        }
    })
    //

        return false;
      });
    });
  //

  //

  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
       
       
       
    });
    
  });
</script>

@endsection