<!DOCTYPE html>
<html>
    <head>
        <title>Sale Report</title>
        <style>
            table, th, td {
                border: 1px solid black;
               padding: 2px;
                outline: none;
               border-collapse: collapse;
               font-size: 12px;
            }
           
        </style>
        <style>
.page-break {
    page-break-after: always;
}
</style>
    </head>
    <body>
       
    <h5 style="text-align:center;">Sale Report</h5>
      
     <!---->
     <table class="table">
         <tr>
             <td>From Date</td>

             <td>{{$from}}</td>
              <td>Till Date</td>
               <td>{{$to}}</td>
         </tr>
           <tr>
             <?php  

$logo_path=CustomHelpers::logo_path($outlet_id);
$outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);

                      ?>
                      
             <td colspan="2">Outlet Name</td>
            <td colspan="2"><?php echo $outlet_details->firm_name; ?></td>
            
         </tr>
     </table>
     <br>
      <table style="width:100%;"cellspacing="0">
     
        <tr>
    <th>S.No.</th>
    <th>Code</th>
    <th>Food Menu(Code)</th>
  <th>Quantity</th>
   <th>Rate</th>
   <th>Total Amount</th>
  </tr>
     <?php 
$a=1;
$total=0;
$sale_discount=0;
$gsts=0;
$charge=0;
$round_off=0;
$sale_datas=DB::table('franchise_sales')->where([['outlet_id',$outlet_id],['del_status', 'Live'],['.order_status',3]])
            ->whereBetween('franchise_sales.sale_date', [$from, $to])->get();
            foreach($sale_datas as $sale_data)
            {
        if($sale_data->total_discount_amount!='' && $sale_data->total_discount_amount!=0):
$sale_discount=$sale_discount+$sale_data->total_discount_amount;   
         endif; 
          if($sale_data->gst!='' && $sale_data->gst!=0):
$gsts=$gsts+$sale_data->gst;   
         endif;  

if($sale_data->delivery_charge && $sale_data->delivery_charge!="0.00" && $sale_data->delivery_charge!="0.00" && $sale_data->delivery_charge!="0%"):

      $charge=$charge+POS_SettingHelpers::get_charge_value($sale_data->delivery_charge,($sale_data->sub_total+$sale_data->total_item_discount_amount),$sale_data->total_discount_amount); 

endif;
$round_amount=$sale_data->paid_amount-$sale_data->total_payable;
if($round_amount!=0):
$round_off=$round_off+($round_amount);
endif;
}
     ?>   
  @foreach($data as $d)

<tr>
  <td>{{$a++}}</td>
    
  <td>{{$d[0]->code}}</td>
  <td>{{$d[0]->menu_name}}</td>
  <td>
    <?php 
 
$qty=0;
$actual_total=0;
$rate_array=[];
foreach($d as $c)
{
$qty=(int)$qty+(int)$c->qty;
$rate=DB::table('franchise_sales_details')->where('id',$c->franchise_sales_details_id)->first();
$item_rate=$rate->menu_unit_price;
$rate_array[]=$item_rate;
$actual_total=$actual_total+(int)$c->qty*$rate->menu_unit_price;
}

   ?>{{$qty}}</td>
  <td>
    <?php
$food_menu_id=$d[0]->food_menu_id;


$total=$total+$actual_total;



     ?>
     @if(count(array_unique($rate_array))>1)
<span style="background:red">{{$rate->menu_unit_price}} <span> Price change {{count(array_unique($rate_array))-1}} times between date range </span></span>
     @else
{{$rate->menu_unit_price}}
     @endif
  
 </td>
   <td>Rs. {{$actual_total}}</td>
  
</tr>

  @endforeach

  <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>Total</td>
      <td>Rs. {{$total}}</td>
  </tr>
   <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>GST</td>
      <td>Rs. {{$gsts}}</td>
  </tr>
   <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>Total Discount</td>
      <td>Rs. -{{$sale_discount}}</td>
  </tr>
   <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>Service/Delivery Charge</td>
      <td>Rs. {{$charge}}</td>
  </tr>
   <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>Round off</td>
      <td>Rs. {{number_format((float)($round_off),2, '.', '')}}</td>
  </tr>
   <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>Grand Total</td>
      <td>Rs. {{$total+$gsts-$sale_discount+$charge+($round_off)}}</td>
  </tr>
        </table>
    </body>
</html>                    