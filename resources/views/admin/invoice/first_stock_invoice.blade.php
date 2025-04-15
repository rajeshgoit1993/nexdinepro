<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
   <div class="container-fluid">
    <div class="row">
    <div class="col-lg-12">
      <table class="table">
       <tr>
      <td>
        From
        <address>
          <strong>Skyland Group</strong><br>
          795 Folsom Ave, Suite 600<br>
          San Francisco, CA 94107<br>
          Phone: (804) 123-5432<br>
          Email: info@almasaeedstudio.com
        </address>
      </td>
       <td>
 To
        <address>
          <strong>{{$fanchise_detail->name}}</strong><br>
         {{$fanchise_detail->address}}<br>
         {{$fanchise_detail->state}}<br>
         {{$fanchise_detail->dist}}<br>
          {{$fanchise_detail->city}}<br>
          Email: {{$fanchise_detail->email }}<br>
          Mobile: {{$fanchise_detail->mobile }}
        </address>
       </td>

       <td>
 <b>Invoice #007612</b><br>
        <br>
        <b>Transaction ID:</b> {{$payment_datas->transaction_id }}<br>
        <b>Amount:</b>{{$payment_datas->amount }}<br>
        <b>Date:</b>{{$payment_datas->created_at }}
       </td>
       </tr>

      </table>
    
    <table class="table table-striped">
                <thead>
                <tr>
                      <th>Image</th>
                      <th>Product</th>
                      <th>Rate</th>
                      <th>GST</th>
                      <th>Qty</th>
                    
                      <th>GST Subtotal</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                  <?php 
                   $products= unserialize($data->cart_item_id);
                $total_gst=0;
                $total_normal=0;
                    ?>
        @foreach($products as $product)
           <?php  
            $image_data=DB::table('item_images')->where([['item_id','=',$product['product_id']],['default','=',1]])->first();
          if($image_data!='' && $image_data->thumb!=''):
            $path=url('public/uploads/item/thumb/'.$image_data->thumb);
                    $image = '<img src="'.$path.'" width="30">';
          else:
           $path = url('public/uploads/item/noimage.png');
                    $image = '<img src="'.$path.'" width="30">';
          endif;
          ?>
        <tr>
                      <td>{!! $image  !!}</td>
                     <td>{{ $product['product_name']  }}</td>
      <td>{{ $product['product_rate']  }}</td>
     <td>{{ $product['product_gst']  }}%</td>
       <td>{{ $product['qty']  }}</td>
       <td>
<?php  
$rate=$product['product_rate'];
$gst=$product['product_gst'];
if($rate=='')
{
  $rate=0;  
}

$gst_value=$rate*$gst/100;

if($gst_value=='')
{
  $gst_value=0;  
}
$gst_value=$gst_value*$product['qty'];

$normal_price=$rate*$product['qty'];
$total_gst+=$gst_value;
$total_normal+=$normal_price;
?>
Rs. {{ $gst_value }}
       </td>
       <td>
Rs. {{$normal_price}}

       </td>
     

              </tr>
        @endforeach

    <tr>
                <td colspan="6"></td>
                <td>Total: Rs. {{$total_normal}}</td>

              </tr>
               <tr>
                <td colspan="6"></td>

                <td >Gst: Rs. {{$total_gst}}</td>

              </tr>
                <tr>
                <td colspan="6"></td>

                <td colspan="1">Total : Rs. {{$total_gst+$total_normal}}</td>

              </tr>
    </tbody>
                </table>

    
   











    </div> 

   </div>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>