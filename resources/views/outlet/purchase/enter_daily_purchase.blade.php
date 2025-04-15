@extends("layouts.backend.master")

@section('custom_js')
  <script src="{{url('/resources/assets/pos')}}/assets/POS/sweetalert2/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="{{url('/resources/assets/pos')}}/frequent_changing/js/add_purchase.js"></script>
@endsection
@section('maincontent')
<style type="text/css">
   .ir_c_transparent {
    color: transparent !important;
}
.select2-container .select2-selection--single
{
   height: 38px !important;
}
</style>
<link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/POS/sweetalert2/dist/sweetalert.min.css">
<link rel="stylesheet" href="{{url('/resources/assets/pos')}}/frequent_changing/css/add_purchase.css">


<input type="hidden" id="ingredient_already_remain" value="Ingredient already remains in cart, you can change Quantity/Amount">

<input type="hidden" id="date_field_required" value="The Date field is required.">
<input type="hidden" id="at_least_ingredient" value="At least 1 Ingredient is required.">
<input type="hidden" id="paid_field_required" value="The Paid field is required.">

<input type="hidden" id="are_you_sure" value="Are you sure">
<input type="hidden" id="alert" value="Alert">



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
	<section class="col-lg-12 connectedSortable">
	<div class="card direct-chat direct-chat-primary">
		<div class="flex-container">
  <div class="flex-item-left"><h5>Enter Purchase Details</h5></div>
  <div class="flex-item-right"><a href="{{URL::route('approved_purchase')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
</div>


</div>
@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
@if(Session::get('error'))
<div class="alert alert-danger" role="alert">
  {{ Session::get('error') }}
</div>
@endif
</section>
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<!-- /.content -->

<!---->
{!! Form::open(["files"=>true])!!}
<div class="row"> 
<div class="col-lg-12">

<div class="box-wrapper">
            
            <div class="table-box">
               
                <div>
                    <div class="row">

                         <div class="col-sm-12 col-md-6 mb-2 col-lg-4">
                            <div class="form-group">
                                <label>Supplier</label>
                                
                                <select class="form-control" name="supplier">
                                    <option value="">--Select Supplier--</option>
                                    @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}" @if($supplier->id==$data->supplier) selected @endif>{{$supplier->supplier_name}}</option>
                                    @endforeach
                                </select>
                               
                            </div>
                          
                           
                        </div>
                          <div class="col-sm-12 col-md-6 mb-2 col-lg-4">
                            <div class="form-group">
                                <label>Invoice No</label>
                                <input tabindex="1" type="text" id="invoice_no"  name="invoice_no"
                                    class="form-control" placeholder="Invoice No"
                                    value="{{$data->invoice_no}}">
                            </div>
                          
                           
                        </div>
                       <!--  <div class="col-sm-12 col-md-6 mb-2 col-lg-4">
                            <div class="form-group">
                                <label>Reference No</label>
                                <input tabindex="1" type="text" id="reference_no" readonly name="reference_no"
                                    class="form-control" placeholder="Reference No"
                                    value="{{$data->reference_no}}">
                            </div>
                          
                           
                        </div> -->

                        

                        <div class="col-sm-12 col-md-6 mb-2 col-lg-4">
                            <div class="form-group">
                                <label>Date  <span class="required_star">*</span></label>
                                <input tabindex="3"  type="date" id="date" name="date" class="form-control"
                                    placeholder="Date" value="<?php echo date("Y-m-d",strtotime($data->date)); ?>">
                            </div>
                           
                        </div>
                        
                       

                    
                        
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" id="purchase_cart">
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

 $gst_data='';
                                        foreach($gsts as $gst)
                                        {
                                            if((int)$pi->gst_percentage==$gst->gst_value)
                                            {
$gst_data.='<option value="'.$gst->gst_value.'" selected>'.$gst->gst_name.'</option>'; 
                                            }
                                            else
                                            {
                               $gst_data.='<option value="'.$gst->gst_value.'">'.$gst->gst_name.'</option>';                  
                                            }
                                           
                                        }

                                                echo '<tr class="rowCount" data-item_id="' . $pi->ingredient_id . '" data-id="' . $i . '" id="row_' . $i . '">' .
                                                '<td class="txt_19"> <p id="sl_' . $i . '">' . $i . '</p></td>' .
                                                '<td class="txt_18">' . CustomHelpers::get_master_table_data('master_products','id',$pi->ingredient_id,'product_name') . ' (' . CustomHelpers::get_master_table_data('master_products','id',$pi->ingredient_id,'item_code') . ')</span></td>' .
                                                '<input type="hidden" id="ingredient_id_' . $i . '" name="ingredient_id[]" value="' . $pi->ingredient_id . '"/>' .

                                                '<td><input type="text" readonly data-countID="' . $i . '" id="quantity_amount_' . $i . '" name="quantity_amount[]" onfocus="this.select();" class="form-control integerchk aligning countID" class="ir_w_85" placeholder="Qty/Amount" value="' . $pi->quantity_amount . '"  onkeyup="return calculateAll();" ><span class="label_aligning">' .  CustomHelpers::get_master_table_data('units','id',CustomHelpers::get_master_table_data('master_products','id',$pi->ingredient_id,'unit'),'unit') . '</span></td>' .

                                                '<td><input type="text" readonly id="unit_price_' . $i . '" name="unit_price[]" onfocus="this.select();" class="form-control integerchk aligning" placeholder="Unit Price" value="' . $pi->unit_price . '" onkeyup="return calculateAll();"/></td>' .

                                                
                                                '<td><input type="text" id="total_' . $i . '" name="total[]" class="form-control integerchk aligning" placeholder="Total" value="' . $pi->total . '" readonly/></td>' .

                '<td><select required  id="gst_percentage_'.$i.'"  name="gst_percentage[]" onfocus="this.select();" class="form-control" readonly onchange="return calculateAll();"><option selected value="'.$pi->gst_percentage.'">'.$pi->gst_percentage.' %</option></select>  </td>' .

 '<td><input type="text" id="total_gst_'.$i.'" name="total_gst[]" class="form-control aligning" placeholder="Total GST" readonly value="' . $pi->total_gst . '"/></td>' .

  '<td><input type="text" id="total_with_gst_'.$i.'" name="total_with_gst[]" class="form-control aligning" placeholder="Total With GST" readonly value="' . $pi->total_with_gst . '"/></td>' .

                                             
                                                '</tr>'
                                                ;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>G. Total Without GST <span class="required_star">*</span></label>
                                <input class="form-control" required readonly type="text" name="grand_total"
                                       id="grand_total"  value="{{$data->grand_total}}">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="clearfix"></div>

                         <div class="col-md-8"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>G. Total GST  <span class="required_star">*</span></label>
                                <input class="form-control" required readonly type="text" name="total_gst_s"
                                       id="total_gst"  value="{{$data->total_gst}}">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="clearfix"></div>

                          <div class="col-md-8"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>G. Total With GST  <span class="required_star">*</span></label>
                                <input class="form-control" required readonly type="text" name="total_with_gst_s"
                                       id="total_with_gst"  value="{{$data->total_with_gst}}">
                            </div>
                        </div>
                        <div class="col-md-1"></div>

                        <!-- <div class="col-md-8"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Paid  <span class="required_star">*</span></label>
                                <input tabindex="3" required class="form-control integerchk" type="text" name="paid"
                                       id="paid" onfocus="this.select();" onkeyup="return calculateAll()"
                                   value="{{$data->paid}}">
                            </div>
                           
                            <div class="callout callout-danger my-2 error-msg paid_err_msg_contnr">
                                <p id="paid_err_msg"></p>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="clearfix"></div> -->
                       <!--  <div class="col-md-8"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Due</label>
                                <input class="form-control" type="text" name="due" id="due" readonly
                                   value="{{$data->due}}" >
                            </div>
                        </div>
                        <div class="col-md-1"></div> -->
                    </div>

                    <div class="row">

                        <input class="form-control" readonly type="hidden" name="subtotal" id="subtotal" value="{{$data->subtotal}}">

                    </div>
                </div>
                <input type="hidden" name="suffix_hidden_field" id="suffix_hidden_field" />
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-12 col-md-2 mb-2">
                            <button  type="submit" name="submit" value="submit"
                            class="btn btn-success bg-blue-btn w-100">Update</button>
                        </div>
                       
                    </div>
                
                   
                </div>
               
            </div>
        </div>


 </div>


</div>



{!! Form::close() !!}








<!-- /.content -->
</div>
</section>

</div>

</div>
</section>

</div>
@endsection
@section('custom_js')

@endsection