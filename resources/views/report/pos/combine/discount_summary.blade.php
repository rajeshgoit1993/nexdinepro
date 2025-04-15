
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
            <th colspan="2">Name:</th>
            <th >Discount_summary_report</th>
        </tr>

        <tr>
            <th colspan="2">Restaurant Name:</th>
            <th>All Restaurants</th>
        </tr>

        <tr>
      <th colspan="2">Date:</th>
            <th >{{$from}} to {{$to}}</th>
        </tr>

        <tr>
            <th>Restaurant  Name</th>
            <th> Delivery (₹)</th>
            <th>Take  Away (₹)</th>
            <th>Dine In (₹)</th>
          
            <th>Grand Total (₹)</th>
        </tr>


 
        
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

$discount_takeaway=0;
$discount_delivery=0;
$discount_dine_in=0;
$discount_total=0;
foreach($date_data as $d)
{
  if($d->order_type==1)
{
 $discount_dine_in=$discount_dine_in+$d->total_discount_amount;

}
elseif($d->order_type==2)
{
 $discount_takeaway=$discount_takeaway+$d->total_discount_amount;
 
}
elseif($d->order_type==3)
{
$discount_delivery=$discount_delivery+$d->total_discount_amount;


}

$discount_total=$discount_total+$d->total_discount_amount;
}
                      ?>

                   <tr>
                    <td style="text-align:center;border: 1px solid black;">{{ $outlet_details->firm_name }} ({{$outlet_details->city}})</td>
                  
              
                    <td style="text-align:center;border: 1px solid black;">{{number_format((float)($discount_delivery),2, '.', '')}}

                   </td>
                    <td style="text-align:center;border: 1px solid black;">{{number_format((float)($discount_takeaway),2, '.', '')}}

                   </td>

                   <td style="text-align:center;border: 1px solid black;">{{number_format((float)($discount_dine_in),2, '.', '')}}

                   </td>
                   <td style="text-align:center;border: 1px solid black;">{{number_format((float)($discount_total),2, '.', '')}}

                   </td>
                    

                    
                    
                </tr>
           
    @endforeach
  
   
   

                 
    </table>
</body>
</html>