
<html>
<table>
  <tr>
            <th colspan="9" style="text-align: center;background: white">
                Combine Report Customers Details
            </th>
          
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
    <?php 
  
    ?>
    @foreach($data as $row=>$col)
    <?php  
 $excel_first_datas=DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3]])
                  ->whereIn('outlet_id',$ids_second) 
                 ->whereDate('sale_date',$row)
                 ->get()->groupBy('outlet_id');



 
    ?>
    @foreach($excel_first_datas as $second_row=>$second_col)
    <?php  
 $date_data=DB::table('franchise_sales')
                  ->where([['outlet_id',$second_row],['del_status', 'Live'],['franchise_sales.order_status',3]])
                  ->whereIn('outlet_id',$ids_second) 
                 ->whereDate('sale_date',$row)
                 ->get(); 
  $outlet_details=POS_SettingHelpers::get_outlet_details((int)$second_row);
  ?>
   @foreach($date_data as $d)

  <tr>
  <td style="background:white;text-align: center;border: 1px solid black;">{{$row}}</td>
  <td style="background:white;text-align: center;border: 1px solid black;">{{ $outlet_details->firm_name }} ({{$outlet_details->city}})</td>
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
    @endforeach
  
     
   
</table>

