@foreach($category_data as $row=>$col)


  <div class="col-lg-12">
<h4 style="display:block;">{{$row}}</h4>
</div>
@foreach($col as $second_col)

<div class="col-lg-3">
 <div class="card" style="height:250px;padding: 0px 20px;">
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
 <p style="text-align:center;line-height: 1">Rs.{{CustomHelpers::get_rate_with_gst_first_stock($second_col->id)}}/{{CustomHelpers::get_master_table_data('units','id',$second_col->unit,'unit')}}</p>
 <div class="number" style="line-height: 1;">
  <span class="minus" fanchise_id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}" list_id="{{CustomHelpers::custom_encrypt($second_col->id)}}">-</span>
  <input type="text" class="count" value="{{CustomHelpers::get_first_time_cart_data($fanchise_detail->id,$second_col->id,'qty')}}"/>
  <span class="plus" fanchise_id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}" list_id="{{CustomHelpers::custom_encrypt($second_col->id)}}">+</span>
</div>
 </div>
</div>
@endforeach


@endforeach