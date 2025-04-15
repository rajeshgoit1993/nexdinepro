<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

   <title>DSR MTD Report</title>
        <style>
            table, th, td {
                border: 1px solid black;
               padding: 2px;
                outline: none;
               border-collapse: collapse;
               font-size: 11px;
            }
           .table td, .table th
           {
            padding: 2px !important;
           }
        </style>
        <style>
.page-break {
    page-break-after: always;
}
.header_report
{
    text-align: center;
}
</style>
  </head>
  <body>
    <div >
      <div>
      <div>
        
@if(count($data)>0)
        <?php  


$total_gross_amount=0;
$total_discount_amount=0;
$total_discount_subtotal=0;
$total_gst=0;
$persons=0;
$items=0;
$refund=0;
$charge=0;
$complementry_order=0;
$complementry_discount=0;
$delivery=0;
$dine_in=0;
$takeaway=0;
$delivery_sale=0;
$dine_in_sale=0;
$takeaway_sale=0;
$a=1;
$opening_bill_no=0;
$closing_bill_no=0;
$round_off=0;
foreach($data as $d)
{
  if($a==1)
  {
    $opening_bill_no=$d->invoice_number;
  }
  $closing_bill_no=$d->invoice_number;
  $a++;
// $total_gross_amount=$total_gross_amount+$d->sub_total+$d->total_item_discount_amount;
$total_gross_amount=$total_gross_amount+$d->sub_total+$d->total_item_discount_amount;

if($d->delivery_charge && $d->delivery_charge!="0.00" && $d->delivery_charge!="0.00" && $d->delivery_charge!="0%" && $d->order_type==1 && $d->charge_type=='service'):

  $charge=$charge+POS_SettingHelpers::get_charge_value($d->delivery_charge,$total_gross_amount,$d->total_discount_amount);  
elseif($d->delivery_charge && $d->delivery_charge!="0.00" && $d->delivery_charge!="0.00" && $d->delivery_charge!="0%" && $d->order_type==3 && $d->charge_type=='delivery'):
  
$charge=$charge+POS_SettingHelpers::get_charge_value($d->delivery_charge,$total_gross_amount,$d->total_discount_amount);
endif;

$round_amount=$d->paid_amount-$d->total_payable;

if($round_amount!=0):
$round_off=$round_off+($round_amount);
endif;

$total_discount_amount=$total_discount_amount+$d->total_item_discount_amount;
$total_discount_subtotal=$total_discount_subtotal+$d->sub_total_discount_amount;
$total_gst=$total_gst+$d->gst;
$items=$items+$d->total_items;
if($d->order_type==1)
{
$dine_in=$dine_in+1;
if($d->delivery_charge && $d->delivery_charge!="0.00" && $d->delivery_charge!="0.00" && $d->delivery_charge!="0%"):
$dine_in_sale=$dine_in_sale+$d->sub_total-$d->sub_total_discount_amount+POS_SettingHelpers::get_charge_value($d->delivery_charge,($d->sub_total+$d->total_item_discount_amount),$d->total_discount_amount);

else:
$dine_in_sale=$dine_in_sale+$d->sub_total-$d->sub_total_discount_amount;
endif;


}
elseif($d->order_type==2)
{
 $takeaway=$takeaway+1; 
 if($d->delivery_charge && $d->delivery_charge!="0.00" && $d->delivery_charge!="0.00" && $d->delivery_charge!="0%"):
$takeaway_sale=$takeaway_sale+$d->sub_total-$d->sub_total_discount_amount+POS_SettingHelpers::get_charge_value($d->delivery_charge,($d->sub_total+$d->total_item_discount_amount),$d->total_discount_amount);

else:
$takeaway_sale=$takeaway_sale+$d->sub_total-$d->sub_total_discount_amount;
endif;

 
}
elseif($d->order_type==3)
{
 $delivery=$delivery+1; 
  if($d->delivery_charge && $d->delivery_charge!="0.00" && $d->delivery_charge!="0.00" && $d->delivery_charge!="0%"):
$delivery_sale=$delivery_sale+$d->sub_total-$d->sub_total_discount_amount+POS_SettingHelpers::get_charge_value($d->delivery_charge,($d->sub_total+$d->total_item_discount_amount),$d->total_discount_amount);

else:
$delivery_sale=$delivery_sale+$d->sub_total-$d->sub_total_discount_amount;
endif;


}
if($d->change_amount!='')
{
 $refund=$refund+1; 
}
if($d->total_payable=='' || $d->total_payable==0)
{
 $complementry_order=$complementry_order+1; 
 $complementry_sale_id=$d->id;
 $orders_com_details=DB::table('franchise_sales_details')->where('sales_id',$d->id)->get();
 foreach($orders_com_details as $orders_com)
 {
$complementry_discount=$complementry_discount+(int)$orders_com->qty*$orders_com->menu_unit_price;
 }
}
$person=DB::table('pos_order_tables')->where('sale_id',$d->id)->get();
$persons=$persons+count($person);
}
$total_gross_receipt=$total_gross_amount-$total_discount_amount-$total_discount_subtotal+$charge+$total_gst+($round_off);



$actual_sale=$total_gross_amount-$total_discount_amount-$total_discount_subtotal+$charge;
$franchise_payment_options=DB::table('outlet_payment_methods')->get();

                      ?>
    
      
    
      <div class="header_report">
          
     <h4 style="margin:0px;font-size:13px"><b>NexCen POS</b></h4>
         <p style="margin:0px;font-size:13px"><b>Combine Report {{$heading}}</b></p>          
      </div>

        <table class="table">
         <tr>
             <td>From Date</td>

             <td>{{$from}}</td>
              <td>Till Date</td>
               <td>{{$to}}</td>
         </tr>
       <!--     <tr>
             
                      
             <td >Opening Bill No.</td>
            <td ><?php echo $opening_bill_no; ?></td>
            <td >Closing Bill No.</td>
            <td ><?php echo $closing_bill_no; ?></td>
            
            
         </tr> -->
          
     </table>

     <table class="table">    
       <tr>
          <td>Gross Sales( Net Sales+ Incl. Discount+charge )</td>
          <td>{{number_format((float)($total_gross_amount+$charge),2, '.', '')}}</td>
      </tr>
      <tr>
          <td>Discount Amount</td>
          <td>{{number_format((float)($total_discount_amount+$total_discount_subtotal),2, '.', '')}} </td>
      </tr>
       <tr>
          <td>Net Sales</td>
          <td>{{number_format((float)($total_gross_amount+$charge-$total_discount_amount-$total_discount_subtotal),2, '.', '')}}</td>
      </tr>
       <tr>
          <td>Service/Delivery charge</td>
          <td>{{number_format((float)($charge),2, '.', '')}}</td>
      </tr>
     
      <tr>
          <td>Total Taxable Sales</td>
          <td>{{number_format((float)($total_gross_amount-$total_discount_amount-$total_discount_subtotal),2, '.', '')}}</td>
      </tr> 

     
      <tr>
          <td>C-GST Amount</td>
          <td>{{number_format((float)($total_gst/2),2, '.', '')}}</td>
      </tr>
      <tr>
          <td>S-GST Amount</td>
          <td>{{number_format((float)($total_gst/2),2, '.', '')}}</td>
      </tr>
      <tr>
          <td>Round off</td>
          <td>{{number_format((float)($round_off),2, '.', '')}}</td>
      </tr>
      <tr>
          <td>Total Gross Amount(total taxable sales + taxes + charge)</td>
          <td> {{number_format((float)($total_gross_amount-$total_discount_amount-$total_discount_subtotal+$total_gst+$charge+($round_off)),2, '.', '')}} </td>
      </tr>
       <tr>
          <td>Total Gross Receipt</td>
          <td>{{number_format((float)($total_gross_receipt),2, '.', '')}}</td>
      </tr>
      <tr>
          <td>Total No. of order</td>
          <td>{{count($data)}}</td>
      </tr>
       <tr>
          <td>APC (Rs.)</td>
          <td>{{number_format((float)($total_gross_receipt/count($data)),2, '.', '')}}</td>
      </tr>

       <tr>
          <td>No. of paying customers</td>
          <td>{{$persons}}</td>
      </tr>
  
      <tr>
          <td>No. of transactions</td>
          <td>{{count($data)}}</td>
      </tr>

      <tr>
          <td>Items Sold</td>
          <td>{{$items}}</td>
      </tr>
       <tr>
          <td>No. of refunds</td>
          <td>{{$refund}}</td>
      </tr>

       <tr>
          <td>No. of voided transactions</td>
          <td>{{count($void)}}</td>
      </tr>
        <tr>
          <td>No. of complimentary order</td>
          <td>{{$complementry_order}}</td>
      </tr> 

      <tr>
          <td>Complimentary discount amount</td>
          <td>{{$complementry_discount}}</td>
      </tr>



     </table>
     <h6 style="text-align: center;"> SALES TYPE WISE BREAKUP DETAILS</h6>
     <table class="table">  
      <tr>
        <td>No of orders in DELIVERY</td>
        <td>{{$delivery}} ({{number_format((float)($delivery/count($data)*100),2, '.', '')}}%)</td>
      </tr>
      <tr>
        <td>No of orders in DINE-IN</td>
        <td>{{$dine_in}} ({{number_format((float)($dine_in/count($data)*100),2, '.', '')}}%)</td>
      </tr>
      <tr>
        <td>No of orders in TAKEAWAY</td>
        <td>{{$takeaway}} ({{number_format((float)($takeaway/count($data)*100),2, '.', '')}}%)</td>
      </tr>
      <tr>
        <td>Total no of orders</td>
        <td>{{count($data)}}</td>
      </tr>
      <tr>
        <td>DELIVERY</td>
        <td>{{$delivery_sale}} ({{number_format((float)($delivery_sale/$actual_sale*100),2, '.', '')}}%)</td>
      </tr>
      <tr>
        <td>DINE-IN</td>
        <td>{{$dine_in_sale}} ({{number_format((float)($dine_in_sale/$actual_sale*100),2, '.', '')}}%)</td>
      </tr>
      <tr>
        <td>TAKEAWAY</td>
        <td>{{$takeaway_sale}} ({{number_format((float)($takeaway_sale/$actual_sale*100),2, '.', '')}}%)</td>
      </tr>
      <tr>
        <td>Total Sales</td>
        <td>{{$actual_sale}}</td>
      </tr>
    </table>

    <h6 style="text-align: center;"> TENDER BREAKUP DETAILS</h6>
    <table class="table"> 
     <?php  
  
  $ids=[];
  $net=0;
     ?>
@foreach($franchise_payment_options as $payment_options)
<?php 
$payments = DB::table('franchise_sales')
                ->where([['del_status', 'Live'],['order_status',3],['payment_method_id',$payment_options->id]]) 
                ->whereIn('outlet_id',$ids_second)
                ->whereBetween('sale_date', [$from, $to])
                ->get(); 
               
$ids[]=$payment_options->id;
$payment_gross_total=0;
  foreach($payments as $pay)
{
$payment_gross_total=$payment_gross_total+$pay->paid_amount;


}
 $net=$net+$payment_gross_total;
?>

<tr>
  
  <td>{{$payment_options->name}}</td>
  <td>{{$payment_gross_total}}</td>
</tr>

    @endforeach
    <?php 
    
    $payment_gross_total_other=0;
$payments_other = DB::table('franchise_sales')

                ->where([['del_status', 'Live'],['order_status',3]]) 
                ->whereIn('outlet_id',$ids_second)
                ->whereBetween('sale_date', [$from, $to])

                ->get(); 

  foreach($payments_other as $pay_other)
{
  if (in_array($pay_other->payment_method_id, $ids))
  {

  }
  else
  {
    $payment_gross_total_other=$payment_gross_total_other+$pay_other->paid_amount;
  }



}

?>
<tr>
  
  <td>Extra </td>
  <td>{{$payment_gross_total_other}}</td>
</tr>
<tr>
  
  <td>Total</td>
  <td>{{$payment_gross_total_other+$net}}</td>
</tr>
    </table>
    
      </div>
    @endif
       </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>