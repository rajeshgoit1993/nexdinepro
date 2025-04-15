@extends("layouts.backend.master")

@section('custom_js')
  <script src="{{url('/resources/assets/pos')}}/assets/POS/sweetalert2/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="{{url('/resources/assets/pos')}}/frequent_changing/js/add_food_menu_waste.js"></script>
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
  <div class="flex-item-left"><h5>Add Food Menu Waste</h5></div>
  <div class="flex-item-right"><a href="{{URL::route('waste')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
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
                        


                        <div class="col-sm-12 col-md-6 mb-2 col-lg-6">
                            <div class="form-group">
                                <label>Date  <span class="required_star">*</span></label>
                                <input tabindex="3"  type="date" id="date" name="date" class="form-control"
                                    placeholder="Date" value="<?php echo date("Y-m-d",strtotime($data->date)); ?>">
                            </div>
                           
                        </div>
                        
                        <div class="col-sm-12 col-md-6 mb-2 col-lg-6">

                            <div class="form-group">
                                <label>Food Menues <span class="required_star">*</span></label>
                                <select  class="form-control select2  ir_w_100"
                                    name="ingredient_id" id="ingredient_id">
                                    <option value="">select</option>
                                    <?php foreach ($data_food_menu as $food_menu) { 
                                       
                                        ?>
                                    <option 
                                        value="<?php echo POS_SettingHelpers::escape_output($food_menu->id . "|" . $food_menu->name . "(" . $food_menu->code . ")") ?>"
                                       > 
                                       <?php echo POS_SettingHelpers::escape_output($food_menu->name . "(" . $food_menu->code . ")") ?>
                                        </option>
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
                                            <th>Food Menu</th>
                                             <th>Quantity</th>   
                                               
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
  <?php
 $i = 0;
  ?>
                                    <tbody>
@foreach($food_menus as $row=>$col)
<?php
$i++;
  ?>
<tr class="rowCount" data-item_id="{{$col['food_menu_id']}}" data-id="{{$i}}" id="row_{{$i}}">
    <td style="padding-left: 10px;"><p id="sl_{{$i}}">{{$i}}</p></td>
    <td><span style="padding-bottom: 5px;">{{CustomHelpers::get_master_table_data('food_menus','id',$col['food_menu_id'],'name')}} ({{CustomHelpers::get_master_table_data('food_menus','id',$col['food_menu_id'],'code')}})</span></td>

    <input type="hidden" id="ingredient_id_{{$i}}" name="ingredient_id[]" value="{{$col['food_menu_id']}}">

    <td><input type="text" required="" data-countid="{{$i}}"  id="quantity_amount_{{$i}}" name="quantity_amount[]" onfocus="this.select();" class="form-control integerchk aligning countID" placeholder="Qty" value="{{$col['food_menu_qty']}}"><span class="label_aligning">Pcs</span></td>

    <td><a class="btn btn-danger btn-xs" style="margin-left: 5px; margin-top: 10px;" onclick="return deleter({{$i}},{{$col['food_menu_id']}});"><i style="color:white" class="fa fa-trash"></i> </a></td>

</tr>
@endforeach

                                    </tbody>
                                </table>
                            </div>

                             <label class="required">Remarks</label>
                            <textarea name="remarks" required class="form-control">{{$data->remarks}}</textarea>
                            <br>

                        </div>
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