<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<?php  
$franchise_payment_options=DB::table('outlet_payment_methods')->get();


?>

<body>
    <table>

        <tr>
            
        </tr>

        <tr>
           <th style="text-align: center">Cashier Report</th>
        </tr>
        <tr>
            <th style="text-align: center"><?php echo $outlet_details->firm_name; ?></th>
        </tr>

        <tr>
          
            
            <th>Store Name</th>
            <th>Cashier <br> ID</th>
            <th>Cashier <br> Name</th>
            <th>Bill No.</th>
          
            <th>Punch <br> Date</th>
            <th>Punch <br> Time</th>
            <th>Cash Out <br> Date</th>
            <th>Cash Out <br> Time</th>
            <th>Qty. </th>
            
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
             <th>Sales <br> Type</th>
             @foreach($franchise_payment_options as $payment_options)

             <th>{{$payment_options->name}}</th>
             @endforeach
             <th>Extra</th>
             <th>Total</th>
            <th>Pos Order <br> No.</th>
            
        </tr>
@foreach($data as $row=>$col)
    <?php  
 $date_data=DB::table('franchise_sales')
                  ->where([['outlet_id',$outlet_id],['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                 ->whereDate('sale_date',$row)
                 ->get(); 

    ?>



@foreach($date_data as $d)
<tr>
                <td style="text-align:center;border: 1px solid black;">{{ $outlet_details->firm_name }} ({{$outlet_details->city}})</td>
                <td style="text-align:center;border: 1px solid black;">

                    {{CustomHelpers::get_master_table_data('users','id',$d->user_id,'email')}}
                </td>  
                <td style="text-align:center;border: 1px solid black;">{{CustomHelpers::get_master_table_data('users','id',$d->user_id,'name')}}</td>    
                <td style="text-align:center;border: 1px solid black;">
                      <?php
                    $order_type = '';
                    if($d->order_type == 1){
                        $order_type = 'A';
                    }elseif($d->order_type == 2){
                        $order_type = 'B';
                    }elseif($d->order_type == 3){
                        $order_type = 'C';
                    }
                    ?>

                   {{$order_type}} {{$d->sale_no}}
                </td>
                <td style="text-align:center;border: 1px solid black;">{{$d->sale_date}}</td>
                <td style="text-align:center;border: 1px solid black;">{{$d->order_time}}</td>
                <td style="text-align:center;border: 1px solid black;">
                    {{date('Y-m-d', strtotime($d->updated_at))}} </td>

                <td style="text-align:center;border: 1px solid black;">
                    {{date('h:i:sa', strtotime($d->updated_at))}} </td>
                <td style="text-align:center;border: 1px solid black;">{{$d->total_items}}</td>
                <?php
$charge=0;
$total_gross_amount=$d->sub_total+$d->total_item_discount_amount;
if($d->delivery_charge && $d->delivery_charge!="0.00" && $d->delivery_charge!="0.00" && $d->delivery_charge!="0%" && $d->order_type==1 && $d->charge_type=='service'):

  $charge=$charge+POS_SettingHelpers::get_charge_value($d->delivery_charge,$total_gross_amount,$d->total_discount_amount);  
elseif($d->delivery_charge && $d->delivery_charge!="0.00" && $d->delivery_charge!="0.00" && $d->delivery_charge!="0%" && $d->order_type==3 && $d->charge_type=='delivery'):
  
$charge=$charge+POS_SettingHelpers::get_charge_value($d->delivery_charge,$total_gross_amount,$d->total_discount_amount);
endif;
$round_amount=$d->paid_amount-$d->total_payable;
                ?>
                <td style="text-align:center;border: 1px solid black;">{{$d->sub_total+$d->total_item_discount_amount+$charge}}</td>
                <td style="text-align:center;border: 1px solid black;">{{$d->total_discount_amount}}</td>
                <td style="text-align:center;border: 1px solid black;">{{number_format((float)($charge),2, '.', '')}}</td>
                <td style="text-align:center;border: 1px solid black;">{{number_format((float)($d->sub_total+$d->total_item_discount_amount+$charge-$d->total_discount_amount),2, '.', '')}}</td>
                <td style="text-align:center;border: 1px solid black;">{{number_format((float)($d->sub_total+$d->total_item_discount_amount-$d->total_discount_amount),2, '.', '')}}</td>
                <td style="text-align:center;border: 1px solid black;">{{number_format((float)($d->gst/2),2, '.', '')}}</td>
                <td style="text-align:center;border: 1px solid black;">{{number_format((float)($d->gst/2),2, '.', '')}}</td>
                <td style="text-align:center;border: 1px solid black;">{{number_format((float)($round_amount),2, '.', '')}}</td>

                <td style="text-align:center;border: 1px solid black;">{{number_format((float)($d->sub_total+$d->total_item_discount_amount-$d->total_item_discount_amount-$d->sub_total_discount_amount+$d->gst+$charge+($round_amount)),2, '.', '')}}</td>

                <td style="text-align:center;border: 1px solid black;">{{number_format((float)($d->sub_total+$d->total_item_discount_amount-$d->total_item_discount_amount-$d->sub_total_discount_amount+$charge+$d->gst+($round_amount)),2, '.', '')}}</td>
                <td style="text-align:center;border: 1px solid black;">
                    <?php
                    $order_type = '';
                    if($d->order_type == 1){
                      echo 'Dine In';
                    }elseif($d->order_type == 2){
                       echo 'Take Away';
                    }elseif($d->order_type == 3){
                        echo 'Delivery';
                    }
                    ?>

                  
                </td>
                

                <?php  
  
  $ids=[];
  $net=0;


     ?>
@foreach($franchise_payment_options as $payment_options)
<?php 
$payments = DB::table('franchise_sales')
                ->where([['outlet_id',$outlet_id],['id',$d->id],['del_status', 'Live'],['order_status',3],['payment_method_id',$payment_options->id]]) 
              
                ->get(); 
               
$ids[]=$payment_options->id;
$payment_gross_total=0;
  foreach($payments as $pay)
{
$payment_gross_total=$pay->paid_amount;


}
 $net=$net+$payment_gross_total;
?>

  <td style="text-align:center;border: 1px solid black;">{{$payment_gross_total}}</td>
  @endforeach

  <?php 
    
    $payment_gross_total_other=0;
$payments_other = DB::table('franchise_sales')

                ->where([['outlet_id',$outlet_id],['id',$d->id],['del_status', 'Live'],['order_status',3]]) 
               
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

  <td style="text-align:center;border: 1px solid black;">{{$payment_gross_total_other}}</td>
  <td style="text-align:center;border: 1px solid black;">{{$payment_gross_total_other+$net}}</td>


                <td>{{$d->token_number}}</td>
            
            </tr>

@endforeach

@endforeach
            
 

    </table>

</body>
</html>