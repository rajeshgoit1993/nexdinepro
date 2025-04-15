
<table class="table table-bordered">

 <tr>
            
            <th>Sales Type</th>
            <th>Date</th>
            <th>Time</th>
            <th>No. of Transaction</th>
            <th>Net Amount</th>
            <th>Gross Amount</th>
            <th>Discount Amount</th>
        </tr>


  <tr>
    <th rowspan="{{count($data_dine_in)+1}}">Dine In</th>
    <th rowspan="{{count($data_dine_in)+1}}">{{$date}}</th>
   
  </tr>
  <?php 
$no_of_transaction=0;
$net=0;
$gross=0;
$discount=0;
  ?>
  @foreach($data_dine_in as $dine)
  <?php 
$d_start=sprintf('%02d',$dine->hour).':00';
$d_end=sprintf('%02d',($dine->hour)).':59:59';

$total_gross_amount=0;
$charge=0;
$total_discount_amount=0;
$total_discount_subtotal=0;


$dine_in_datas=DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$d_start,$d_end])
                 ->whereIn('outlet_id',$ids_second)
                 ->get(); 

foreach($dine_in_datas as $d)
{
    $total_gross_amount=$total_gross_amount+$d->sub_total+$d->total_item_discount_amount;
    if($d->delivery_charge && $d->delivery_charge!="0.00" && $d->delivery_charge!="0.00" && $d->delivery_charge!="0%" && $d->order_type==1 && $d->charge_type=='service'):

  $charge=$charge+POS_SettingHelpers::get_charge_value($d->delivery_charge,$total_gross_amount,$d->total_discount_amount);  
elseif($d->delivery_charge && $d->delivery_charge!="0.00" && $d->delivery_charge!="0.00" && $d->delivery_charge!="0%" && $d->order_type==3 && $d->charge_type=='delivery'):
  
$charge=$charge+POS_SettingHelpers::get_charge_value($d->delivery_charge,$total_gross_amount,$d->total_discount_amount);
endif;

$total_discount_amount=$total_discount_amount+$d->total_item_discount_amount;
$total_discount_subtotal=$total_discount_subtotal+$d->sub_total_discount_amount;
}
if(count($dine_in_datas)!=0)
{
  $no_of_transaction=$no_of_transaction+count($dine_in_datas);
}
if(($total_gross_amount+$charge-$total_discount_amount-$total_discount_subtotal)!='' && ($total_gross_amount+$charge-$total_discount_amount-$total_discount_subtotal)!=0)
{
$net=$net+($total_gross_amount+$charge-$total_discount_amount-$total_discount_subtotal);  
}
if(($total_gross_amount+$charge)!='' && ($total_gross_amount+$charge)!=0)
{
  $gross=$gross+($total_gross_amount+$charge);
}
if(($total_discount_amount+$total_discount_subtotal)!='' && ($total_discount_amount+$total_discount_subtotal)!=0)
{
$discount=$discount+($total_discount_amount+$total_discount_subtotal);  
}

  ?>
  <tr>
    <td style="padding:2px !important;text-align: center;">{{$d_start}} to {{$d_end}}</td>
    <td style="padding:2px !important;text-align: center;">{{count($dine_in_datas)}}</td>
    <td style="padding:2px !important;text-align: center;">{{number_format((float)($total_gross_amount+$charge-$total_discount_amount-$total_discount_subtotal),2, '.', '')}}</td>
    <td style="padding:2px !important;text-align: center;">{{number_format((float)($total_gross_amount+$charge),2, '.', '')}}</td>
    <td style="padding:2px !important;text-align: center;">{{number_format((float)($total_discount_amount+$total_discount_subtotal),2, '.', '')}}</td>
  </tr>
 @endforeach
 
  <tr style="background: gray;color: white;text-align: center;">
    <td colspan="2"> <b>SubTotal Dine In</b></td>
    <td><b></b></td>
    <td><b>{{$no_of_transaction}}</b></td>
    <td><b>{{$net}}</b></td>
    <td><b>{{$gross}}</b></td>
    <td><b>{{$discount}}</b></td>
  </tr>

 

  <tr>
    <th rowspan="{{count($data_takeaway)+1}}">Takeaway</th>
    <th rowspan="{{count($data_takeaway)+1}}">{{$date}}</th>
   
  </tr>
  <?php 
$no_of_transaction=0;

$net=0;
$gross=0;
$discount=0;
  ?>
  @foreach($data_takeaway as $take)
  <?php 
$d_start=sprintf('%02d',$take->hour).':00';
$d_end=sprintf('%02d',($take->hour)).':59';

$total_gross_amount=0;
$charge=0;
$total_discount_amount=0;
$total_discount_subtotal=0;


$takeaway_datas=DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',2]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$d_start,$d_end])
                 ->whereIn('outlet_id',$ids_second)
                 ->get(); 

foreach($takeaway_datas as $d)
{
    $total_gross_amount=$total_gross_amount+$d->sub_total+$d->total_item_discount_amount;
    if($d->delivery_charge && $d->delivery_charge!="0.00" && $d->delivery_charge!="0.00" && $d->delivery_charge!="0%" && $d->order_type==1 && $d->charge_type=='service'):

  $charge=$charge+POS_SettingHelpers::get_charge_value($d->delivery_charge,$total_gross_amount,$d->total_discount_amount);  
elseif($d->delivery_charge && $d->delivery_charge!="0.00" && $d->delivery_charge!="0.00" && $d->delivery_charge!="0%" && $d->order_type==3 && $d->charge_type=='delivery'):
  
$charge=$charge+POS_SettingHelpers::get_charge_value($d->delivery_charge,$total_gross_amount,$d->total_discount_amount);
endif;

$total_discount_amount=$total_discount_amount+$d->total_item_discount_amount;
$total_discount_subtotal=$total_discount_subtotal+$d->sub_total_discount_amount;
}
if(count($takeaway_datas)!=0)
{
  $no_of_transaction=$no_of_transaction+count($takeaway_datas);
}
if(($total_gross_amount+$charge-$total_discount_amount-$total_discount_subtotal)!='' && ($total_gross_amount+$charge-$total_discount_amount-$total_discount_subtotal)!=0)
{
$net=$net+($total_gross_amount+$charge-$total_discount_amount-$total_discount_subtotal);  
}
if(($total_gross_amount+$charge)!='' && ($total_gross_amount+$charge)!=0)
{
  $gross=$gross+($total_gross_amount+$charge);
}
if(($total_discount_amount+$total_discount_subtotal)!='' && ($total_discount_amount+$total_discount_subtotal)!=0)
{
$discount=$discount+($total_discount_amount+$total_discount_subtotal);  
}

  ?>
  <tr>
    <td style="padding:2px !important;text-align: center;">{{$d_start}} to {{$d_end}}</td>
    <td style="padding:2px !important;text-align: center;">{{count($takeaway_datas)}}</td>
    <td style="padding:2px !important;text-align: center;">{{number_format((float)($total_gross_amount+$charge-$total_discount_amount-$total_discount_subtotal),2, '.', '')}}</td>
    <td style="padding:2px !important;text-align: center;">{{number_format((float)($total_gross_amount+$charge),2, '.', '')}}</td>
    <td style="padding:2px !important;text-align: center;">{{number_format((float)($total_discount_amount+$total_discount_subtotal),2, '.', '')}}</td>
  </tr>
 @endforeach
 
  <tr style="background: gray;color: white;text-align: center;">
    <td colspan="2"> <b>SubTotal Takeaway</b></td>
    <td><b></b></td>
    <td><b>{{$no_of_transaction}}</b></td>
    <td><b>{{$net}}</b></td>
    <td><b>{{$gross}}</b></td>
    <td><b>{{$discount}}</b></td>
  </tr>




   <tr>
    <th rowspan="{{count($data_delivery)+1}}">Delivery</th>
    <th rowspan="{{count($data_delivery)+1}}">{{$date}}</th>
   
  </tr>
  <?php 
$no_of_transaction=0;
$net=0;
$gross=0;
$discount=0;
  ?>
  @foreach($data_delivery as $delivery)
  <?php 
$d_start=sprintf('%02d',$delivery->hour).':00';
$d_end=sprintf('%02d',($delivery->hour)).':59';

$total_gross_amount=0;
$charge=0;
$total_discount_amount=0;
$total_discount_subtotal=0;


$data_delivery=DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',3]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$d_start,$d_end])
                 ->whereIn('outlet_id',$ids_second)
                 ->get(); 

foreach($data_delivery as $d)
{
    $total_gross_amount=$total_gross_amount+$d->sub_total+$d->total_item_discount_amount;
    if($d->delivery_charge && $d->delivery_charge!="0.00" && $d->delivery_charge!="0.00" && $d->delivery_charge!="0%" && $d->order_type==1 && $d->charge_type=='service'):

  $charge=$charge+POS_SettingHelpers::get_charge_value($d->delivery_charge,$total_gross_amount,$d->total_discount_amount);  
elseif($d->delivery_charge && $d->delivery_charge!="0.00" && $d->delivery_charge!="0.00" && $d->delivery_charge!="0%" && $d->order_type==3 && $d->charge_type=='delivery'):
  
$charge=$charge+POS_SettingHelpers::get_charge_value($d->delivery_charge,$total_gross_amount,$d->total_discount_amount);
endif;

$total_discount_amount=$total_discount_amount+$d->total_item_discount_amount;
$total_discount_subtotal=$total_discount_subtotal+$d->sub_total_discount_amount;
}
if(count($data_delivery)!=0)
{
  $no_of_transaction=$no_of_transaction+count($data_delivery);
}
if(($total_gross_amount+$charge-$total_discount_amount-$total_discount_subtotal)!='' && ($total_gross_amount+$charge-$total_discount_amount-$total_discount_subtotal)!=0)
{
$net=$net+($total_gross_amount+$charge-$total_discount_amount-$total_discount_subtotal);  
}
if(($total_gross_amount+$charge)!='' && ($total_gross_amount+$charge)!=0)
{
  $gross=$gross+($total_gross_amount+$charge);
}
if(($total_discount_amount+$total_discount_subtotal)!='' && ($total_discount_amount+$total_discount_subtotal)!=0)
{
$discount=$discount+($total_discount_amount+$total_discount_subtotal);  
}

  ?>
  <tr>
    <td style="padding:2px !important;text-align: center;">{{$d_start}} to {{$d_end}}</td>
    <td style="padding:2px !important;text-align: center;">{{count($data_delivery)}}</td>
    <td style="padding:2px !important;text-align: center;">{{number_format((float)($total_gross_amount+$charge-$total_discount_amount-$total_discount_subtotal),2, '.', '')}}</td>
    <td style="padding:2px !important;text-align: center;">{{number_format((float)($total_gross_amount+$charge),2, '.', '')}}</td>
    <td style="padding:2px !important;text-align: center;">{{number_format((float)($total_discount_amount+$total_discount_subtotal),2, '.', '')}}</td>
  </tr>
 @endforeach
 
  <tr style="background: gray;color: white;text-align: center;">
    <td colspan="2"> <b>SubTotal Delivery</b></td>
    <td><b></b></td>
    <td><b>{{$no_of_transaction}}</b></td>
    <td><b>{{$net}}</b></td>
    <td><b>{{$gross}}</b></td>
    <td><b>{{$discount}}</b></td>
  </tr>
  <tr>
    <td colspan="7"><h3> Payment Wise Detail</h3></td>
  </tr>
<?php 

$franchise_payment_options=DB::table('outlet_payment_methods')->get();
?>
<?php  
  
  $ids=[];
  $net=0;
     ?>
@foreach($franchise_payment_options as $payment_options)
<?php 
$payments = DB::table('franchise_sales')
                ->where([['del_status', 'Live'],['order_status',3],['payment_method_id',$payment_options->id]]) 
                ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                ->whereIn('outlet_id',$ids_second)
               
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
  
  <td colspan="3" style="padding:2px !important">{{$payment_options->name}}</td>
  <td colspan="4" style="padding:2px !important">{{$payment_gross_total}}</td>
</tr>

    @endforeach
    <?php 
    
    $payment_gross_total_other=0;
$payments_other = DB::table('franchise_sales')

                ->where([['del_status', 'Live'],['order_status',3]]) 
                ->whereIn('outlet_id',$ids_second)
                ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])

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
  
  <td colspan="3" style="padding:2px !important">Extra </td>
  <td colspan="4" style="padding:2px !important">{{$payment_gross_total_other}}</td>
</tr>
<tr>
  
  <td colspan="3" style="padding:2px !important">Total</td>
  <td colspan="4" style="padding:2px !important">{{$payment_gross_total_other+$net}}</td>
</tr>

</table>


