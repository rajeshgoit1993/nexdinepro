<style type="text/css">
/*    body {
min-height: 100vh;
background-size: cover;
font-family: 'Lato', sans-serif;
color: rgba(116, 116, 116, 0.667);
background: linear-gradient(140deg, #fff, 50%, #BA68C8)
}*/
/*.container-fluid {
margin-top: 200px
}*/
/*p {
font-size: 14px;
margin-bottom: 7px
}*/
.small {
letter-spacing: 0.5px !important
}
.card-1 {
box-shadow: 2px 2px 10px 0px rgb(190, 108, 170)
}
hr {
background-color: rgba(248, 248, 248, 0.667)
}
.bold {
font-weight: 500
}
.change-color {
color: #AB47BC !important
}
.card-2 {
box-shadow: 1px 1px 3px 0px rgb(112, 115, 139)
}
.fa-circle.active {
font-size: 8px;
color: #AB47BC
}
.fa-circle {
font-size: 8px;
color: #aaa
}
.rounded {
border-radius: 2.25rem !important
}
.progress-bar {
background-color: #AB47BC !important
}
.progress {
height: 5px !important;
margin-bottom: 0
}
.invoice {
position: relative;
top: -70px
}
.Glasses {
position: relative;
top: -12px !important
}
.card-footer {
background-color: #AB47BC;
color: #fff
}
h2 {
color: rgb(78, 0, 92);
letter-spacing: 2px !important
}
.display-3 {
font-weight: 500 !important
}
@media (max-width: 479px) {
.invoice {
position: relative;
top: 7px
}
.border-line {
border-right: 0px solid rgb(226, 206, 226) !important
}
}
@media (max-width: 700px) {
h2 {
color: rgb(78, 0, 92);
font-size: 17px
}
.display-3 {
font-size: 28px;
font-weight: 500 !important
}
}
.card-footer small {
letter-spacing: 7px !important;
font-size: 12px
}
.border-line {
border-right: 1px solid rgb(226, 206, 226)
}
.borderless td, .borderless th {
    border: none;
}
</style>


<div class="justify-content-center">
<div class="">

<div class="card-body">
<div class="row justify-content-between mb-3">
<div class="col-auto">
<h6 class="color-1 mb-0 change-color">Receipt</h6>
</div>
<div class="col-auto "> <small>Order No : {{$data->order_no}}</small> </div>
</div>

<?php 
$details_orders=DB::table('order_item_details')->where('order_id','=',$data->id)->whereIn('status',[2,4,6])->get();
$total=0;
?>
  <form onsubmit="save_status(new FormData(this)); return false;" class="change_order_status" name="change_order_status">
<!--     <form action="{{url('/save_collection_details')}}" method="post"> -->
    {!! csrf_field() !!}
            
             <div class="media card-2">
                    <table class="table ">
                     <thead>
                     <tr>
                      <th>Select</th>
                      <th>Image</th>
                      <th>Product</th>
                      <th>Rate</th>
                     <th>Qty</th>
                   
                      <th style="text-align:right;">Subtotal</th>
                    </tr>
                    </thead>
                       <tbody>

                    @foreach($details_orders as $orders)
                   

                  <tr>
                    <td><input type="checkbox"  name="order_id[]" value="{{CustomHelpers::custom_encrypt($orders->id)}}"></td>
                      <td>
                        <div class="sq align-self-center "> 
            <?php  
            $image_data=DB::table('item_images')->where([['item_id','=',$orders->product_id],['default','=',1],['image_type','=',1]])->first();
          if($image_data!='' && $image_data->thumb!=''):
            $path=url('public/uploads/item/thumb/'.$image_data->thumb);
                    $image = '<img src="'.$path.'" width="30">';
          else:
           $path = url('public/uploads/item/noimage.png');
                    $image = '<img src="'.$path.'" width="30">';
          endif;
          ?>
                            <img class="img-fluid my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0" src="{{$path}}" width="40" height="40" /> 

                        </div>
                      </td>
                      <td>{{$orders->product_name}}</td>
                      <td>{{$orders->product_rate}}   

                        <a href="{{url('Product-Invoice/'.CustomHelpers::custom_encrypt($orders->id))}}" class="" style="display:block;">Invoice</a></td>
                     
                   
                      <td> @if($orders->order_qty==$orders->order_confirm_qty)
                        {{$orders->order_qty}}
                        @else
                        Ordered QTY: {{$orders->order_qty}} <br>
                        Dispatch QTY: {{$orders->order_confirm_qty}} 
                        @endif</td>
                       <td style="text-align: right;">

                      <table class="table borderless">
                    <tr>
                    <td>Cost({{$orders->order_confirm_qty}}*{{$orders->product_rate}}) <br>
                       @if($data->gst_type==1)

  I-GST {{$orders->gst_id}}%({{$orders->order_qty}}*{{$orders->product_rate*$orders->gst_id/100}})
                 
                      @else
C-GST {{$orders->gst_id/2}}%({{$orders->order_qty}}*{{$orders->product_rate*$orders->gst_id/200}})
     <br>
S-GST {{$orders->gst_id/2}}%({{$orders->order_qty}}*{{$orders->product_rate*$orders->gst_id/200}})
                
                      @endif
                    <br>
                    Transport Charge({{$orders->order_qty}}*{{$orders->transport_rate}})
                    <br>
                    Total
                    </td>
                    <td>Rs. {{$orders->order_confirm_qty*$orders->product_rate}} <br>
                       @if($data->gst_type==1)
Rs. {{$orders->order_qty*$orders->product_rate*$orders->gst_id/100}}
                      @else
Rs. {{$orders->order_qty*$orders->product_rate*$orders->gst_id/200}}
     <br>
Rs. {{$orders->order_qty*$orders->product_rate*$orders->gst_id/200}}
<br>
      Rs. {{$orders->order_qty*$orders->transport_rate}}            
                      @endif
  <br>
   Rs. {{$orders->amount}}

                    </td>
                    </tr>
                    
                   
                  
                      </table>
                       </td>
                      
                    </tr>
                   <tr>
                  <td colspan="5" style="border-style: none;padding: 0px ;">
                  

    <?php 
     $status=$orders->status;
    ?>
     




                

    
  </td>
                   </tr>
                    
                       
                    
<?php 
$total=$total+$orders->amount;
?>
    @endforeach

</tbody>

                    </table>
</div>

      <div class="add_dynamic_form">
         <div class="col-md-12">
     <div class="form-group">
          <label for="">Delivered Date</label>
          <input type="date" name="dilivered_date" class="form-control" placeholder="Delivered Date" value="" required>
         
        </div>
 </div><div class="col-md-12">
     <div class="form-group">
          <label for="">Delivered Remarks</label>
           <textarea name="dilivered_remarks" value="" class="form-control" placeholder="  Remarks"></textarea>
         
        </div>
 </div>
  </div>
  <button type="submit"  class="btn btn-info btn-lg">Save</button>
  </form> 











<div class="row ">
<div class="col">
<p class="mb-1 mt-4"> Order Number : {{$data->order_no}}</p>
<p class="mb-1">Invoice Date : {{$data->created_at}}</p>

</div>
</div>
</div>

</div>
</div> 