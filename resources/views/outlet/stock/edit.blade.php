
{!! Form::open(["files"=>true,'id'=>'update_product_list'])!!}

<input type="hidden" name="id" value="{{CustomHelpers::custom_encrypt($data->id)}}">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">


</div>
<div class="modal-body">
<div class="row">
 <div class="col-lg-6">
        <div class="form-group">
<label for="" >Date</label>
<input type="date" name="date" value="{{date('Y-m-d')}}" max="{{date('Y-m-d')}}" min="{{date('Y-m-d')}}" class="form-control"> 
</div>

<div class="form-group upload_form">
  
</div>


    </div>

<div class="col-lg-6">
<div class="form-group">
<label for="" >Product Name</label>
<?php 
$product_name=CustomHelpers::get_master_table_data('master_products','id',$data->product_id,'product_name');
?>
{!! Form::text("product_name",$product_name,["class"=>"form-control","placeholder"=>"Enter  Name","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('product_name') }}</span>   
</div>
</div>

<?php 
$check_today_data=DB::table('physical_entries')->where([['outlet_id',$data->outlet_id],['ingredient_id',$data->product_id]])->whereDate('date',date('Y-m-d'))->first();
$consuption_sum=DB::table('franchise_sale_consuptions_of_menus')
         ->where([['outlet_id',(int)$data->outlet_id],['ingredient_id',(int)$data->product_id],['sync_status',0]])->sum('consumption');
          
    $waste_sum=DB::table('waste_ingredients')
         
           ->where([['outlet_id',(int)$data->outlet_id],['ingredient_id',(int)$data->product_id],['sync_status',0]])->sum('waste_amount');
    $total_waste=(float)$consuption_sum+(float)$waste_sum;

$total_avl=(float)$data->available_qty-(float)$total_waste;
?>
@if($check_today_data!='')
<!-- <div class="col-lg-6">
<div class="form-group">
<label for="" >Auto Stock</label>
{!! Form::text("auto_data",$total_avl,["class"=>"form-control number_test","placeholder"=>"Edit QTY","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('available_qty') }}</span>   
</div>
</div> -->

<div class="col-lg-6">
<div class="form-group">
<label for="" >Physical Stock</label>
{!! Form::text("physical_data",$check_today_data->physical_data,["class"=>"form-control number_test","placeholder"=>"Edit QTY","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('available_qty') }}</span>   
</div>
</div>
@else
<!-- <div class="col-lg-6">
<div class="form-group">
<label for="" >Auto Stock</label>
{!! Form::text("auto_data",$data->available_qty,["class"=>"form-control number_test","placeholder"=>"Edit QTY","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('available_qty') }}</span>   
</div>
</div> -->

<div class="col-lg-6">
<div class="form-group">
<label for="" >Physical Stock</label>
{!! Form::text("physical_data",$data->available_qty,["class"=>"form-control number_test","placeholder"=>"Edit QTY","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('available_qty') }}</span>   
</div>
</div>
@endif



</div>




</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Release the Stock',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}




