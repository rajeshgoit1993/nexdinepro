
<html>
<table>



    <tr> 
    <th>Outlet Details</th> 
        <th>Date</th>
      
        
        <th>Item Code</th>
        <th>Item Type</th>
        <th>Product Name</th>
        <th>Description</th>
        <th>Unit</th>
        <th> Rate</th>
        <th>GST</th>
        <th>Threshold <br> qty</th>
        <th>Available <br> qty</th>
        <th>Auto Stock</th> 
        <th>Physical Stock</th>
        <th>Today Manual Update</th>
        <th>Remarks</th>
   
        
        
        

    </tr>
    @foreach($data as $d)
 
<?php
$date=date('Y-m-d');
$outlet_details=POS_SettingHelpers::get_outlet_details((int)$d->outlet_id);
 ?>
  <tr>
     <td style="background:white;text-align: center;border: 1px solid black">
{{ $outlet_details->name }} ({{$outlet_details->city}}) 
    </td>

  <td style="background:white;text-align: center;border: 1px solid black">{{date('d-m-Y')}}</td>
 <td style="background:white;text-align: center;border: 1px solid black">{{$d->item_code}}</td>
<td style="background:white;text-align: center;border: 1px solid black">{{$d->item_type}}</td>
 <td style="background:white;text-align: center;border: 1px solid black">{{$d->product_name}}</td>
 <td style="background:white;text-align: center;border: 1px solid black">{{$d->description}}</td>
 <td style="background:white;text-align: center;border: 1px solid black">
    {{CustomHelpers::get_master_table_data('units','id',$d->unit,'unit')}}
   
</td>
 <td style="background:white;text-align: center;border: 1px solid black">{{$d->franchise_rate}}</td>
 <td style="background:white;text-align: center;border: 1px solid black">
    {{CustomHelpers::get_master_table_data('master_gsts','id',$d->gst_id,'gst_name')}}
   </td>
 <td style="background:white;text-align: center;border: 1px solid black">{{$d->threshold_qty}}</td>
 <td style="background:white;text-align: center;border: 1px solid black">{{$d->available_qty}}</td>



 <?php 
$check_today_data=DB::table('physical_entries')->where([['outlet_id',$d->outlet_id],['ingredient_id',$d->item_code]])->whereDate('date',$date)->first();

?>
@if($check_today_data!='')
<td style="background:white;text-align: center;border: 1px solid black">
  
{{$check_today_data->auto_data}}
  
</td>
 <td style="background:white;text-align: center;border: 1px solid black">{{$check_today_data->physical_data}} </td>
 

 
 <td style="background:white;text-align: center;border: 1px solid black">Yes</td>
@else
<td style="background:white;text-align: center;border: 1px solid black">
  
{{$d->available_qty}}
  
</td>
 <td style="background:white;text-align: center;border: 1px solid black">{{$d->available_qty}} </td>
 

 
 <td style="background:white;text-align: center;border: 1px solid black">No</td>
@endif
 
 

<td style="background:white;text-align: center;border: 1px solid black">
  @if($d->item_code=='NA' || $d->item_code=='')  
  Item code blank maybe create issue while import pls inform area manager regarding this.
  @endif
</td>



  </tr>
    @endforeach
  
     
   
</table>

