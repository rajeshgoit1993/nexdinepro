
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
            <th>Date:</th>
            <th>{{$from}}</th>
        </tr>
        
        <tr>
            <th>End Date:</th>
            <th>{{$to}}</th>
        </tr>

        <tr>

        </tr>

        <tr>
            <th>Restaurants</th>
          
            <th>Category</th>
            <th>Item</th>
            <th>Code</th>
            
            <th>Qty.</th>
            <th>Total</th>
            <th>Remarks</th>
        </tr>
        <?php 
$total=0;
        ?>
     @foreach($data as $row=>$col)
           <?php  
$outlet_details=POS_SettingHelpers::get_outlet_details((int)$row);



$date_data = DB::table('franchise_sales_details')
            ->leftJoin('franchise_sales','franchise_sales.id', '=','franchise_sales_details.sales_id')
            ->leftJoin('food_menus','food_menus.id', '=','franchise_sales_details.food_menu_id')
            ->where([['franchise_sales_details.outlet_id',$row],['franchise_sales_details.del_status', 'Live'],['franchise_sales.del_status', 'Live'],['franchise_sales.order_status',3]])
                 
            ->whereBetween('franchise_sales.sale_date', [$from, $to])
           
            ->select('food_menu_id','menu_name','code','sale_date','franchise_sales.id as sale_id','franchise_sales_details.id as franchise_sales_details_id','franchise_sales_details.qty as qty')
            ->get()->groupBy('food_menu_id'); 

       
 ?> 
     @foreach($date_data as $d)
      
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

   ?>
        <tr>
         <td style="border:1px solid black;">{{ $outlet_details->firm_name }} ({{$outlet_details->city}})</td>
         <td style="border:1px solid black;">{{CustomHelpers::get_master_table_data('food_menu_categories','id',CustomHelpers::get_master_table_data('food_menus','id',$d[0]->food_menu_id,'category_id'),'category_name')}}</td>
        <td style="border:1px solid black;">{{CustomHelpers::get_master_table_data('food_menus','id',$d[0]->food_menu_id,'name')}}</td>
        <td style="border:1px solid black;">{{$d[0]->code}}</td>
                      <td style="border:1px solid black;">{{$qty}}</td>
                       <td style="border:1px solid black;">{{$actual_total}}</td>
                        <td style="border:1px solid black;">@if(count(array_unique($rate_array))>1)
 Price change {{count(array_unique($rate_array))-1}} times between date range 
  
     @endif</td>
     </tr>
        @endforeach            
                    
                
            @endforeach
    
    </table>
</body>
</html>