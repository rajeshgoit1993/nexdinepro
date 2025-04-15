<!DOCTYPE html>
<html>
    <head>
        <title>Order Invoice</title>
        <style>
            table, th, td {
                border: 1px solid black;
               padding: 2px;
                outline: none;
               border-collapse: collapse;
               font-size: 12px;
            }
           
        </style>
        <style>
.page-break {
    page-break-after: always;
}
</style>
    </head>
    <body>
       
    <h5 style="text-align:center;">TAX INVOICE</h5>
        <table style="width:100%;"cellspacing="0">
       
        <tr>
            <td rowspan="3">
            	<strong>Skyland D Global</strong><br> 
      162, G Block<br> 
Sector 63 Noida<br>
GSTIN/UIN: 09AJKPK9305M1ZN<br>
State Name : Uttar Pradesh, Code : 09<br>
Contact : 9999117639<br>
E-Mail : accounts@skyland.group</td>
         
            <td>Invoice No.: {{$data->id}}</td>
            <td>Dated: {{date("d-m-Y", strtotime($data->created_at))}}</td>
           
        </tr>
       
        <tr>
           
         
            <td>Delivery Note</td>
            <td>Mode/Terms of Payment</td>
           
        </tr>
        <tr>
          
            <td>Reference No. & Date</td>
            <td>Other References</td>
           
        </tr>
       
         <tr>
            <td rowspan="3">
            	Consignee (Ship to)<br>
            <strong>{{$fanchise_detail->name}}</strong><br>
       {{$fanchise_detail->address}}<br>
         {{$fanchise_detail->state}}<br>
         {{$fanchise_detail->dist}}<br>
          {{$fanchise_detail->city}}<br>
          Email: {{$fanchise_detail->email }}<br>
          Mobile: {{$fanchise_detail->mobile }}</td>
         
            <td>Buyer's Order No.</td>
            <td>Dated</td>
           
        </tr>
       
        <tr>
           
         
            <td>Dispatch Doc No.</td>
            <td>Delivery Note Date</td>
           
        </tr>
        <tr>
          
            <td>Dispatched through</td>
            <td>Destination</td>
           
        </tr>
          <tr>
          <td rowspan="3">
               Buyer (Bill to) <br>
              <strong>{{$fanchise_detail->name}}</strong><br>
       {{$fanchise_detail->address}}<br>
         {{$fanchise_detail->state}}<br>
         {{$fanchise_detail->dist}}<br>
          {{$fanchise_detail->city}}<br>
          Email: {{$fanchise_detail->email }}<br>
          Mobile: {{$fanchise_detail->mobile }}</td>
         
            <td  style="border-style: none;">Terms of Delivery</td>
            <td  style="border-style: none;"></td>
           
        </tr>
       
        <tr>
           
         
              <td style="border-style: none;"></td>
            <td style="border-style: none;"></td>

           
        </tr>
        <tr>
          
            <td style="border-style: none;"></td>
            <td style="border-style: none;"></td>
           
        </tr>
        </table>
     <!---->
      <table style="width:100%;"cellspacing="0">
       
        <tr>
    <th>S.No.</th>
    <th>Description of Goods</th>
    <th>HSN/SAC</th>
    <th>Quantity</th>
    <th>Rate</th>
   
    <th>Transport</th>
    <th>per</th>
    <th>Amount</th>
  </tr>
        <?php 
$details_orders=DB::table('order_item_details')->where('order_id','=',$data->id)->get();
$total=0;
$total_without_gst=0;
$total_with_gst=0;
$sn=1;
?>

 @foreach($details_orders as $orders)
        <tr>
           <td style="border-style:none;text-align: center;">{{$sn++}}</td>
           <td style="border-style:none;">{{$orders->product_name}}</td>
            <td style="border-style:none;text-align: center;">   {{CustomHelpers::get_master_table_data('master_products','id',$orders->product_id,'initial_qty')}} </td>
            <td style="border-style:none;text-align: center;">{{$orders->order_confirm_qty}}</td>
            <td style="border-style:none;text-align: center;">Rs. {{$orders->product_rate}} </td>
         
           
            <td style="border-style:none;text-align: center;">Rs. {{$orders->order_qty*$orders->transport_rate}}</td>
             <td style="border-style:none;text-align: center;">{{CustomHelpers::get_master_table_data('units','id',$orders->unit_id,'unit')}}  </td>
            <td style="border-style:none;">
            <?php 
             $qty_total=$orders->order_confirm_qty*$orders->product_rate;
             $transport_total=$orders->order_confirm_qty*$orders->transport_rate; 
             $total=$qty_total+$transport_total;
             $gst_total=$orders->order_confirm_qty*$orders->product_rate*$orders->gst_id/100; 
            ?>
              Rs.  {{$total}}
            </td>
        </tr>
        <?php 
$total_without_gst=$total_without_gst+$total;
$total_with_gst=$total_with_gst+$total+$gst_total;
        ?>
     @endforeach   
       <tr>
           <td style="border-style:none;"></td>
           <td style="border-style:none;"></td>
            <td style="border-style:none;"></td>
            <td style="border-style:none;"></td>
            <td style="border-style:none;"></td>
           
           
            <td style="border-style:none;"></td>
             <td style="border-style:none;"></td>
            <td  style="border-style:none;">
                <hr>
           Rs. {{$total_without_gst}}
            </td>
        </tr>
      <?php 
   $gst_data = DB::table('order_item_details')
               ->where([['order_id','=',$data->id],['order_confirm_qty','>',0]])
               ->get()
              ->groupBy('gst_id');
             
       ?>
          @if($data->gst_type==1)
@foreach($gst_data as $row=>$col)
<?php
$total_gst=0;

 ?>
  <tr>
           <td style="border-style:none;"></td>
           <td style="border-style:none;text-align: right;font-weight: bold;font-style: italic;">
               
               I-GST {{$row}} %
           </td>
            <td style="border-style:none;"></td>
            <td style="border-style:none;"></td>
            <td style="border-style:none;text-align: center;">
            {{$row}}
            </td>
           
           
            <td style="border-style:none;">
           
            </td>
             <td style="border-style:none;text-align: center;">
               %
             </td>
            <td  style="border-style:none;">
              @foreach($col as $gst) 
              <?php
               $total_gst=$total_gst+$gst->order_confirm_qty*$gst->product_rate*$gst->gst_id/100;
               ?>
              @endforeach
             Rs. {{$total_gst}}
            </td>
 </tr>
@endforeach
           @else
@foreach($gst_data as $row=>$col)
<?php
$total_gst=0;

 ?>
  <tr>
           <td style="border-style:none;"></td>
           <td style="border-style:none;text-align: right;font-weight: bold;font-style: italic;">
               
                Output C-GST {{$row/2}} %<br>  
               Output S-GST  {{$row/2}} %
           </td>
            <td style="border-style:none;"></td>
            <td style="border-style:none;"></td>
            <td style="border-style:none;text-align: center;">
            {{$row/2}}<br>
            {{$row/2}}
            </td>
           
           
            <td style="border-style:none;">
           
            </td>
             <td style="border-style:none;text-align: center;">
               %<br> %
             </td>
            <td  style="border-style:none;">
              @foreach($col as $gst) 
              <?php
               $total_gst=$total_gst+$gst->order_confirm_qty*$gst->product_rate*$gst->gst_id/200;
               ?>
              @endforeach
             Rs. {{$total_gst}} <br>Rs. {{$total_gst}}
            </td>
 </tr>
@endforeach
           @endif
              <tr>
           <td style="border-style:none;"></td>
           <td style="border-style:none;text-align: right;font-weight: bold;font-style: italic;">Rounded Off</td>
            <td style="border-style:none;"></td>
            <td style="border-style:none;"></td>
            <td style="border-style:none;"></td>
           
           
            <td style="border-style:none;"></td>
             <td style="border-style:none;"></td>
            <td  style="border-style:none;">
                <hr>
           Rs. {{round(round($total_with_gst)-$total_with_gst,2)}}
            </td>
        </tr>

            <tr>
           <td></td>
           <td style="text-align: right;font-weight: bold;font-style: italic;">Total</td>
            <td></td>
            <td></td>
            <td></td>
           
           
            <td></td>
             <td></td>
            <td >
             
           Rs. {{round($total_with_gst)}}
            </td>
        </tr>
         <td colspan="4" style="border-style:none;text-align:left;"> Amount Chargeable (in words) </td>
         <td colspan="4" style="border-style:none;text-align:right;">
            E. & O.E
         </td>

         <tr>
            </tr>
         <td colspan="4" style="border-style:none;text-align:left;"> Indian Rupees <?php
$class_obj_first = new numbertowordconvertsconver();
$convert_number_first = round($total_with_gst);
echo $class_obj_first->convert_number($convert_number_first);
?> Only</td>
         <td colspan="4" style="border-style:none;text-align:left;">
            Company's Bank Details
         </td>

         <tr>

             </tr>
         <td colspan="4" style="border-style:none;text-align:left;">

         Declaration<br>

         Terms and conditions :<br>
 1 - This is an electronic generated invoice.<br>
 2- All Disputes are subject to Noida jurisdiction.<br>
 3- Transport Charges will be Extra.<br>
 4- 100% Advance payment Require
  </td>
         <td colspan="4" style="border-style:none;text-align:left;">
       
        A/c Holder's Name : <strong>Skyland D Global</strong><br>
        Bank Name : <strong>ICICI Bank</strong><br>
        A/c No. : <strong>165405500223</strong><br>
        Branch & IFS Code : <strong>NOIDA & ICIC0001654</strong><br>
        SWIFT Code :
         </td>

         </tr>
          <tr>
         <td colspan="4" style="border-style:none;text-align:left;"> </td>
         <td colspan="4" style="text-align:right;">
           <strong>for Skyland D Global</strong><br><br>
           Authorised Signatory
         </td>

         </tr>
        </table>

        <div class="page-break"></div>
 <h5 style="text-align:center;margin-bottom: 0px;padding-bottom: 0px;">TAX INVOICE</h5>
<h6 style="text-align:center;margin-top: 0px;padding-top: 0px;">(Tax Analysis)</h6>
 <table style="width:100%;"cellspacing="0">
    <tr>
        <td colspan="4" style="border-style:none;text-align:left;">Invoice No. {{$data->id}}</td>
        <td style="border-style:none;text-align:right;">Dated {{date("d-m-Y", strtotime($data->created_at))}}</td>
    </tr>
    <tr>
        
        <td colspan="5"  style="border-style:none;text-align:center;">
           <strong> Skyland D Global</strong> <br>
162, G Block <br>
Sector 63 Noida <br>
GSTIN/UIN: 09AJKPK9305M1ZN <br>
State Name : Uttar Pradesh, Code : 09 <br>
Contact : 9999117639 <br>
E-Mail : accounts@skyland.group <br><br>

<strong>{{$fanchise_detail->name}}</strong><br>
       {{$fanchise_detail->address}}<br>
         {{$fanchise_detail->state}}<br>
         {{$fanchise_detail->dist}}<br>
          {{$fanchise_detail->city}}<br>
          Email: {{$fanchise_detail->email }}<br>
          Mobile: {{$fanchise_detail->mobile }}
        </td>

    </tr>
    <tr>
        <td rowspan="2">HSN/SAC</td>
        <td rowspan="2">Taxable  Value</td>

        <td colspan="2">Integrated Tax</td>
        <td rowspan="2">Total Tax Amount</td>
    </tr>
    <tr>
       

        <td>Rate</td>
        <td >Amount</td>
    </tr>
    <?php 
    $total_tax=0; 
  $total_taxable_amount=0; 
    ?>
    @foreach($details_orders as $orders)
        <tr>
          
             <td style="border-style:none;text-align: left;">{{CustomHelpers::get_master_table_data('master_products','id',$orders->product_id,'initial_qty')}}</td>
            <td style="border-style:none;">
            <?php 
             $qty_total=$orders->order_confirm_qty*$orders->product_rate;
            
            ?>
              Rs.  {{$qty_total}}
            </td>
               <td style="border-style:none;text-align: left;">{{$orders->gst_id}} %</td>
               <td style="border-style:none;text-align: left;">Rs. {{$orders->order_confirm_qty*$orders->product_rate*$orders->gst_id/100}}</td>
                <td style="border-style:none;text-align: left;">Rs. {{$orders->order_confirm_qty*$orders->product_rate*$orders->gst_id/100}}</td>
        </tr>
        <?php 
    $tax_val=$orders->order_confirm_qty*$orders->product_rate*$orders->gst_id/100;
$total_tax=$total_tax + $tax_val;
$total_taxable_amount=$total_taxable_amount+$qty_total;
        ?>
     @endforeach  
 <tr>
          
             <td style="text-align: right;">Total</td>
            <td style="">
             Rs. {{$total_taxable_amount}}
            </td>
               <td style="text-align: left;"></td>
               <td style="text-align: left;">Rs. {{ round($total_tax)}}</td>
                <td style="text-align: left;">Rs. {{ round($total_tax)}}</td>
        </tr>
        <tr>
            <td colspan="5" style="border-style:none;text-align:left;">
                Tax Amount (in words) :  <?php
$class_obj = new numbertowordconvertsconver();
$convert_number = round($total_tax);
echo $class_obj->convert_number($convert_number);
?>  
            </td>

        </tr>
 <tr>
         <td colspan="3" style="border-style:none;text-align:left;"> </td>
         <td colspan="2" style="text-align:right;">
           <strong>for Skyland D Global</strong><br><br>
           Authorised Signatory
         </td>

         </tr>
 </table>
 <?php 
function moneyFormatIndia($num) {
    $explrestunits = "" ;
    if(strlen($num)>3) {
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++) {
            // creates each of the 2's group and adds a comma to the end
            if($i==0) {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            } else {
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash; // writes the final format where $currency is the currency symbol.
}

 
class numbertowordconvertsconver {
  function convert_number($number) 
  {
    if (($number < 0) || ($number > 999999999)) 
    {
      throw new Exception("Number is out of range");
    }
    $giga = floor($number / 1000000);
    // Millions (giga)
    $number -= $giga * 1000000;
    $kilo = floor($number / 1000);
    // Thousands (kilo)
    $number -= $kilo * 1000;
    $hecto = floor($number / 100);
    // Hundreds (hecto)
    $number -= $hecto * 100;
    $deca = floor($number / 10);
    // Tens (deca)
    $n = $number % 10;
    // Ones
    $result = "";
    if ($giga) 
    {
      $result .= $this->convert_number($giga) .  "Million";
    }
    if ($kilo) 
    {
      $result .= (empty($result) ? "" : " ") .$this->convert_number($kilo) . " Thousand";
    }
    if ($hecto) 
    {
      $result .= (empty($result) ? "" : " ") .$this->convert_number($hecto) . " Hundred";
    }
    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
    if ($deca || $n) {
      if (!empty($result)) 
      {
        $result .= " and ";
      }
      if ($deca < 2) 
      {
        $result .= $ones[$deca * 10 + $n];
      } else {
        $result .= $tens[$deca];
        if ($n) 
        {
          $result .= "-" . $ones[$n];
        }
      }
    }
    if (empty($result)) 
    {
      $result = "zero";
    }
    return $result;
  }
}
?>
    </body>
</html>                    