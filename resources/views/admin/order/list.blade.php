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
  <div class="flex-item-left"><h5>Supply Item List</h5></div>

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

  <div style="padding: 0px 10px;">

<!-- <h5>Procurement-Actions</h5> -->
   


 {!! Form::open(["files"=>true,'id'=>"registration_form","name"=>"registration_form"])!!}
 

<div class="row">

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
    <!-- <style type="text/css">
  .count {
    disabled: true; 
  }
</style> -->
<!---->
<div class="col-lg-12">

<button class="btn btn-default filter" id="all" >All</button>
@foreach($data as $row=>$col)
<button class="btn btn-primary filter" id="{{$row}}">{{$row}}</button>
@endforeach
</div>

 <div class="col-lg-12">
  <div class="row dynamic_data">

  
@foreach($data as $row=>$col)
 <div class="col-lg-12">
<h4 style="display:block;">{{$row}}</h4>
</div>
@foreach($col as $second_col)
<div class="col-lg-3">
 <div class="card" style="height:270px;padding: 0px 20px;">
  <div style="text-align:center;">
<?php 
 $image_data=DB::table('item_images')->where([['item_id','=',$second_col->id],['default','=',1]])->first();
  if($image_data!='' && $image_data->thumb!=''):
    $path=url('public/uploads/item/thumb/'.$image_data->thumb);
      $image = '<img src="'.$path.'" width="100px">';
  else:
  $path=url('public/uploads/item/noimage.png');
      $image = '<img src="'.$path.'" width="100px">';
  endif;
  echo $image;
?>
  </div>
 <p style="text-align:center;line-height: 1">{{$second_col->product_name}}</p>
 <p style="text-align:center;line-height: 1">Rate: Rs.{{CustomHelpers::get_rate_with_gst($second_col->id)}}/
  {{CustomHelpers::get_master_table_data('units','id',$second_col->unit,'unit')}} 
</p>
 <p style="text-align:center;line-height: 1">Shipping Fee: Rs.{{CustomHelpers::get_transport_fee(Sentinel::getUser()->id,$second_col->unit)}}/
  {{CustomHelpers::get_master_table_data('units','id',$second_col->unit,'unit')}} 
</p>
<?php  

$fanchise_id=Sentinel::getUser()->id;
$check_cart=DB::table('supply_carts')->where([['fanchise_id','=',$fanchise_id],['item_id','=',$second_col->id]])->first();
?>
@if($check_cart=='')
<div class="cart" style="text-align:center;">
<button class="btn btn-success add_to_cart" item_id="{{CustomHelpers::custom_encrypt($second_col->id)}}">Add</button>
</div>
 <div class="number" style="line-height: 1;">
  </div>
@else
<div class="cart" style="text-align:center;">

</div>
 <div class="number" style="line-height: 1;">
<span class="minus"  cart_id="{{CustomHelpers::custom_encrypt($check_cart->id)}}">-</span>
  <input type="text" class="count" @if($check_cart->qty>0) @else <style type="text/css">
  .count {
    disabled: true; 
  }
</style>  @endif value="{{$check_cart->qty}}"/>
  <span class="plus" cart_id="{{CustomHelpers::custom_encrypt($check_cart->id)}}">+</span>
  </div>
@endif
 </div>
</div>
@endforeach
@endforeach

</div>
</div>




 
 
  </div>
<br>


  {!! Form::close() !!}    
  </div>
<!---->
</div>
</section>

</div>

</div>



<style type="text/css">
  .badge {
  padding-left: 15px;
  padding-right: 15px;
  -webkit-border-radius: 15px;
  -moz-border-radius: 15px;
  border-radius: 15px;
}

.label-warning[href],
.badge-warning[href] {
  background-color: #c67605;
}
#lblCartCount {
    font-size: 20px;
    background: #ff0000;
    color: #fff;
    padding: 0 10px;
    vertical-align: top;
    margin-left: -10px; 
}
</style>
<div class="cart" style="    position: fixed;
    right: 50px;
    bottom: 30px;
    display: block;">

<i class="fa" style="font-size:50px">&#xf07a;</i>
<span class='badge badge-warning' id='lblCartCount'> 
<?php  

$fanchise_id=Sentinel::getUser()->id;
$cart=DB::table('supply_carts')->where('fanchise_id','=',$fanchise_id)->get();
?>
@if(count($cart)>0)
{{ count($cart) }}
@else
0
@endif
</span>
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


<script type="text/javascript">
  //

   //

     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


          //
    $(document).on("click",".filter",function(e){
     e.preventDefault()
     $("#overlay").fadeIn(300);
      $(".filter").each(function(){
      if($(this).hasClass("btn-default"))
      {
        $(this).removeClass("btn-default")
         $(this).addClass("btn-primary")
      }
      });
      $(this).removeClass("btn-primary")
      $(this).addClass("btn-default")
       var value=$(this).attr('id')
       var APP_URL=$("#APP_URL").val();
    
  $.ajax({
        url:APP_URL+'/get_supply_filter_data',
        data:{value:value},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
         $("#overlay").fadeOut(300); 
          $(".dynamic_data").html('').html(data)
          // $('.count').prop('disabled', true);
        },
        error:function(data)
        {

        }
    })


    })
  //

  //

  $(document).on("click","#lblCartCount",function(){
 
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Order-Placed";
     var element2 = document.createElement("INPUT");         
    element2.name="_token"
    element2.value = $('meta[name="csrf-token"]').attr('content')
    element2.type = 'hidden'
    form.appendChild(element2);

    form.submit();

  })

    //add_to_cart
$(document).on("click",".add_to_cart",function(e){
  e.preventDefault();
  
 var APP_URL=$("#APP_URL").val();
 var item_id=$(this).attr('item_id')
 var current=$(this)
   $.ajax({
        url:APP_URL+'/add_to_cart',
        data:{item_id:item_id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
         current.css('display','none')
         current.parent().siblings('.number').html(data.button)
         $('#lblCartCount').html('').html(data.count)
         // $('.count').prop('disabled', true);
        },
        error:function(data)
        {

        }
    })

})
  //
$(document).on("click","#lblCartCount",function(){
 
   //
      
        var APP_URL=$("#APP_URL").val();
        var fanchise_id=$(this).attr('fanchise_id')
       
  $.ajax({
        url:APP_URL+'/get_cart_data',
        data:{fanchise_id:fanchise_id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
          $(".cart_data_value").html('').html(data)
         $('#cart_data').modal('toggle');
        },
        error:function(data)
        {

        }
    })
    //


})
//

$(document).on("click",".submit_cart",function(e){
  e.preventDefault();
 var APP_URL=$("#APP_URL").val();
 var fanchise_id=$(this).attr('fanchise_id')
  $.ajax({
        url:APP_URL+'/submit_cart_by_company',
        data:{fanchise_id:fanchise_id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
          swal("Done !", 'Successfully Sended First Time Stock List', "success");
      
         var url=APP_URL+'/Ongoing-Request';
        window.location.href = url;
     
        },
        error:function(data)
        {

        }
    })

})

//
     $(document).on("keyup change",".count",function(){
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    var count_value=$(this).val();
     if(count_value>=1)
     {
      
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
current.parent().siblings('.cart').html('').html(data.button)
current.parent().html('')
          }
          $("#lblCartCount").html('').html(data.count) 
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
current.parent().siblings('.cart').html('').html(data.button)
current.parent().html('')
          }
          $("#lblCartCount").html('').html(data.count)
        },
        error:function(data)
        {

        }
    })
    //
        return false;
      });
      $(document).on('click','.plus',function(){
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

  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
       
       
       
    });
    
  });
</script>

@endsection