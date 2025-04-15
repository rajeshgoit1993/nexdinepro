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
  <div class="flex-item-left"><h5>First Time Stock List</h5></div>

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
  @include('admin.fanchises.step')
<!-- /.content -->
 @include("admin.fanchises.accordian")
<!---->
  <div style="padding: 0px 10px;">
    <a href="{{route('fanchise_account')}}" class="btn btn-success"><i class="fa fa-arrow-left"></i> Back</a>
    <a href="{{route('first_time_stock_download')}}" target="_blank" class="btn btn-info"><i class="fa fa-download"></i> Download</a>
<h5>First Time Stock List</h5>
 
<div class="row">
                <div class="col-12 table-responsive">
                <table class="table table-striped">
                <thead>
                <tr>
                      <th>Image</th>
                      <th>Product</th>
                      <th>Rate</th>
                      <th>Qty</th>
                      <th>Supply From</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                   <?php
                $total=0;
                $total_local=0;
            
                ?>

        @foreach($categories as $categorie)
         <?php 
         
$cart_data_s=DB::table('first_time_stock_carts')->where([['fanchise_id',$categorie->fanchise_id],['extra1',$categorie->extra1],['payment_status','=',0],['qty','>',0]])->get();
         ?>
         <tr>
           <td colspan="6"><h3 style="font-weight: bold;">{{$categorie->extra1}}</h3></td>
         </tr>
        @foreach($cart_data_s as $cart_data)
           <?php  
            $image_data=DB::table('item_images')->where([['item_id','=',$cart_data->list_id],['default','=',1]])->first();
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
                      <td>{{CustomHelpers::get_list_data($cart_data->list_id,"product_name")}}</td>
                      <td>Rs. {{CustomHelpers::get_rate_with_gst_first_stock($cart_data->list_id)}}</td>
                      <td>{{$cart_data->qty}}</td>
                      <td>
                      <select class="form-control supply_from" id="{{CustomHelpers::custom_encrypt($cart_data->id)}}">
                 <option value="Central Supply" @if($cart_data->purchase_from=='Central Supply') selected @endif>Central Supply</option>
                 <option value="Local Purchase" @if($cart_data->purchase_from=='Local Purchase') selected @endif>Local Purchase</option>
                      </select>
                      </td>
                      <td class="price">Rs. 
                    
                     @if($cart_data->purchase_from=='Central Supply')
                        {{(float)$cart_data->qty*(float)CustomHelpers::get_rate_with_gst_first_stock($cart_data->list_id)}}
                      @else
                       0
                      @endif
                     

                      </td>
                      
                    </tr>
                    <?php
                    if($cart_data->purchase_from=='Central Supply'):
                    $total=$total+((float)$cart_data->qty*(float)CustomHelpers::get_rate_with_gst_first_stock($cart_data->list_id));
                  else:
                  $total_local=$total_local+((float)$cart_data->qty*(float)CustomHelpers::get_rate_with_gst_first_stock($cart_data->list_id));
                    endif;
                    ?>
        @endforeach

         @endforeach  
     <tr>
     <td></td>
     <td></td>
     <td>Local Purchase Rs <span id="total_local" style="font-weight: bold;">{{round($total_local)}}</span></td>
     <td></td>
     <td >Total Central Supply Rs <span id="total_central" style="font-weight: bold;">{{round($total)}}</span></td>
     <td>
    <!-- <form action="{{url('/Fanchise-Payment')}}" method="post"> 
      @csrf
   <button type="submit" class="btn btn-success">Pay Rs. <span style="font-weight: bold;" id="pay">{{round($total)}}</span></button>
     </form>  --> 

     <form action="{{url('/store_paytm')}}" method="post"> 
      @csrf
   <button type="submit" class="btn btn-success">Pay Rs. <span style="font-weight: bold;" id="pay">{{round($total)}}</span></button>
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
$("#total").html("hi")
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
         
         $("#total_central").html('').html(data.central)
         $("#total_local").html('').html(data.local)
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