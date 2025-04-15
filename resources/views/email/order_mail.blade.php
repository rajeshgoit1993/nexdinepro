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