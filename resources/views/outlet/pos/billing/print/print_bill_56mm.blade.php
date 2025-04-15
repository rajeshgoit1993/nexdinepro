<!doctype html>
<html>
<?php  

$sale_object=$data['sale_object'];
// dd($sale_object);
?>
<head>
    <meta charset="utf-8">
    <title>Invoice No: <?php echo POS_SettingHelpers::escape_output($sale_object->sale_no); ?></title>
    <script src="{{url('/resources/assets/pos')}}/assets/bower_components/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="{{url('/resources/assets/pos')}}/assets/bower_components/font-awesome/css/font-awesome.min.css">
    <script src="{{url('/resources/assets/pos')}}/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- <link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/dist/css/custom/size_56mm.css" media="all"> -->
    <link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/dist/css/custom/size_80mm.css" media="all">
    <link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/dist/css/custom/print_bill.css" media="all">

</head>

<body>
    <div id="wrapper" style="margin-right:15px ;margin-left: 10px;">

        <div id="receiptData">

            <div id="receipt-data">
                <div class="text-center">
                     <?php  


$outlet_details=POS_SettingHelpers::get_outlet_details((int)Sentinel::getUser()->parent_id);

                      ?>

   <h4 style="font-size:15px"><b>{{$outlet_details->firm_name}}</b></h4>
     <!-- <h4 style="margin:0px;font-size:15px"><b>Skyland D'Global Ltd.</b></h4> -->
                <!--    <p style="margin:0px;font-size:12px">
                         <?php echo $outlet_details->firm_name; ?>
                    </p>  -->
                    <p style="margin:0px;font-size:12px"><?php echo $outlet_details->outlet_address; ?></p>
                  
                    @if($outlet_details->gst!='')
                    <p style="margin:0px;font-size:12px">GST No. <?php echo $outlet_details->gst; ?></p>
                    @endif
                    <p style="margin:0px;font-size:12px">Phone No. <?php echo $outlet_details->mobile; ?></p>
                    <?php
                    $order_type = '';
                    if($sale_object->order_type == 1){
                        $order_type = 'A';
                    }elseif($sale_object->order_type == 2){
                        $order_type = 'B';
                    }elseif($sale_object->order_type == 3){
                        $order_type = 'C';
                    }
                    ?>

<table class="table" style="text-align: left;margin: 0px;font-size: 11px;"> 
<tr style="margin: 0px;">
    <td style="padding:2px">Date <?= POS_SettingHelpers::escape_output(date('d-m-Y', strtotime($sale_object->sale_date))); ?>  <?= POS_SettingHelpers::escape_output(date('H:i',strtotime($sale_object->order_time))) ?></td>
    <td style="padding:2px">Bill No. @if($sale_object->invoice_number!='')
<?= POS_SettingHelpers::escape_output($order_type.' '.$sale_object->invoice_number) ?>
               @else
<?= POS_SettingHelpers::escape_output($order_type.' '.$sale_object->sale_no) ?>
               @endif </td>
</tr>
</table>
<table class="table" style="text-align: left;margin: 0px;font-size: 11px;"> 
<tr style="margin: 0px;">
   <td style="padding:2px">Customer Name: <?php echo POS_SettingHelpers::escape_output("$sale_object->customer_name"); ?></td>
   <td style="padding:2px">Customer Number: <?php echo POS_SettingHelpers::escape_output("$sale_object->phone"); ?></td>
</tr>
<tr style="margin: 0px;">
   <td style="padding:2px">Cashier Name: <?php echo POS_SettingHelpers::escape_output($sale_object->user_name) ?> </td>
   <td style="padding:2px">Table No. <?php echo POS_SettingHelpers::escape_output($sale_object->table_name) ?></td>
</tr>
<tr style="margin: 0px;">
   <td style="padding:2px"></td>
   <td style="padding:2px">Token No. <?php echo POS_SettingHelpers::escape_output($sale_object->token_number) ?></td>
</tr>
</table>
     <p style="margin:0px;padding: 3px;text-align: center;border-top: 1px solid black;border-bottom: 1px solid black;">
         Order Type:  <?php
                    $order_type = '';
                    if($sale_object->order_type == 1){
                      echo 'Dine In';
                    }elseif($sale_object->order_type == 2){
                       echo 'Take Away';
                    }elseif($sale_object->order_type == 3){
                        echo 'Delivery';
                    }
                    ?>
     </p>            
                </div>
               <!-- <p>Date: 
                   
                  
               
                   <?= ($sale_object->waiter_name ? "<br>Waiter: <b>" . POS_SettingHelpers::escape_output($sale_object->waiter_name)."</b>" : '') ?>
                    <?php if($sale_object->customer_address!=NULL  && $sale_object->customer_address!=""){?>
                    <br />Address: <?php echo POS_SettingHelpers::escape_output("$sale_object->customer_address"); ?>
                    <?php } ?>
                    <?php if($sale_object->tables_booked){?>
                   <br />Table:
                    <b>
                        <?php
                    foreach ($sale_object->tables_booked as $key1=>$val){
                        echo POS_SettingHelpers::escape_output($val->table_name);
                        if($key1 < (sizeof($sale_object->tables_booked) -1)){
                            echo ", ";
                        }
                    }
                    ?>
                    </b>
                    <?php } ?>
                </p> -->

                <p><!-- <br>
                    Sales Associate: <br> -->
                  <!--  Customer: <b><?php echo POS_SettingHelpers::escape_output("$sale_object->customer_name"); ?></b> -->
                <!--    <?= ($sale_object->waiter_name ? "<br>waiter: <b>" . POS_SettingHelpers::escape_output($sale_object->waiter_name)."</b>" : '') ?>
                    <?php if($sale_object->customer_address!=NULL  && $sale_object->customer_address!=""){?>
                    <br />Address:<?php echo POS_SettingHelpers::escape_output("$sale_object->customer_address"); ?>
                    <?php } ?>
                    <?php if($sale_object->tables_booked){?>
                    <br />Table:<b>
                        <?php
                            foreach ($sale_object->tables_booked as $key1=>$val){
                                echo POS_SettingHelpers::escape_output($val->table_name);
                                if($key1 < (sizeof($sale_object->tables_booked) -1)){
                                    echo ", ";
                                }
                            }
                            ?>
                    </b>

                    <?php } ?> -->
                </p>
                
                <div class="ir_clear"></div>
                <table class="table table-condensed" style="font-size: 11px;">
                    <tbody>
                        <?php
                if (isset($sale_object->items)) {
                    $i = 1;
                    $totalItems = 0;
                    foreach ($sale_object->items as $row) {
                        $totalItems+=$row->qty;
                        $menu_unit_price = POS_SettingHelpers::getAmtP($row->menu_unit_price);
                        ?>

                        <tr>
                            <td class="no-border border-bottom ir_wid_70"># <?php echo POS_SettingHelpers::escape_output($i++); ?>:
                                &nbsp;&nbsp;<?php 
                                $menu_array=explode(" ",$row->menu_name);
                                $removed = array_pop($menu_array);
                                $menu_array=implode(" ",$menu_array);
                                echo POS_SettingHelpers::escape_output($menu_array); 
                                ?>
                                <small></small> <?php echo "$row->qty X $menu_unit_price"; ?>
                            </td>
                            <td class="no-border border-bottom text-right">
                               <!--  <?php echo POS_SettingHelpers::escape_output(POS_SettingHelpers::getAmt($row->menu_price_without_discount)); ?> -->
                                <?php echo POS_SettingHelpers::escape_output(POS_SettingHelpers::getAmt($row->qty*$row->menu_unit_price)); ?>
                            </td>
                        </tr>
                        <?php if(count($row->modifiers)>0){ ?>
                        <tr>
                            <td class="no-border border-bottom">Modifier:
                                <small></small>
                                <?php
                                    $l = 1;
                                    $modifier_price = 0;
                                    foreach($row->modifiers as $modifier){
                                        if($l==count($row->modifiers)){
                                            echo POS_SettingHelpers::escape_output($modifier->name);
                                        }else{
                                            echo POS_SettingHelpers::escape_output($modifier->name).',';
                                        }
                                        $modifier_price+=$modifier->modifier_price;
                                        $l++;
                                    }
                                    ?>
                            </td>
                            <td class="no-border border-bottom text-right">
                                <?php echo POS_SettingHelpers::escape_output(POS_SettingHelpers::getAmt($modifier_price)); ?></td>
                        </tr>
                        <?php } ?>
                        <?php }
                }
                ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total_Item_s: <?php echo POS_SettingHelpers::escape_output($totalItems); ?></th>
                            <th class="ir_txt_left"></th>
                        </tr>
                        <tr>
                           <th>Sub Total</th>
                            <th class="text-right">
                                <?php 
                                $total_subtotal=$sale_object->sub_total;
                                if($sale_object->total_item_discount_amount!='')
                                {
                                    $total_subtotal=$sale_object->sub_total+$sale_object->total_item_discount_amount;
                                }
                                echo POS_SettingHelpers::escape_output(POS_SettingHelpers::getAmt($total_subtotal)); 
                                ?>
                            </th>
                        </tr>
                        <?php
                            if($sale_object->total_discount_amount && $sale_object->total_discount_amount!="0.00"):
                        ?>
                        <tr>
                        <th>Disc Amt(%):</th>
                        <th class="text-right">
                            <?php echo POS_SettingHelpers::escape_output(POS_SettingHelpers::getAmt($sale_object->total_discount_amount)); ?>
                        </th>
                        </tr>
                        <?php
                        endif;
                        ?>
                        <?php

                        // if($sale_object->delivery_charge && $sale_object->delivery_charge!="0.00" && $sale_object->delivery_charge_actual_charge!="0" && $sale_object->delivery_charge_actual_charge):
                        if($sale_object->delivery_charge && $sale_object->delivery_charge!="0.00" && $sale_object->delivery_charge_actual_charge!="0"):

                           
                        ?>
                        <tr>
                       <th><?php echo $sale_object->charge_type; ?></th>
                        <th class="text-right">
                            <?php 
                              
                            echo POS_SettingHelpers::escape_output((POS_SettingHelpers::getPlanTextOrP($sale_object->delivery_charge))); ?>
                        </th>
                        </tr>
                         <?php
                        endif;
                        ?>
                        <?php
                        if ($sale_object->sale_vat_objects!=NULL):
                            ?>
                        <?php foreach(json_decode($sale_object->sale_vat_objects) as $single_tax){ ?>
                            <?php
                            if($single_tax->tax_field_amount && $single_tax->tax_field_amount!="0.00"):
                                ?>
                        <tr>
                            <th><!-- <?php echo POS_SettingHelpers::escape_output($single_tax->tax_field_type) ?> -->S-GST</th>
                            <th class="text-right">
                                <?php echo POS_SettingHelpers::escape_output(POS_SettingHelpers::getAmt($single_tax->tax_field_amount/2)); ?>
                            </th>
                        </tr>
                          <tr>
                            <th><!-- <?php echo POS_SettingHelpers::escape_output($single_tax->tax_field_type) ?> -->C-GST</th>
                            <th class="text-right">
                                <?php echo POS_SettingHelpers::escape_output(POS_SettingHelpers::getAmt($single_tax->tax_field_amount/2)); ?>
                            </th>
                        </tr>
                               
                                <?php
                                endif;
                                ?>
                        <?php } ?>

                        <?php
                        endif;
                        ?>
                     
                        <tr>
                          <th>Grand Total</th>
                            <th class="text-right">
                                <?php echo POS_SettingHelpers::escape_output(POS_SettingHelpers::getAmt(round($sale_object->total_payable))); ?>
                            </th>
                        </tr>
                        
                    </tfoot>
                </table>
              <!--   <table class="table table-striped table-condensed">
                    <tbody>
                        <tr>
                            <td>Total Payable</td>
                            <td class="text-right">
                                <?php echo POS_SettingHelpers::escape_output(POS_SettingHelpers::getAmt($sale_object->total_payable)); ?>
                            </td>
                        </tr>
                    </tbody>
                </table> -->
   <p class="text-center"> 
               Thank you for ordering with us. <br>
               Please visit us again.
                </p>

            </div>
            <div class="ir_clear"></div>
        </div>
<!-- 
        <div id="buttons"  class="no-print ir_pt_tr">
            <hr>
            <span class="pull-right col-xs-12">
                <button onclick="window.print();" class="btn btn-block btn-primary">Print</button> </span>
            <div class="ir_clear"></div>
            <div class="col-xs-12 ir_bg_p_c_red">
                <p class="ir_font_txt_transform_none">
                    Please follow these steps before you print for first time:
                </p>
                <p class="ir_font_capitalize">
                    1. Disable Header and Footer in browser's print setting<br>
                    For Firefox: File &gt; Page Setup &gt; Margins &amp; Header/Footer &gt; Headers & Footers &gt; Make
                    all --blank--<br>
                    For Chrome: Menu &gt; Print &gt; Uncheck Header/Footer in More Options
                </p>
            </div>
            <div class="ir_clear"></div>
        </div> -->
    </div>
    <script src="{{url('/resources/assets/pos')}}/assets/dist/js/print/jquery-2.0.3.min.js"></script>
    <script src="{{url('/resources/assets/pos')}}/assets/dist/js/print/custom.js"></script>
</body>

</html>