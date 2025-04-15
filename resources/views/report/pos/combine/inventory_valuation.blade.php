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
           <th>Inventory Valuation</th>
        </tr>
        <tr>
            <th>{{date('d-m-Y')}}</th>
        </tr>

        <tr></tr>
        <tr></tr>

        <tr>
            <th><?php echo $outlet_details->firm_name; ?></th>
        </tr>
        <tr>
            <th><?php echo $outlet_details->outlet_address; ?></th>
        </tr>

        <tr>
        
        </tr>

        <tr>
            <th colspan="2">Inventory Posting Group Name</th>
            <th></th>
            <th colspan="2">As of {{$from}}</th>
            <th colspan="2">Increases (LCY)</th>
            <th colspan="2">Decreases (LCY)</th>
            <th colspan="2">As of {{$to}}</th>
            <th></th>
        </tr>
        <tr>
            <th>Item No.</th>
            <th>Description</th>
            <th>Base <br> UoM</th>
            <th>Quantity</th>
            <th>Value</th>
            <th>Quantity</th>
            <th>Value</th>
            <th>Quantity</th>
            <th>Value</th>
             <th>Quantity</th>
            <th>Value</th>
            <th>Cost Posted <br> to G/L</th>
        </tr>

       @foreach($data as $d)
       <?php 
       
$outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
?>
<?php 
$item_code=CustomHelpers::get_master_table_data('master_products','id',$d->product_id,'item_code');
$product_id=$d->product_id;
$available_qty_now=$d->available_qty;
$consuption_sum_now=DB::table('franchise_sale_consuptions_of_menus')
         ->where([['outlet_id',(int)$outlet_id],['ingredient_id',(int)$product_id],['sync_status',0]])->sum('consumption');
          
$waste_sum_now=DB::table('waste_ingredients')
         
           ->where([['outlet_id',(int)$outlet_id],['ingredient_id',(int)$product_id],['sync_status',0]])->sum('waste_amount');
$total_waste_now=(float)$consuption_sum_now+(float)$waste_sum_now;
$return_now=(float)$available_qty_now-(float)$total_waste_now; 
//
$today=date('Y-m-d h:i:s');
$from=date('Y-m-d H:i:s',strtotime($from));
$to=date('Y-m-d h:i:s',strtotime($to));
$consuption_sum_from=DB::table('franchise_sale_consuptions_of_menus')
         ->where([['outlet_id',(int)$outlet_id],['ingredient_id',(int)$product_id]])->whereBetween('created_at', [$from, $today])->sum('consumption');
          
$waste_sum_from=DB::table('waste_ingredients')
         
           ->where([['outlet_id',(int)$outlet_id],['ingredient_id',(int)$product_id]])->whereBetween('created_at', [$from, $today])->sum('waste_amount');
$total_waste_from=(float)$consuption_sum_from+(float)$waste_sum_from;
//
$consuption_sum_to=DB::table('franchise_sale_consuptions_of_menus')
         ->where([['outlet_id',(int)$outlet_id],['ingredient_id',(int)$product_id]])->whereBetween('created_at', [$to, $today])->sum('consumption');
          
$waste_sum_to=DB::table('waste_ingredients')
         
           ->where([['outlet_id',(int)$outlet_id],['ingredient_id',(int)$product_id]])->whereBetween('created_at', [$to, $today])->sum('waste_amount');
$total_waste_to=(float)$consuption_sum_to+(float)$waste_sum_to;

$opening_from=(float)$return_now+(float)$total_waste_from;
$opening_to=(float)$return_now+(float)$total_waste_to;
//
$dailyPurchase_inc=DB::table('daily_purchase_ingredients')
         
           ->where([['outlet_id',(int)$outlet_id],['ingredient_id',(int)$product_id]])->whereBetween('created_at', [$to, $today])->sum('quantity_amount');

$dailyavg_price=DB::table('daily_purchase_ingredients')
         
           ->where([['outlet_id',(int)$outlet_id],['ingredient_id',(int)$product_id]])->whereBetween('created_at', [$to, $today])->avg('unit_price');


    ?>
            <tr>
                <td>{{$item_code}}</td>
                <td>{{CustomHelpers::get_master_table_data('master_products','id',$d->product_id,'product_name')}}</td>
                <td>{{CustomHelpers::get_master_table_data('master_products','id',$d->product_id,'item_type')}}</td>
                <td>{{$opening_from}}</td>
                <td>{{(float)$opening_from*(float)$dailyavg_price}}</td>
                <td>{{$dailyPurchase_inc}}</td>
                <td>{{(float)$dailyPurchase_inc*(float)$dailyavg_price}}</td>
                <td>{{(float)$opening_to-(float)$opening_from}}</td>
                <td>{{(float)((float)$opening_to-(float)$opening_from)*(float)$dailyavg_price}}</td>
                <td>{{$opening_to}}</td>
                <td>{{(float)$opening_to*(float)$dailyavg_price}}</td>
                <td>{{((float)$opening_to*(float)$dailyavg_price)-((float)$opening_from*(float)$dailyavg_price)}}</td>
            
            </tr>
         @endforeach

    </table>

</body>
</html>