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
  <div class="flex-item-left"><h5>Add Purchase</h5></div>
  <div class="flex-item-right"><a href="{{URL::route('purchase')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
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
                        <div class="col-sm-12 col-md-6 mb-2 col-lg-3">
                            <div class="form-group">
                                <label>Supplier</label>
                                
                                <select class="form-control" name="supplier">
                                    <option value="">--Select Supplier--</option>
                                    @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                    @endforeach
                                </select>
                               
                            </div>
                          
                           
                        </div>

                         <div class="col-sm-12 col-md-6 mb-2 col-lg-3">
                            <div class="form-group">
                                <label>Invoice No</label>
                                <input tabindex="1" type="text" id="invoice_no"  name="invoice_no"
                                    class="form-control" placeholder="Invoice No"
                                    value="">
                            </div>
                          
                           
                        </div>

                        <div class="col-sm-12 col-md-6 mb-2 col-lg-3">
                            <div class="form-group">
                                <label>Date  <span class="required_star">*</span></label>
                                <input tabindex="3"  type="date" id="date" name="date" class="form-control"
                                    placeholder="Date" value="<?php echo date("Y-m-d",strtotime('today')); ?>">
                            </div>
                           
                        </div>
                        
                        <div class="col-sm-12 col-md-6 mb-2 col-lg-3">

                            <div class="form-group">
                                <label>Ingredients <span class="required_star">*</span></label>
                                <select  class="form-control select2  ir_w_100"
                                    name="ingredient_id" id="ingredient_id">
                                    <option value="">select</option>
                                    <?php foreach ($ingredients as $ingnts) { 
                                        $output='';
                                        foreach($gsts as $gst)
                                        {
                                            if((int)$ingnts->gst_id==$gst->id)
                                            {
$output.='<option value="'.$gst->gst_value.'" selected>'.$gst->gst_name.'</option>'; 
                                            }
                                            else
                                            {
                               $output.='<option value="'.$gst->gst_value.'">'.$gst->gst_name.'</option>';                  
                                            }
                                           
                                        }
                                        ?>
                                    <option gst_data="{{$output}}"
                                        value="<?php echo POS_SettingHelpers::escape_output($ingnts->id . "|" . $ingnts->product_name . " (" . $ingnts->item_code . ")|" . CustomHelpers::get_master_table_data('units','id',$ingnts->unit,'unit') . "|" . $ingnts->franchise_rate) ?>"
                                       >
                                        <?php echo POS_SettingHelpers::escape_output($ingnts->product_name . "(" . $ingnts->item_code . ")") ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                          
                            <div class="callout callout-danger my-2 error-msg ingredient_id_err_msg_contnr">
                                <p id="ingredient_id_err_msg"></p>
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
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

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
                                       id="grand_total"  value="">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="clearfix"></div>

                         <div class="col-md-8"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>G. Total GST  <span class="required_star">*</span></label>
                                <input class="form-control" required readonly type="text" name="total_gst_s"
                                       id="total_gst"  value="">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="clearfix"></div>

                       <div class="col-md-8"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>G. Total With GST  <span class="required_star">*</span></label>
                                <input class="form-control" required readonly type="text" name="total_with_gst_s"
                                       id="total_with_gst"  value="">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                      

                      <!--   <div class="col-md-8"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Paid  <span class="required_star">*</span></label>
                                <input tabindex="3" required class="form-control integerchk" type="text" name="paid"
                                       id="paid" onfocus="this.select();" onkeyup="return calculateAll()"
                                   value="">
                            </div>
                           
                            <div class="callout callout-danger my-2 error-msg paid_err_msg_contnr">
                                <p id="paid_err_msg"></p>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="clearfix"></div> -->
                        <!-- <div class="col-md-8"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Due</label>
                                <input class="form-control" type="text" name="due" id="due" readonly
                                   value="" >
                            </div>
                        </div>
                        <div class="col-md-1"></div> -->
                    </div>

                    <div class="row">

                        <input class="form-control" readonly type="hidden" name="subtotal" id="subtotal">

                    </div>
                </div>
                <input type="hidden" name="suffix_hidden_field" id="suffix_hidden_field" />
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-12 col-md-2 mb-2">
                            <button  type="submit" name="submit" value="submit"
                            class="btn btn-success bg-blue-btn w-100">Submit</button>
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