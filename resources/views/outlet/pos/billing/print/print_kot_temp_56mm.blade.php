<?php 
 // $order_number = '';
 // if($sale_object->waiter_name){
 //    $order_number = 'A '.$sale_object->sale_no;
 // }elseif($sale_object->order_type=='2'){
 //    $order_number = 'B '.$sale_object->sale_no;
 // }elseif($sale_object->order_type=='3'){
 //    $order_number = 'C '.$sale_object->sale_no;    
 // }
$kot_info = $data['temp_kot_info']->temp_kot_info;
$kot_info = json_decode($kot_info);

// echo "<pre>";var_dump($kot_info);echo "</pre>";
// exit;
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice No: <?php echo POS_SettingHelpers::escape_output($kot_info->order_number); ?></title>
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
                  Invoice No<b>: </b><?php echo POS_SettingHelpers::escape_output($kot_info->order_number); ?><br>
                   Date: <?= date('d-m-Y', strtotime($kot_info->order_date)); ?><br>
                Customer:
                    <b><?php echo "$kot_info->customer_name"; ?> <?= isset($kot_info->tbl_name) && $kot_info->tbl_name ?'Table No'.": ".$kot_info->tbl_name : '' ?><br></b>
                   Waiter: <?php echo "$kot_info->waiter_name"; ?>,Order Type:
                    <?php echo "$kot_info->order_type"; ?><br>

                    
                   Time: <?php echo date('H:i:s A', strtotime($data['temp_kot_info']->created_at)); ?><br>

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
                            if (isset($kot_info->items)) {
                                $i = 1;
                                $totalItems = 0;
                                foreach ($kot_info->items as $row) {
                                    $totalItems+=$row->tmp_qty;
                                        if($row->tmp_qty):
                                    ?>
                        <tr>
                            <td><?php echo POS_SettingHelpers::escape_output($i++); ?></td>
                            <td>
                                 <?php 
                                $menu_array=explode(" ",$row->kot_item_name);
                                $removed = array_pop($menu_array);
                                $menu_array=implode(" ",$menu_array);
                                echo POS_SettingHelpers::escape_output($menu_array); 
                                ?>
                                
                                <!-- <?php echo POS_SettingHelpers::escape_output($row->kot_item_name) ?> <br> -->
                                <?php if($row->modifiers){ echo 'Modifiers'.":". $row->modifiers."<br>";}?>
                            </td>
                            <td class="ir_txt_center"><?php echo POS_SettingHelpers::escape_output($row->tmp_qty) ?> </td>
                        </tr>
                        <?php
                                endif;
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