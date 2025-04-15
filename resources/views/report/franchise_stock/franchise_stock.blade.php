@if($type=='outlet')
<html>
<table>



    <tr>  
        
        <th>Date</th>
        <th>Item Code</th>
        
        <th>Product Name</th>
        <th>Unit</th>
        <!-- <th>Auto Stock</th> -->
        <th>Physical Stock</th>
        <th>Today Manual Update</th>
        <th>Remarks</th>

    </tr>
    @foreach($data as $d)


  <tr>
    <th>{{date('d-m-Y')}}</th>
    <?php 
$item_code=CustomHelpers::get_master_table_data('master_products','id',$d->product_id,'item_code');
    ?>
    <td>{{$item_code}} </td>
    <td>{{CustomHelpers::get_master_table_data('master_products','id',$d->product_id,'product_name')}} </td>

     <td>{{CustomHelpers::get_master_table_data('units','id',CustomHelpers::get_master_table_data('master_products','id',$d->product_id,'unit'),'unit')}}</td>

<?php 
$check_today_data=DB::table('physical_entries')->where([['outlet_id',$d->outlet_id],['ingredient_id',$d->product_id]])->whereDate('date',date('Y-m-d'))->first();
?>
@if($check_today_data!='')
<!-- <td> {{$check_today_data->auto_data}} </td> -->
 
  <td> {{$check_today_data->physical_data}} </td>
  <td> Yes </td>
@else
<!-- <td> {{$d->available_qty}}</td> -->
 
  <td> 0 </td>
  <td> No </td>
@endif
  
<td>
  @if($item_code=='NA' || $item_code=='')  
  Item code blank maybe create issue while import pls inform area manager regarding this.
  @endif
</td>
 



  </tr>
    @endforeach
  
     
   
</table>
@else
<html>
<table>



    <tr>  
        <th>Outlet ID</th>
        <th>Outlet Details</th>
        <th>Date</th>
        <th>Item Code</th>
        
        <th>Product Name</th>
        <th>Unit</th>
        <th>Auto Stock</th>
        <th>Physical Stock</th>
        <th>Today Manual Update</th>
        <th>Remarks</th>

    </tr>
    @foreach($data as $d)
<?php 
$outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
?>

  <tr>
    <th>{{$outlet_id}}</th>
    <th>
{{CustomHelpers::get_brand_name($outlet_details->brands)}} ({{$outlet_details->city}}) {{ $outlet_details->name }}
    </th>
    <th>{{$date}}</th>
    <?php 
$item_code=CustomHelpers::get_master_table_data('master_products','id',$d->product_id,'item_code');
    ?>
    <td>{{$item_code}} </td>
    <td>{{CustomHelpers::get_master_table_data('master_products','id',$d->product_id,'product_name')}} </td>

     <td>{{CustomHelpers::get_master_table_data('units','id',CustomHelpers::get_master_table_data('master_products','id',$d->product_id,'unit'),'unit')}}</td>

<?php 
$check_today_data=DB::table('physical_entries')->where([['outlet_id',$outlet_id],['ingredient_id',$d->product_id]])->whereDate('date',$date)->first();
?>
@if($check_today_data!='')
<td> {{$check_today_data->auto_data}} </td>
 
  <td> {{$check_today_data->physical_data}} </td>
  <td> Yes </td>
@else
<td> {{$d->available_qty}}</td>
 
  <td> {{$d->available_qty}} </td>
  <td> No </td>
@endif
  
<td>
  @if($item_code=='NA' || $item_code=='')  
  Item code blank maybe create issue while import pls inform area manager regarding this.
  @endif
</td>
 



  </tr>
    @endforeach
  
     
   
</table>
@endif
