<?php  
$franchise_payment_options=DB::table('outlet_payment_methods')->get();
$total_col=29+count($franchise_payment_options);

?>
<html>
<table>
 
        
        <tr>
            <th colspan="{{$total_col}}" style="text-align: center;background: white"><?php echo $outlet_details->firm_name; ?></th>
           
        </tr>

        <tr>
            <th colspan="{{$total_col}}" style="text-align: center;background: white"><?php echo $outlet_details->outlet_address; ?><th>
           
        </tr>

      
@if($outlet_details->gst!='')
        <tr>
            <th colspan="{{$total_col}}" style="text-align: center;background: white">GST No. <?php echo $outlet_details->gst; ?></th>
        </tr>
@else
<tr>
  <th></th>
</tr>
@endif
        <tr>
            <th colspan="{{$total_col}}" style="text-align: center;background: white">Phone No. <?php echo $outlet_details->mobile; ?></th>
        </tr>

        <tr>
            <td colspan="{{$total_col}}" style="background: white">From Date {{$from}} Till Date {{$to}}</td>
        </tr>

        <tr>
            
        </tr>


    <tr>  
        <th>Date</th>
        
        <th>Store Name</th>
        <th >Gross <br> Sales <br> Amount</th>
        <th>Discount <br> Amount</th>
        <th>Service/Delivery <br> charge</th>
        <th>Net <br> Sales</th>
        <th>Total <br> Taxable <br> Sales</th>
        
        <th>C-GST <br> Amount</th>
        <th>S-GST <br> Amount</th>
         <th>Round off</th>
        <th>Total <br> Gross <br> Amount</th>
        <th>Total <br> Gross <br> Receipt</th>
        <th>No of <br> Orders</th>
   
        <th>Dine -In <br> Order</th>
        <th>%</th>
        <th>Dine-In Net <br> Sales</th>
        <th>%</th>
        <th>Take Away <br> Sales Order</th>
        <th>%</th>
        <th>Take Away <br> Net Sales</th>
        <th>%</th>
        <th>DELIVERY <br> Sales Order</th>
        <th>%</th>
        <th>DELIVERY <br> Net Sales</th>
        <th>%</th>
        <th>APC(Rs.)</th>
       
@foreach($franchise_payment_options as $payment_options)

  <th>{{$payment_options->name}}</th>
@endforeach

        <th>Other</th>
     
        <th>Total Tender</th>
    </tr>
    @foreach($data as $row=>$col)
    <?php  
 $date_data=DB::table('franchise_sales')
                  ->where([['outlet_id',$outlet_id],['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                 ->whereDate('sale_date',$row)
                 ->get(); 

    ?>
    <?php  

$total_gross_amount=0;
$total_discount_amount=0;
$total_discount_subtotal=0;
$total_gst=0;
$persons=0;
$items=0;
$refund=0;
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
$charge=0;
$round_off=0;
foreach($date_data as $d)
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

  <tr>
  <td style="background:white;text-align: center;">{{$row}}</td>
  <td style="background:white;text-align: center;"><?php echo $outlet_details->firm_name; ?></td>
  <td style="background:white;text-align: center;">{{number_format((float)($total_gross_amount+$charge),2, '.', '')}}</td>
  <td style="background:white;text-align: center;">{{number_format((float)($total_discount_amount+$total_discount_subtotal),2, '.', '')}}</td>
  <td style="background:white;text-align: center;">{{number_format((float)($charge),2, '.', '')}}</td>
  <td style="background:white;text-align: center;">{{number_format((float)($total_gross_amount+$charge-$total_discount_amount-$total_discount_subtotal),2, '.', '')}}</td>
   <td style="background:white;text-align: center;">{{number_format((float)($total_gross_amount-$total_discount_amount-$total_discount_subtotal),2, '.', '')}}</td>

  <td style="background:white;text-align: center;">{{number_format((float)($total_gst/2),2, '.', '')}}</td>
  <td style="background:white;text-align: center;">{{number_format((float)($total_gst/2),2, '.', '')}}</td>
  <td style="background:white;text-align: center;">{{number_format((float)($round_off),2, '.', '')}}</td>
  <td style="background:white;text-align: center;">{{number_format((float)($total_gross_amount-$total_discount_amount-$total_discount_subtotal+$total_gst+$charge+($round_off)),2, '.', '')}}</td>
  <td style="background:white;text-align: center;">{{number_format((float)($total_gross_receipt),2, '.', '')}}</td>
   <td style="background:white;text-align: center;">{{count($data)}}</td>

  <td style="background:white;text-align: center;">{{$dine_in}} </td>
  <td>({{number_format((float)($dine_in/count($data)*100),2, '.', '')}}%)</td>
  <td style="background:white;text-align: center;">{{$dine_in_sale}} </td>
  <td>
  @if($actual_sale!=0) ({{number_format((float)($dine_in_sale/$actual_sale*100),2, '.', '')}}%) @endif
</td>
  <td style="background:white;text-align: center;">{{$takeaway}}</td>
  <td>
   ({{number_format((float)($takeaway/count($data)*100),2, '.', '')}}%)
</td>
   <td style="background:white;text-align: center;">{{$takeaway_sale}} </td>
   <td>@if($actual_sale!=0) ({{number_format((float)($takeaway_sale/$actual_sale*100),2, '.', '')}}%) @endif
   </td>
  <td style="background:white;text-align: center;">{{$delivery}} </td>
  <td>({{number_format((float)($delivery/count($data)*100),2, '.', '')}}%)</td>
  <td style="background:white;text-align: center;">{{$delivery_sale}} </td>
  <td>@if($actual_sale!=0)
  ({{number_format((float)($delivery_sale/$actual_sale*100),2, '.', '')}}%) @endif
</td>
  <td style="background:white;text-align: center;">{{$total_gross_receipt/count($data)}}</td>


  <?php  
  
  $ids=[];
  $net=0;
     ?>
@foreach($franchise_payment_options as $payment_options)
<?php 
$payments = DB::table('franchise_sales')
                ->where([['outlet_id',$outlet_id],['del_status', 'Live'],['order_status',3],['payment_method_id',$payment_options->id]]) 
                ->whereDate('sale_date',$row)
                ->get(); 
               
$ids[]=$payment_options->id;
$payment_gross_total=0;
  foreach($payments as $pay)
{
$payment_gross_total=$payment_gross_total+$pay->paid_amount;


}
 $net=$net+$payment_gross_total;
?>

  <td style="background:white;text-align: center;">{{$payment_gross_total}}</td>
  @endforeach

  <?php 
    
    $payment_gross_total_other=0;
$payments_other = DB::table('franchise_sales')

                ->where([['outlet_id',$outlet_id],['del_status', 'Live'],['order_status',3]]) 
                
                ->whereDate('sale_date',$row)

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

  <td style="background:white;text-align: center;">{{$payment_gross_total_other}}</td>
  <td style="background:white;text-align: center;">{{$payment_gross_total_other+$net}}</td>
  </tr>
    @endforeach
  
     
   
</table>

