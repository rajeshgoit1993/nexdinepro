<?php 
 $order_number = '';
 $order_type = '';
 
 if($data->order_type==1){
    $order_type = 'Dine In';
    $order_number = 'A '.$data->sale_no;
 }elseif($data->order_type=='2'){
    $order_type = 'Take Away';
    $order_number = 'B '.$data->sale_no;
 }elseif($data->order_type=='3'){
    $order_type = 'Delivery';
    $order_number = 'C '.$data->sale_no;    
 }



$tables_booked = '';
if(count($data->tables_booked)>0){
    $w = 1;
    foreach($data->tables_booked as $single_table_booked){
        if($w == count($data->tables_booked)){
            $tables_booked .= $single_table_booked->table_name;
        }else{
            $tables_booked .= $single_table_booked->table_name.', ';
        }
        $w++;
    }    
}

?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice No: <?= POS_SettingHelpers::escape_output($order_number) ?></title>
    <script src="{{url('/resources/assets/pos')}}/assets/bower_components/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="{{url('/resources/assets/pos')}}/assets/bower_components/font-awesome/css/font-awesome.min.css">
    <script src="{{url('/resources/assets/pos')}}/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/dist/css/custom/size_56mm.css" media="all">
    <link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/dist/css/custom/print_bill.css" media="all">

</head>

<body>
    <div id="wrapper" style="margin-right:15px ;margin-left: 10px;">
        <div id="receiptData">

            <div id="receipt-data">
                <div class="ir_txt_center">
                    <h3 class="ir_txt_center">KOT</h3>
                  Invoice No<b>: </b><?= POS_SettingHelpers::escape_output($order_number) ?><br>
                   Date: <?= date('d-m-Y', strtotime($data->sale_date)); ?><br>
                Customer:
                    <b><?php echo "$data->customer_name"; ?> <?= isset($data->tbl_name) && $data->tbl_name ?'Table No'.": ".$data->tbl_name : '' ?><br></b>
                   Waiter: <?php echo "$data->waiter_name"; ?>,Order Type:
                    <?php echo "$order_type"; ?><br>

                    
                   Time: <?php echo date('H:i:s A', strtotime($data->created_at)); ?><br>

                </div>

                <table class="table table-condensed">
                    <thead>
                        <tr class="ir_font_bold">
                            <td class="ir_w_5">SN</td>
                            <td class="ir_w_85">Item</td>
                            <td class="ir_w_10 ir_txt_center">Qty</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                            if (isset($data->items)) {
                                $i = 1;
                                $totalItems = 0;
                                foreach ($data->items as $row) {
                                    $totalItems+=$row->qty;
                                        // if($row->tmp_qty):

                                    ?>
                        <tr>
                            <td><?php echo POS_SettingHelpers::escape_output($i++); ?></td>
                            <td>
                          
                               <?php 
                                $menu_array=explode(" ",$row->menu_name);
                                $removed = array_pop($menu_array);
                                $menu_array=implode(" ",$menu_array);
                                echo POS_SettingHelpers::escape_output($menu_array); 
                                ?>
                                <!-- <?php echo POS_SettingHelpers::escape_output($row->menu_name) ?> <br> -->
                              

                                     <?php
                                                $modifiers_name = '';
                                                $j=1;
                                                if(count($row->modifiers)>0){
                                                    foreach($row->modifiers as $single_modifier){
                                                        if($j==count($row->modifiers)){
                                                            $modifiers_name .= $single_modifier->name;
                                                        }else{
                                                            $modifiers_name .= $single_modifier->name.',';
                                                        }
                                                        $j++;    
                                                    }
                                                    
                                                } 
                                            ?>
                                <?php

                                 if(count($row->modifiers)>0){ echo 'Modifiers'.":". $row->modifiers."<br>";}?>
                                <?php if($row->menu_note!=""){ echo 'Note'.":".$row->menu_note; }?>

                            </td>
                            <td class="ir_txt_center"><?php echo POS_SettingHelpers::escape_output($row->qty) ?> </td>
                        </tr>
                        <?php
                                // endif;
                                }
                            }
                            ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="ir_txt_center" colspan="6">Total Item(s): <?php echo POS_SettingHelpers::escape_output($totalItems); ?></th>
                        </tr>
                    </tfoot>
                </table>

            </div>
            <div class="ir_clear"></div>
        </div>

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
        </div>
    </div>
    <script src="{{url('/resources/assets/pos')}}/assets/dist/js/print/jquery-2.0.3.min.js"></script>
    <script src="{{url('/resources/assets/pos')}}/assets/dist/js/print/custom.js"></script>
    <script src="{{url('/resources/assets/pos')}}/frequent_changing/js/print_on_load.js"></script>
</body>

</html>