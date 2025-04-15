
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
            <th>Store <br> No.</th>
          
            <th>Item  Category  Code</th>
            
            <th>Receipt  No.</th>
            <th>Item  No.</th>
            <th>Item Name</th>
            <th>Qty CP</th>
            <th>Date</th>
            <th>Quantity</th>
         
            <th>Sales <br> Type</th>
           
            <th>Price</th>
            <th>Net Amount</th>
            <th>Discount <br> Amount</th>
            <th>SGST </th>
            <th>CGST </th>
            <th>GST </th>
            <th>Cost Amount</th>
            <th>Staff ID</th>
          
            <th>Time</th>
           
     
            <th>Nav Cust.  Name</th>
            <th>Item Description</th>
        </tr>
         @foreach($data as $row=>$col)
    <?php  
$outlet_details=POS_SettingHelpers::get_outlet_details((int)$row);


 $date_data = DB::table('franchise_sales_details')
            ->leftJoin('franchise_sales','franchise_sales.id', '=','franchise_sales_details.sales_id')
            ->leftJoin('food_menus','food_menus.id', '=','franchise_sales_details.food_menu_id')
            ->where([['franchise_sales_details.outlet_id',$row],['franchise_sales_details.del_status', 'Live'],['franchise_sales.del_status', 'Live'],['franchise_sales.order_status',3]])
            ->whereBetween('sale_date', [$from, $to])
            ->select('food_menu_id','menu_name','code','sale_date','franchise_sales.id as sale_id','franchise_sales_details.id as franchise_sales_details_id','franchise_sales_details.qty as qty','discount_amount','menu_taxes','sale_no','order_type','franchise_sales_details.updated_at as updated_at','menu_unit_price','franchise_sales_details.user_id as user_id','customer_id')
            
            ->get(); 

    // dd($date_data);
       
 ?>
 @foreach($date_data as $d)
  <?php
                    $order_type = '';
                    if($d->order_type == 1){
                        $order_type = 'A';
                    }elseif($d->order_type == 2){
                        $order_type = 'B';
                    }elseif($d->order_type == 3){
                        $order_type = 'C';
                    }
        $price=POS_SettingHelpers::get_food_menu_cp($d->food_menu_id);


$gst_data=json_decode($d->menu_taxes);
$item_vat_amount_for_unit_item=$gst_data[0]->item_vat_amount_for_unit_item;

   
      
                    ?>

        <tr>
            <td style="border:1px solid black;">{{ $outlet_details->firm_name }} ({{$outlet_details->city}})</td>
          
            <td style="border:1px solid black;"> {{CustomHelpers::get_master_table_data('food_menu_categories','id',CustomHelpers::get_master_table_data('food_menus','id',$d->food_menu_id,'category_id'),'category_name')}} </td>

            
            <td style="border:1px solid black;">{{$order_type}} {{$d->sale_no}}</td>
            <td style="border:1px solid black;">{{CustomHelpers::get_master_table_data('food_menus','id',$d->food_menu_id,'code')}}</td>
            <td style="border:1px solid black;">{{CustomHelpers::get_master_table_data('food_menus','id',$d->food_menu_id,'name')}}</td>
            <td style="border:1px solid black;">{{$price['cp_without_gst']*$d->qty}}</td>
            <td style="border:1px solid black;"> {{date('Y-m-d', strtotime($d->updated_at))}}</td>
            <td style="border:1px solid black;">{{$d->qty}}</td>
         
            <td style="border:1px solid black;"><?php
                    $order_type = '';
                    if($d->order_type == 1){
                      echo 'Dine In';
                    }elseif($d->order_type == 2){
                       echo 'Take Away';
                    }elseif($d->order_type == 3){
                        echo 'Delivery';
                    }
                    ?></td>
           
            <td style="border:1px solid black;">{{$d->menu_unit_price}}</td>
            <td style="border:1px solid black;">{{$d->qty*$d->menu_unit_price}}</td>
            <td style="border:1px solid black;">{{$d->discount_amount}}</td>
            <td style="border:1px solid black;">{{((float)$item_vat_amount_for_unit_item*(float)$d->qty)/2}}</td>
            <td style="border:1px solid black;">{{((float)$item_vat_amount_for_unit_item*(float)$d->qty)/2}}</td>
            <td style="border:1px solid black;">{{(float)$item_vat_amount_for_unit_item*(float)$d->qty}}</td>
            <td style="border:1px solid black;">{{($d->qty*$d->menu_unit_price)-($d->discount_amount)}}</td>
            <td style="border:1px solid black;">{{CustomHelpers::get_master_table_data('users','id',$d->user_id,'name')}}</td>
          
            <td style="border:1px solid black;">{{date('h:i:sa', strtotime($d->updated_at))}}</td>
           
           
          
            <td style="border:1px solid black;">{{CustomHelpers::get_master_table_data('franchise_customers','id',$d->customer_id,'name')}}</td>
            <td style="border:1px solid black;">{{CustomHelpers::get_master_table_data('food_menus','id',$d->food_menu_id,'description')}}</td>
        </tr>

@endforeach

         @endforeach  
    
    </table>
</body>
</html>