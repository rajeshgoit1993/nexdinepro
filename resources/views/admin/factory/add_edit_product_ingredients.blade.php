
<!-- /.content -->

<!---->
{!! Form::open(["files"=>true,'id'=>'add_product_ingredients'])!!}

<input type="hidden" name="factory_id" value="{{$factory_id}}">
<input type="hidden" name="product_id" value="{{$product_id}}">

<div class="modal-body">
<div class="row">

 <div class="dynamic_four" id="dynamic_four">
    @if(count($data)>0)
    <?php

  $i=1;
  $k=0;
  ?>
  @foreach($data as $datas)
  @if($i>1)
    <div id="fourrow{{$i}}" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray">
    <div class="row">
 <div class="col-md-5">
   <select name="ingredients[{{$k}}][id]" class="form-control valid">  
     <option value="" >--Select Ingredients--</option>
     @foreach($ingredients as $ingredient)
 <option value="{{$ingredient->id}}" @if($ingredient->id==$datas->ingredients_id) selected @endif>{{$ingredient->product_name}} ({{CustomHelpers::get_master_table_data('units','id',$ingredient->unit,'unit') }} )</option>
     @endforeach
   </select>
 </div>
 
 <div class="col-md-4">
    <input type="text" name="ingredients[{{$k}}][qty]"  class="form-control valid"  placeholder="Ingredients Qty"  value="{{$datas->qty}}">
 </div>
 <div class="col-md-3"><button type="button" name="remove" id="{{$i}}" class="btn btn-danger btn_remove_four" style="margin-bottom: 5px">x Remove </button></div>
</div>

</div>
  @else
    <div id="fourrow{{$i}}">
    <div class="row">
 <div class="col-md-5">
   <select name="ingredients[{{$k}}][id]" class="form-control valid" required>  
     <option value="" >--Select Ingredients--</option>
     @foreach($ingredients as $ingredient)
 <option value="{{$ingredient->id}}" @if($ingredient->id==$datas->ingredients_id) selected @endif>{{$ingredient->product_name}} ({{CustomHelpers::get_master_table_data('units','id',$ingredient->unit,'unit') }} )</option>
     @endforeach
   </select>

 </div>
 
 <div class="col-md-4">
   <input type="text" name="ingredients[{{$k}}][qty]"  class="form-control valid"  placeholder="Ingredients Qty" required value="{{$datas->qty}}">

  
 </div>
  <div class="col-md-3">
   <button id="add_certification" class="btn btn-info" ><span class="fa fa-plus"></span> Add </button>  
 </div>
</div>

</div>
  @endif
 

 <?php $k++; $i++;  ?>
  @endforeach  




@else
 <div id="fourrow1">
    <div class="row">
 <div class="col-md-5">
 	<select name="ingredients[0][id]" class="form-control valid" required>  
     <option value="" >--Select Ingredients--</option>
     @foreach($ingredients as $ingredient)
 <option value="{{$ingredient->id}}">{{$ingredient->product_name}} ({{CustomHelpers::get_master_table_data('units','id',$ingredient->unit,'unit') }} )</option>
     @endforeach
 	</select>
    
 </div>
 
 <div class="col-md-4">
    <input type="text" name="ingredients[0][qty]"  class="form-control valid"  placeholder="Ingredients Qty" required>
 </div>
  <div class="col-md-3">
   <button id="add_certification" class="btn btn-info" ><span class="fa fa-plus"></span> Add</button>  
 </div>
</div>

</div>
@endif

</div>
</div>

</div>




</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}

</div>



{!! Form::close() !!}


