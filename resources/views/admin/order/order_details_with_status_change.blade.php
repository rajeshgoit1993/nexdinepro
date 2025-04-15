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
<div class="col-auto "> <small>Order No : {{$data->id}}</small> </div>
</div>

<?php 
$details_orders=DB::table('order_item_details')->where('order_id','=',$data->id)->get();
$total=0;
?>

                    @foreach($details_orders as $orders)
                    <div class="media card-2">
                    <table class="table ">
                     <thead>
                     <tr>

                      <th>Image</th>
                      <th>Product</th>
                      <th>Rate</th>
                     <th>Qty</th>
                   
                      <th style="text-align:right;">Subtotal</th>
                    </tr>
                    </thead>
                       <tbody>

                  <tr>
                      <td>
                        <div class="sq align-self-center "> 
            <?php  
            $image_data=DB::table('item_images')->where([['item_id','=',$orders->product_id],['default','=',1]])->first();
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
                        @endif
                    </td>
                       <td style="text-align: right;">

                      <table class="table borderless">
                    <tr>
                    <td style="padding-top: 0px;padding-bottom: 0px;">Cost({{$orders->order_qty}}*{{$orders->product_rate}})</td>
                    <td style="padding-top: 0px;padding-bottom: 0px;">Rs. {{$orders->order_qty*$orders->product_rate}}</td>
                    </tr>
                     <tr>
                    @if($data->gst_type==1)
<td style="padding-top: 0px;padding-bottom: 0px;">
  I-GST {{$orders->gst_id}}%({{$orders->order_qty}}*{{$orders->product_rate*$orders->gst_id/100}})
                  </td>
                      @else
<td style="padding-top: 0px;padding-bottom: 0px;">C-GST {{$orders->gst_id/2}}%({{$orders->order_qty}}*{{$orders->product_rate*$orders->gst_id/200}})
     <br>
S-GST {{$orders->gst_id/2}}%({{$orders->order_qty}}*{{$orders->product_rate*$orders->gst_id/200}})
                  </td>
                      @endif
                     @if($data->gst_type==1)
 <td style="padding-top: 0px;padding-bottom: 0px;">Rs. {{$orders->order_qty*$orders->product_rate*$orders->gst_id/100}}</td>
                      @else
<td style="padding-top: 0px;padding-bottom: 0px;">Rs. {{$orders->order_qty*$orders->product_rate*$orders->gst_id/200}}
     <br>
Rs. {{$orders->order_qty*$orders->product_rate*$orders->gst_id/200}}
                  </td>
                      @endif
                    </tr>
                     <tr>
                     <td style="padding-top: 0px;padding-bottom: 0px;">Transport Charge({{$orders->order_qty}}*{{$orders->transport_rate}})</td>
                      <td style="padding-top: 0px;padding-bottom: 0px;">Rs. {{$orders->order_qty*$orders->transport_rate}}</td>
                    </tr>
                      <tr>
                   <td>Total</td>
                      <td>
                        Rs. {{$orders->amount}}

            
                      </td>
                    </tr>
                      </table>
                       </td>
                      
                    </tr>
                   <tr>
                  <td colspan="5" style="border-style: none;padding: 0px ;">
                    <hr style="margin:0px">

  <form onsubmit="save_status(new FormData(this),$(this)); return false;" class="change_order_status" name="change_order_status">
    {!! csrf_field() !!}
    <?php 
     $status=$orders->status;
    ?>

     
        <div class="col-md-12">
          <i>
            Last Status: 
           @if($orders->status==2 || $orders->status==4 || $orders->status==6)
           Dispatch, {{$orders->dispatch_date}}, {{$orders->courier_name}}
           @elseif($orders->status==3)
           Assign to factory
           @elseif($orders->status==1)
           Payment Confirmed
           @elseif($orders->status==5)
           Assign to vendor
           @elseif($orders->status==7)
           Delivered, {{$orders->dilivered_date}}  
           @endif
          </i>
     <div class="form-group" >
          <label for="">Change Status</label>
          <input type="hidden" name="order_id" class="order_id" value="{{CustomHelpers::custom_encrypt($orders->id)}}">
         <select class="form-control status_order_change" name="status" required> 
           <option value="">--Select Status--</option>
           @if($orders->status==1 || $orders->status==3 || $orders->status==5)
           <option value="2" @if($orders->status==2 || $orders->status==4 || $orders->status==6) selected @endif>Dispatch</option>
           <option value="3" @if($orders->status==3) selected @endif>Assign to factory</option>
           <option value="5" @if($orders->status==5) selected @endif>Assign to vendor</option>
          @else
           <option value="7" @if($orders->status==7) selected @endif>Delivered</option>
          @endif
         </select>
      
        </div>
 </div>
 @if($status==2)
<!--   <div class="add_dynamic_form">


        <div class="col-md-12">
     <div class="form-group">
          <label for="">Dispatch Date</label>
          <input type="date" name="dispatch_date" class="form-control" placeholder="Dispatch Date" value="{{$orders->dispatch_date}}" required >
         
        </div>
 </div>
 <div class="col-md-12">
     <div class="form-group">
          <label for="" required>Courier Name</label>
          <input type="text" name="courier_name" class="form-control" placeholder="Courier Name" value="{{$orders->courier_name}}" required>
         
        </div>
 </div>
  </div> -->
<!--   <div class="add_dynamic_form">
         <div class="col-md-12">
     <div class="form-group">
          <label for="">Delivered Date</label>
          <input type="date" name="dilivered_date" class="form-control" placeholder="Delivered Date" value="{{$orders->dilivered_date}}" required>
         
        </div>
 </div><div class="col-md-12">
     <div class="form-group">
          <label for="">Delivered Remarks</label>
           <textarea name="dilivered_remarks" value="{{$orders->dilivered_remarks}}" class="form-control" placeholder="  Remarks"></textarea>
         
        </div>
 </div>
  </div> -->
    <div class="add_dynamic_form">
                
  </div>
      @elseif($status==3)
      <div class="add_dynamic_form">
     <div class="col-md-12">
     <div class="form-group">
          <label for="">Select Factory</label>
           <select class="form-control" name="factory_vendor_id" required> 
           <option value="">--Select Factory--</option>
         
      <?php 
      $factory = DB::table('assign_product_factory_vendors')->where([['product_id','=',$orders->product_id],['type','=','factory']])->get();
      ?>
      @foreach($factory as $fac)
       <?php 
        $factory_name=CustomHelpers::get_master_table_data('stores','id',$fac->factory_vendor_id,'name');

        ?>
        <option value="{{$fac->factory_vendor_id}}" @if($orders->factory_vendor_id==$fac->factory_vendor_id) selected @endif>{{$factory_name}}</option> 
      @endforeach
    
   </select> </div>
 </div>
  </div>
      @elseif($status==5)
      <div class="add_dynamic_form">
       <div class="col-md-12">
     <div class="form-group">
          <label for="">Select Vendor</label>
           <select class="form-control" name="factory_vendor_id" required> 
           <option value="">--Select Vendor--</option>
        <?php 
      $factory =DB::table('assign_product_factory_vendors')->where([['product_id','=',$orders->product_id],['type','=','vendor']])->get();
       ?>
      @foreach($factory as $fac)
       <?php 
        $factory_name=CustomHelpers::get_master_table_data('users','id',$data->factory_vendor_id,'name');
        ?>
 <option value="{{$fac->factory_vendor_id}}" @if($orders->factory_vendor_id==$fac->factory_vendor_id) selected @endif>{{$factory_name}}</option>
          @endforeach
</select> </div>
 </div>
  </div>
      @elseif($status==7)
      <div class="add_dynamic_form">
         <div class="col-md-12">
     <div class="form-group">
          <label for="">Delivered Date</label>
          <input type="date" name="dilivered_date" class="form-control" placeholder="Delivered Date" value="{{$orders->dilivered_date}}" required>
         
        </div>
 </div><div class="col-md-12">
     <div class="form-group">
          <label for="">Delivered Remarks</label>
           <textarea name="dilivered_remarks" value="{{$orders->dilivered_remarks}}" class="form-control" placeholder="  Remarks"></textarea>
         
        </div>
 </div>
  </div>
   @else
   <div class="add_dynamic_form">
                
  </div>
    @endif


  @if($status<7)
  <button type="submit"  class="btn btn-info btn-sm ml-2" >Save</button>
  @endif
  </form>     
  </td>
                   </tr>
                    
                       
                    </tbody>

                    </table>
</div>
<?php 
$total=$total+$orders->amount;
?>
    @endforeach
 












<div class="row ">
<div class="col">
<p class="mb-1 mt-4"> Order Number : {{$data->order_no}}</p>
<p class="mb-1">Invoice Date : {{$data->created_at}}</p>

</div>
</div>
</div>
<div class="card-footer">
<div class="jumbotron-fluid">
<div class="row justify-content-between ">
<div class="col-sm-auto col-auto my-auto"><!-- <img class="img-fluid my-auto align-self-center " src="https://i.imgur.com/7q7gIzR.png" width="115" height="115"> --></div>
<div class="col-auto my-auto ">
<h2 class="mb-0 font-weight-bold">TOTAL PAID</h2>
</div>
<div class="col-auto my-auto ml-auto">
<h1 class="display-3 ">&#8377; {{$total}}</h1>
</div>
</div>
<!-- <div class="row mb-3 mt-3 mt-md-0">
<div class="col-auto border-line"> <small class="text-white">PAN:AA02hDW7E</small></div>
<div class="col-auto border-line"> <small class="text-white">CIN:UMMC20PTC </small></div>
<div class="col-auto "><small class="text-white">GSTN:268FD07EXX </small> </div>
</div> -->
</div>
</div>
</div>
</div> 