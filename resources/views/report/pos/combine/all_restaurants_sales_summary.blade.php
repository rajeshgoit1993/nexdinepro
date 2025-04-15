
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php  
$franchise_payment_options=DB::table('outlet_payment_methods')->get();
$total_col=22+count($franchise_payment_options);

?>
    <table>
        <tr>
            
        </tr>

        <tr>
            <th style="text-align: right">Date:</th>
            <th style="text-align: right">{{$from}} to {{$to}}</th>
            <th></th>
            <th></th>

        </tr>


        <tr>
            <th style="text-align: right">Name:</th>
            <th style="text-align: right">All Restaurants Sales Summary</th>
            <th></th>
            <th></th>
        </tr>

        <tr>

        </tr>

      

        <tr>
            <th>Restaurants</th>
            <th>Tenure</th>
            <th>Invoice <br> Nos.</th>
            <th>Total no. <br>  of bills</th>
            <th>My Amount (₹)</th>
            <th>Total <br> Discount (₹)</th>
            <th>Net Sales (₹)<br> (M.A - T.D)</th>
            <th>Delivery <br> Charge</th>
           
            <th>Service <br> Charge</th>
           
            <th>Round Off</th>
            
            <th>Total <br> Sales (₹)</th>
            <th>Total Tax</th>
            <th>C-GST Paid</th>
            <th>S-GST Paid</th>
            <th>Total <br> Sales (Inc GST) (₹)</th>
            <?php 
          $payment_array=0;
            ?>
            @foreach($franchise_payment_options as $payment_options)

  <th>{{$payment_options->name}}</th>
  <?php 
$payment_index[$payment_array]=$payment_options->id;
$payment_array++;
  ?>
            @endforeach
         
            <th>Other</th>
            <th>Total</th>
            
        </tr>
        
   
           
                
      <?php 
$analysis_total_bill[]=0;

$analysis_total_gross_amount[]=0;

$analysis_total_discount[]=0;

$analysis_total_net_sales[]=0;

$analysis_total_d_charge[]=0;

$analysis_total_s_charge[]=0;

$analysis_total_round_off[]=0;

$analysis_total_sales[]=0;

$analysis_total_gst[]=0;

$analysis_total_sgst[]=0;

$analysis_total_cgst[]=0;

$analysis_payment_gross_total_other[]=0;

$analysis_payment_gross_total_other_sec[]=0;

$analysis_total_with_gst[]=0;


      ?>            


                
 @foreach($data as $row=>$col)
 <?php  
$outlet_details=POS_SettingHelpers::get_outlet_details((int)$row);
 $date_data=DB::table('franchise_sales')
                  ->where([['outlet_id',$row],['del_status', 'Live'],['franchise_sales.order_status',3]])
                  ->whereIn('outlet_id',$ids_second) 
                  ->whereBetween('sale_date', [$from, $to])
                 ->get();

 ?>
  <?php  
$round_off=0;
$total_gross_amount=0;
$total_discount_amount=0;
$total_discount_subtotal=0;
$total_gst=0;
$persons=0;
$items=0;
$refund=0;

$complementry_order=0;
$complementry_discount=0;

$a=1;
$opening_bill_no=0;
$closing_bill_no=0;
$d_charge=0;
$s_charge=0;




foreach($date_data as $d)
{
  if($a==1)
  {
    $opening_bill_no=$d->invoice_number;
  }
  $closing_bill_no=$d->invoice_number;
  $a++;

// $total_gross_amount=$total_gross_amount+$d->sub_total+$d->total_item_discount_amount+$d->sub_total_discount_amount;

$total_gross_amount=$total_gross_amount+$d->sub_total+$d->total_item_discount_amount;

if($d->charge_type=='service' && $d->delivery_charge && $d->delivery_charge!="0.00" && $d->delivery_charge!="0.00" && $d->delivery_charge!="0%" && $d->order_type==1):


  $s_charge=$s_charge+POS_SettingHelpers::get_charge_value($d->delivery_charge,$total_gross_amount,$d->total_discount_amount);  

elseif($d->charge_type=='delivery' && $d->delivery_charge && $d->delivery_charge!="0.00" && $d->delivery_charge!="0.00" && $d->delivery_charge!="0%" && $d->order_type==3):
     $d_charge=$d_charge+POS_SettingHelpers::get_charge_value($d->delivery_charge,$total_gross_amount,$d->total_discount_amount);  

endif;
$round_amount=$d->paid_amount-$d->total_payable;

if($round_amount!=0):
$round_off=$round_off+($round_amount);
endif;
$total_discount_amount=$total_discount_amount+$d->total_item_discount_amount;
$total_discount_subtotal=$total_discount_subtotal+$d->sub_total_discount_amount;
$total_gst=$total_gst+$d->gst;
$items=$items+$d->total_items;

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
$total_gross_receipt=$total_gross_amount-$total_discount_amount-$total_discount_subtotal+$d_charge+$s_charge+$total_gst+($round_off);



$actual_sale=$total_gross_amount-$total_discount_amount-$total_discount_subtotal+$d_charge+$s_charge;
$franchise_payment_options=DB::table('outlet_payment_methods')->get();
$analysis_total_bill[]=count($date_data);
$analysis_total_gross_amount[]=$total_gross_amount+$d_charge+$s_charge;
$analysis_total_discount[]=$total_discount_amount+$total_discount_subtotal;
$analysis_total_net_sales[]=$total_gross_amount-$total_discount_amount-$total_discount_subtotal;
$analysis_total_d_charge[]=$d_charge;
$analysis_total_s_charge[]=$s_charge;
$analysis_total_round_off[]=$round_off;
$analysis_total_sales[]=$total_gross_amount-$total_discount_amount-$total_discount_subtotal+$d_charge+$s_charge+($round_off);
$analysis_total_gst[]=$total_gst;
$analysis_total_sgst[]=$total_gst/2;
$analysis_total_cgst[]=$total_gst/2;
$analysis_total_with_gst[]=$total_gross_amount-$total_discount_amount-$total_discount_subtotal+$d_charge+$s_charge+($round_off)+$total_gst;
$launch_date=$outlet_details->survey_system_date;
$today=date('Y-m-d');
$d1=new DateTime($today); 
$d2=new DateTime($launch_date);                                  
$Months = $d2->diff($d1); 
$howeverManyMonths = (($Months->y) * 12) + ($Months->m);

                      ?>

                   <tr>
                    <td style="text-align:center;border: 1px solid black;">{{ $outlet_details->firm_name }} ({{$outlet_details->city}}) </td>
                    
                       @if($howeverManyMonths<=3) 
                    <td style="text-align:center;border: 1px solid black;color: green;"> 0-3 </td>
                       @elseif($howeverManyMonths>3 && $howeverManyMonths<=6)
<td style="text-align:center;border: 1px solid black;color: yellow;"> 3-6 </td>
                       @elseif($howeverManyMonths>6 && $howeverManyMonths<=9)
<td style="text-align:center;border: 1px solid black;color: blue;"> 6-9</td>
                       @elseif($howeverManyMonths>9 && $howeverManyMonths<=12)
<td style="text-align:center;border: 1px solid black;color: orange;"> 9-12</td>
                       @else
<td style="text-align:center;border: 1px solid black;color: red;"> 12+</td>
                       @endif

                  
                    <td style="text-align:center;border: 1px solid black;">{{$opening_bill_no}} - {{$closing_bill_no}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{count($date_data)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{number_format((float)($total_gross_amount),2, '.', '')}}

                   </td>
                    <td style="text-align:center;border: 1px solid black;">{{number_format((float)($total_discount_amount+$total_discount_subtotal),2, '.', '')}}</td>

                    <td style="text-align:center;border: 1px solid black;">
                    {{number_format((float)($total_gross_amount-$total_discount_amount-$total_discount_subtotal),2, '.', '')}}
                 </td>
                    <td style="text-align:center;border: 1px solid black;">{{$d_charge}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{$s_charge}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{$round_off}}</td>
                   
                    
                    <td style="text-align:center;border: 1px solid black;">{{$total_gross_amount-$total_discount_amount-$total_discount_subtotal+$d_charge+$s_charge+($round_off)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{number_format((float)($total_gst),2, '.', '')}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{number_format((float)($total_gst/2),2, '.', '')}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{number_format((float)($total_gst/2),2, '.', '')}}</td>
                     <td style="text-align:center;border: 1px solid black;">{{$total_gross_amount-$total_discount_amount-$total_discount_subtotal+$d_charge+$s_charge+($round_off)+$total_gst}}</td>
                      <?php  
  
  $ids=[];
  $net=0;
     ?>
@foreach($franchise_payment_options as $payment_options)

<?php 
$payments = DB::table('franchise_sales')
                ->where([['outlet_id',$row],['del_status', 'Live'],['order_status',3],['payment_method_id',$payment_options->id]]) 
                ->whereBetween('sale_date', [$from, $to])
                ->get(); 
               
$ids[]=$payment_options->id;
$payment_gross_total=0;
  foreach($payments as $pay)
{
$payment_gross_total=$payment_gross_total+$pay->paid_amount;


}
 $net=$net+$payment_gross_total;
 foreach($payment_index as $index_row=>$index_col):
    if($index_col==$payment_options->id):
   $payment_datas[$index_row][]=$payment_gross_total;
   endif;
  endforeach
?>

<td style="text-align:center;border: 1px solid black;">{{$payment_gross_total}}</td>
 

    @endforeach
    <?php 
    
    $payment_gross_total_other=0;
$payments_other = DB::table('franchise_sales')

                ->where([['outlet_id',$row],['del_status', 'Live'],['order_status',3]]) 
                
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
$analysis_payment_gross_total_other[]=$payment_gross_total_other;
$analysis_payment_gross_total_other_sec[]=$payment_gross_total_other+$net;
?>

                    <td style="text-align:center;border: 1px solid black;">{{$payment_gross_total_other}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{$payment_gross_total_other+$net}}</td>
                    
                    
                </tr>
           
    @endforeach
   <?php 
   if (isset($payment_datas)) {
  foreach($payment_datas as $third_row=>$third_col)
   {
    sort($third_col);
    $payment_datas[$third_row]=$third_col;
   
   }
}


sort($analysis_total_bill);
sort($analysis_total_gross_amount);
sort($analysis_total_discount);
sort($analysis_total_net_sales);
sort($analysis_total_d_charge);
sort($analysis_total_s_charge);
sort($analysis_total_round_off);
sort($analysis_total_sales);
sort($analysis_total_gst);
sort($analysis_total_sgst);
sort($analysis_total_cgst);
sort($analysis_payment_gross_total_other);
sort($analysis_payment_gross_total_other_sec);
sort($analysis_total_with_gst);
   ?>
   <tr>
                    <td style="text-align:center;border: 1px solid black;">Total</td>
                    <td style="text-align:center;border: 1px solid black;"></td>
                    <td style="text-align:center;border: 1px solid black;"></td>
                    <td style="text-align:center;border: 1px solid black;">{{array_sum($analysis_total_bill)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{array_sum($analysis_total_gross_amount)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{array_sum($analysis_total_discount)}}</td>
                    
                    <td style="text-align:center;border: 1px solid black;">{{array_sum($analysis_total_net_sales)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{array_sum($analysis_total_d_charge)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{array_sum($analysis_total_s_charge)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{array_sum($analysis_total_round_off)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{array_sum($analysis_total_sales)}}</td>
                  
                    
                    <td style="text-align:center;border: 1px solid black;">{{array_sum($analysis_total_gst)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{array_sum($analysis_total_sgst)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{array_sum($analysis_total_cgst)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{array_sum($analysis_total_with_gst)}}</td>
                    @if(isset($payment_datas))
                    @foreach($payment_datas as $fourth_row=>$fourth_col)
                    <?php 
                    $payment_t_count=0;
                    ?>
                    @foreach($fourth_col as $fourth_col_payment)
                    <?php 
                    if($fourth_col_payment!=0):
                    $payment_t_count=$payment_t_count+$fourth_col_payment;
                    endif;
                    ?>
                    @endforeach
                    <td style="text-align:center;border: 1px solid black;">{{$payment_t_count}} </td>
                   @endforeach
                   @endif
                    <td style="text-align:center;border: 1px solid black;">{{array_sum($analysis_payment_gross_total_other)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{array_sum($analysis_payment_gross_total_other_sec)}}</td>
                    
                    
                </tr>
                   <tr>
                    <td style="text-align:center;border: 1px solid black;">Min.</td>
                    <td style="text-align:center;border: 1px solid black;"></td>
                    <td style="text-align:center;border: 1px solid black;"></td>
                    <td style="text-align:center;border: 1px solid black;">{{current($analysis_total_bill)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{current($analysis_total_gross_amount)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{current($analysis_total_discount)}}</td>
                    
                    <td style="text-align:center;border: 1px solid black;">{{current($analysis_total_net_sales)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{current($analysis_total_d_charge)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{current($analysis_total_s_charge)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{current($analysis_total_round_off)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{current($analysis_total_sales)}}</td>
                  
                    
                    <td style="text-align:center;border: 1px solid black;">{{current($analysis_total_gst)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{current($analysis_total_sgst)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{current($analysis_total_cgst)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{current($analysis_total_with_gst)}}</td>
                    @if(isset($payment_datas))
                      @foreach($payment_datas as $fourth_row=>$fourth_col)
                  
                    <th style="text-align:center;border: 1px solid black;">{{current($fourth_col)}} </th>
                   @endforeach
                   @endif
                    <td style="text-align:center;border: 1px solid black;">{{current($analysis_payment_gross_total_other)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{current($analysis_payment_gross_total_other_sec)}}</td>
                    
                    
                </tr>
    <tr>
                    <td style="text-align:center;border: 1px solid black;">Max.</td>
                    <td style="text-align:center;border: 1px solid black;"></td>
                    <td style="text-align:center;border: 1px solid black;"></td>
                   <td style="text-align:center;border: 1px solid black;">{{end($analysis_total_bill)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{end($analysis_total_gross_amount)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{end($analysis_total_discount)}}</td>
                    
                    <td style="text-align:center;border: 1px solid black;">{{end($analysis_total_net_sales)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{end($analysis_total_d_charge)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{end($analysis_total_s_charge)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{end($analysis_total_round_off)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{end($analysis_total_sales)}}</td>
                  
                    
                    <td style="text-align:center;border: 1px solid black;">{{end($analysis_total_gst)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{end($analysis_total_sgst)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{end($analysis_total_cgst)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{end($analysis_total_with_gst)}}</td>
                    @if(isset($payment_datas))
                    @foreach($payment_datas as $fourth_row=>$fourth_col)
                  
                    <th style="text-align:center;border: 1px solid black;">{{end($fourth_col)}} </th>
                   @endforeach
                   @endif
                    <td style="text-align:center;border: 1px solid black;">{{end($analysis_payment_gross_total_other)}}</td>
                    <td style="text-align:center;border: 1px solid black;">{{end($analysis_payment_gross_total_other_sec)}}</td>
                    
                    
                </tr>

                   <tr>
                    <td style="text-align:center;border: 1px solid black;">Avg.</td>
                    <td style="text-align:center;border: 1px solid black;"></td>
                    <td style="text-align:center;border: 1px solid black;"></td>
                    <td style="text-align:center;border: 1px solid black;">
                        @if(count($data)>0) {{array_sum($analysis_total_bill)/count($data)}} @endif
                    </td>
                    <td style="text-align:center;border: 1px solid black;">@if(count($data)>0) {{array_sum($analysis_total_gross_amount)/count($data)}} @endif
                    </td>
                    
                    <td style="text-align:center;border: 1px solid black;">@if(count($data)>0) {{array_sum($analysis_total_discount)/count($data)}} @endif </td>
                    <td style="text-align:center;border: 1px solid black;">@if(count($data)>0) {{array_sum($analysis_total_net_sales)/count($data)}} @endif</td>
                    <td style="text-align:center;border: 1px solid black;">@if(count($data)>0) {{array_sum($analysis_total_d_charge)/count($data)}} @endif</td>
                   
                    
                    <td style="text-align:center;border: 1px solid black;">@if(count($data)>0) {{array_sum($analysis_total_s_charge)/count($data)}} @endif</td>
                    <td style="text-align:center;border: 1px solid black;">@if(count($data)>0) {{array_sum($analysis_total_round_off)/count($data)}} @endif</td>
                    <td style="text-align:center;border: 1px solid black;">@if(count($data)>0) {{array_sum($analysis_total_sales)/count($data)}} @endif</td>
                    <td style="text-align:center;border: 1px solid black;">@if(count($data)>0) {{array_sum($analysis_total_gst)/count($data)}} @endif</td>
                    <td style="text-align:center;border: 1px solid black;">@if(count($data)>0) {{array_sum($analysis_total_sgst)/count($data)}} @endif</td>
                    <td style="text-align:center;border: 1px solid black;">@if(count($data)>0) {{array_sum($analysis_total_cgst)/count($data)}} @endif</td>
                    <td style="text-align:center;border: 1px solid black;">@if(count($data)>0) {{array_sum($analysis_total_with_gst)/count($data)}} @endif</td>
                    @if(isset($payment_datas))
                    @foreach($payment_datas as $fourth_row=>$fourth_col)
                    <?php 
                    $payment_tt_count=0;
                    ?>
                    @foreach($fourth_col as $fourth_col_payment)
                    <?php 
                    if($fourth_col_payment!=0):
                    $payment_tt_count=$payment_tt_count+$fourth_col_payment;
                    endif;
                    ?>
                    @endforeach
                    <th style="text-align:center;border: 1px solid black;">{{$payment_tt_count/count($data)}} </th>
                   @endforeach
                   @endif
                    <td style="text-align:center;border: 1px solid black;">@if(count($data)>0) {{array_sum($analysis_payment_gross_total_other)/count($data)}} @endif</td>
                    <td style="text-align:center;border: 1px solid black;">@if(count($data)>0) {{array_sum($analysis_payment_gross_total_other_sec)/count($data)}} @endif</td>
                    
                    
                </tr>
    </table>
</body>
</html>