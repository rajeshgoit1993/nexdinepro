<table class="table"> 

<tr>
    <td>Invoice No :
     {{$data->invoice_no}}</td>
    <td>Date :
<?php echo date("d-m-Y",strtotime($data->date)); ?></td>
<td>Supplier Name :
     {{CustomHelpers::get_master_table_data('local_suppliers','id',$data->supplier,'supplier_name')}}</td>
</tr>
</table>

 <table class="table">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Ingredient(Code)</th>
                                             <th>Quantity</th>   
                                                <th>Unit Price <span 
                                            
                                                    class="ir_c_transparent"></span></th>
                                           
                                            <th>Total</th>
                                                    <th style="width: 100px;">GST </th> 
                                                    <th>GST Amount</th>  
                                                    <th>Subtotal</th>  
                                           
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        

                                      
                                        $i = 0;
                                        if ($purchase_ingredients && !empty($purchase_ingredients)) {
                                            foreach ($purchase_ingredients as $pi) {
                                                $i++;
                                                echo '<tr class="rowCount"  data-id="' . $i . '" id="row_' . $i . '">' .
                                                '<td class="txt_19"> <p id="sl_' . $i . '">' . $i . '</p></td>' .
                                                '<td class="txt_18">' . CustomHelpers::get_master_table_data('master_products','id',$pi->ingredient_id,'product_name') . ' (' . CustomHelpers::get_master_table_data('master_products','id',$pi->ingredient_id,'item_code') . ')</span></td>' .
                                                '<td>' . $pi->quantity_amount . ' <span class="label_aligning">' .  CustomHelpers::get_master_table_data('units','id',CustomHelpers::get_master_table_data('master_products','id',$pi->ingredient_id,'unit'),'unit') . '</span></td>' .
                                                
                                                '<td>' . $pi->unit_price . '</td>' .
                                                 '<td>' . $pi->total . '</td>' .
                                                '<td>' . $pi->gst_percentage . '%</td>' .
                                                '<td>' . $pi->total_gst . '</td>' .
                                                '<td>' . $pi->total_with_gst . '</td>' .
                                                '</tr>'
                                                ;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>G. Total Without GST: </label>Rs. {{$data->grand_total}}
                              
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="clearfix"></div>
                        
                           <div class="col-md-6"></div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>G. Total GST: </label>Rs. {{$data->total_gst}}
                              
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="clearfix"></div>



                           <div class="col-md-6"></div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>G. Total With GST: </label>Rs. {{$data->total_with_gst}}
                              
                            </div>
                        </div>
                        <div class="col-md-1"></div>
  
  @if($data->note!='' && $data->note!='Online' && $data->note!='online')                     
<div class="col-md-12"> 
<p style="margin: 20px;">Remarks: {{$data->note}}</p>
  </div>
  @endif


                    </div>
