
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
 <b>Invoice #{{$payment_details->id }}</b><br>
        <br>
        <b>Transaction ID:</b> {{$payment_details->transaction_id }}<br>
    
        <b>Date:</b>{{$data->created_at }}
       </td>
       </tr>

      </table>
    
 

  
                    <div class="media card-2">
                    <table class="table ">
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

                  <tr>
                      <td>
                        <div class="sq align-self-center "> 
            <?php  
            $image_data=DB::table('item_images')->where([['item_id','=',$data->product_id],['default','=',1],['image_type','=',1]])->first();
          if($image_data!='' && $image_data->thumb!=''):
            $path=url('public/uploads/item/thumb/'.$image_data->thumb);
                    $image = '<img src="'.$path.'" width="30">';
          else:
           $path = url('public/uploads/item/noimage.png');
                    $image = '<img src="'.$path.'" width="30">';
          endif;
          ?>
                            <img class="img-fluid my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0" src="{{$path}}" width="135" height="135" /> 

                        </div>
                      </td>
                      <td>{{$data->product_name}}</td>
                      <td>{{$data->product_rate}}   

                     </td>
                     
                   
                      <td>
                        @if($data->order_qty==$data->order_confirm_qty)
                        {{$data->order_qty}}
                        @else
                        Ordered QTY: {{$data->order_qty}} <br>
                        Dispatch QTY: {{$data->order_confirm_qty}} 
                        @endif
                      </td>
                       <td style="text-align: right;">

                      <table class="table borderless">
                    <tr>
                    <td>Cost({{$data->order_confirm_qty}}*{{$data->product_rate}})</td>
                    <td>Rs. {{$data->order_confirm_qty*$data->product_rate}}</td>
                    </tr>
                     <tr>
                   <td>GST {{$data->gst_id}}%({{$data->order_confirm_qty}}*{{$data->product_rate*$data->gst_id/100}})</td>
                      <td>Rs. {{$data->order_confirm_qty*$data->product_rate*$data->gst_id/100}}</td>
                    </tr>
                     <tr>
                     <td>Transport Charge({{$data->order_confirm_qty}}*{{$data->transport_rate}})</td>
                      <td>Rs. {{$data->order_confirm_qty*$data->transport_rate}}</td>
                    </tr>
                      <tr>
                   <td>Total</td>
                      <td>
                        
                        Rs. {{$data->order_confirm_qty*$data->product_rate+$data->order_confirm_qty*$data->product_rate*$data->gst_id/100+$data->transport_rate}}</td>
                     
                    </tr>
                      </table>
                       </td>
                      
                    </tr>
                 
                    
                       
                    </tbody>

                    </table>
</div>
<?php 
$total=$data->amount;
?>

   











    </div> 

   </div>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>