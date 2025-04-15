
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <tr>
            
        </tr>

        <tr>
            <th style="text-align: center">Discount Report From {{$from}} to {{$to}}</th>
        </tr>


        <tr>
            
        </tr>
  
        <tr>  
            
            <th>Date</th>
            <th>Store</th>
            <th>Transaction <br> Receipt No</th>
            <th>Net <br> Amount</th>
            <th>Gross <br> Amount</th>
            <th>Discounted <br> Amount (item wise)</th>
            <th>Discounted <br> Amount (Subnotal)</th>
            <th>Discounted <br> Total</th>
            <th>Disc. %</th>
            <th>Round off</th>
            <th>Payment<br>  Amount</th>
            <th>Reason (item wise)</th>
            <th>Reason (Subnotal)</th>
            <th>Net <br> Amount</th>
            <th>Sales Type</th>
            </tr>
    @foreach($data as $row=>$col)
 <?php  
$outlet_details=POS_SettingHelpers::get_outlet_details((int)$row);
 $date_data=DB::table('franchise_sales')
                  ->where([['outlet_id',$row],['del_status', 'Live'],['franchise_sales.order_status',3],['total_discount_amount','!=',0]])
                  ->whereIn('outlet_id',$ids_second) 
                  ->whereBetween('sale_date', [$from, $to])
                  ->whereNotNull('total_discount_amount')
                 ->get();

 ?>
  <?php  

$total_gross_amount=0;
$charge=0;
$discount_itemwise=0;
$discount_subtotal=0;
$round_amount=0;
foreach($date_data as $d)
{

$total_gross_amount=$d->sub_total+$d->total_item_discount_amount;

if($d->delivery_charge && $d->delivery_charge!="0.00" && $d->delivery_charge!="0.00" && $d->delivery_charge!="0%" && $d->order_type!=2):

  $charge=POS_SettingHelpers::get_charge_value($d->delivery_charge,$total_gross_amount,$d->total_discount_amount);  


endif;

$discount_itemwise=$d->total_item_discount_amount;
$discount_subtotal=$d->sub_total_discount_amount;
$discount_total=$discount_itemwise+$discount_subtotal;
$outlet_details=POS_SettingHelpers::get_outlet_details((int)$d->outlet_id);
$round_amount=$d->paid_amount-$d->total_payable;
                      ?>

                   <tr>
                    <td style="text-align:center;border: 1px solid black;">{{$d->sale_date}}</td>
                  
              
                    <td style="text-align:center;border: 1px solid black;">
{{ $outlet_details->firm_name }} ({{$outlet_details->city}})
                   </td>
                    <td style="text-align:center;border: 1px solid black;">{{$d->sale_no}}

                   </td>

                   <td style="text-align:center;border: 1px solid black;">
                    {{number_format((float)($total_gross_amount+$charge-$discount_itemwise-$discount_subtotal),2, '.', '')}}


                   </td>
                   <td style="text-align:center;border: 1px solid black;">  {{number_format((float)($total_gross_amount+$charge),2, '.', '')}}

                   </td>
                    <td style="text-align:center;border: 1px solid black;">  {{number_format((float)($discount_itemwise),2, '.', '')}}

                   </td>
                   <td style="text-align:center;border: 1px solid black;">  {{number_format((float)($discount_subtotal),2, '.', '')}}

                   </td>
<td style="text-align:center;border: 1px solid black;">  {{number_format((float)($discount_total),2, '.', '')}}

                   </td>
                <td style="text-align:center;border: 1px solid black;">
                    @if($total_gross_amount+$charge-$discount_itemwise-$discount_subtotal!=0)
                    {{number_format((float)($discount_total/($total_gross_amount+$charge-$discount_itemwise-$discount_subtotal)*100),2, '.', '')}}  %
                   @endif
                   </td>    
                    
            
              <td style="text-align:center;border: 1px solid black;">{{number_format((float)($round_amount),2, '.', '')}}</td>
              <td style="text-align:center;border: 1px solid black;">{{number_format((float)($d->paid_amount),2, '.', '')}} </td>
                     <td style="text-align:center;border: 1px solid black;"></td>
                      <td style="text-align:center;border: 1px solid black;"></td>
                       <td style="text-align:center;border: 1px solid black;">{{number_format((float)($total_gross_amount+$charge-$discount_itemwise-$discount_subtotal),2, '.', '')}}</td>
                        <td>
@if($d->order_type==1)

Dine-in

@elseif($d->order_type==2)
Take Away
@elseif($d->order_type==3)
Delivery
@endif

                        </td>
                </tr>
           <?php
           }
           ?>
    @endforeach
  
            
       
        
    
           
    
    </table>
</body>
</html>