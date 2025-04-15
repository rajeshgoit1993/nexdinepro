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
  <input type="text" class="count" value="{{$check_cart->qty}}"/>
  <span class="plus" cart_id="{{CustomHelpers::custom_encrypt($check_cart->id)}}">+</span>
  </div>
@endif
 </div>
</div>
@endforeach
@endforeach