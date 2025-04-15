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
<!---->
<input type="hidden" id="level" name="level" value="3">
<div class="col-lg-12">

<button class="btn btn-default filter" id="all" fanchise_id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}" brand_id="{{$registered_fanchise->brands}}">All</button>
@foreach($category_data as $row=>$col)
<button class="btn btn-primary filter" id="{{$row}}" brand_id="{{$registered_fanchise->brands}}" fanchise_id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}">{{$row}}</button>
@endforeach
</div>
<div class="utensil_list">
  <div class="row dynamic_data">
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
</div>
</div>