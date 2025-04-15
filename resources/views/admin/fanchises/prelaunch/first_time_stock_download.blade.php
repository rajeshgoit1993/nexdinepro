<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>First Time Stock</title>
</head>
<body>
 <table class="table table-striped">
                <thead>
                <tr>
                     
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
  
    </tbody>
                </table>
</body>
</html>