
<html>
<table>
 
        
        <tr>
            <th colspan="9" style="text-align: center;background: white"><?php echo $outlet_details->firm_name; ?></th>
           
        </tr>

        <tr>
            <th colspan="9" style="text-align: center;background: white"><?php echo $outlet_details->outlet_address; ?><th>
           
        </tr>

     
@if($outlet_details->gst!='')
        <tr>
            <th colspan="9" style="text-align: center;background: white">GST No. <?php echo $outlet_details->gst; ?></th>
        </tr>
@else
<tr>
  <th colspan="9" style="text-align: center;background: white"></th>
</tr>
@endif
        <tr>
            <th colspan="9" style="text-align: center;background: white">Phone No. <?php echo $outlet_details->mobile; ?></th>
        </tr>

        <tr>
            <td colspan="9" style="background: white">From Date {{$from}} Till Date {{$to}}</td>
        </tr>

     


    <tr>  
        <th style="background:white;text-align: center;border: 1px solid black;">Date</th>
        
        <th style="background:white;text-align: center;border: 1px solid black;">Store Name</th>
        <th style="background:white;text-align: center;border: 1px solid black;">Name</th>
        <th style="background:white;text-align: center;border: 1px solid black;">Phone</th>
        <th style="background:white;text-align: center;border: 1px solid black;">Email</th>
        <th style="background:white;text-align: center;border: 1px solid black;">DOB</th>
        <th style="background:white;text-align: center;border: 1px solid black;">Anniversary</th>
        <th style="background:white;text-align: center;border: 1px solid black;">GST <br> Number</th>
        <th style="background:white;text-align: center;border: 1px solid black;">Address</th>
        
     
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
  <td style="background:white;text-align: center;border: 1px solid black;">{{$row}}</td>
  <td style="background:white;text-align: center;border: 1px solid black;">{{CustomHelpers::get_brand_name($outlet_details->brands)}} ({{$outlet_details->city}}) {{ $outlet_details->name }}</td>
  <td style="background:white;text-align: center;border: 1px solid black;">{{CustomHelpers::get_master_table_data('franchise_customers','id',$d->customer_id,'name')}}</td>
  <td style="background:white;text-align: center;border: 1px solid black;">{{CustomHelpers::get_master_table_data('franchise_customers','id',$d->customer_id,'phone')}}</td>
  <td style="background:white;text-align: center;border: 1px solid black;">{{CustomHelpers::get_master_table_data('franchise_customers','id',$d->customer_id,'email')}}</td>
  <td style="background:white;text-align: center;border: 1px solid black;">{{CustomHelpers::get_master_table_data('franchise_customers','id',$d->customer_id,'date_of_birth')}}</td>
  <td style="background:white;text-align: center;border: 1px solid black;">{{CustomHelpers::get_master_table_data('franchise_customers','id',$d->customer_id,'date_of_anniversary')}}</td>
  <td style="background:white;text-align: center;border: 1px solid black;">{{CustomHelpers::get_master_table_data('franchise_customers','id',$d->customer_id,'gst_number')}}</td>
  <td style="background:white;text-align: center;border: 1px solid black;">{{CustomHelpers::get_master_table_data('franchise_customers','id',$d->customer_id,'address')}}</td>

  </tr>
   @endforeach
   @endforeach
  
     
   
</table>

