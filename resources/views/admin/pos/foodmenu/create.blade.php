{!! Form::open(["files"=>true,'id'=>'store_foodmenu'])!!}
<input type="hidden" name="outlet_id" value="{{$outlet_id}}">

<!-- Modal content-->
<div class="">

<div class="modal-body">
<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
<label for="" class="required">Name</label>
{!! Form::text("name",null,["class"=>"form-control","placeholder"=>"Enter Food Menu ","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('name') }}</span>   
</div>
    </div>
    <div class="col-lg-4">
            <div class="form-group">
<label for="" class="required">Code</label>
{!! Form::text("code",null,["class"=>"form-control","placeholder"=>"Food Menu Code","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('code') }}</span>   
</div>
    </div>
     <div class="col-lg-4">
            <div class="form-group">
<label for="" class="required">Category</label>
<select class="form-control" required name="category_id">
    <option value="">--Select Category--</option>
    @foreach($category as $cat)
<option value="{{$cat->id}}">{{$cat->category_name}} ({{$cat->category_type}})</option>
    @endforeach
</select>
 
</div>
    </div>
    <div class="col-lg-4">
            <div class="form-group">
<label for="" class="required">Sale Price</label>
{!! Form::text("sale_price",null,["class"=>"form-control number_test","placeholder"=>"Sale Price","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('sale_price') }}</span>   
</div>
    </div>
   
     <!-- <div class="col-lg-4">
            <div class="form-group">
<label for="" >Photo</label>
{!! Form::file("photo",["class"=>"form-control"]) !!}
<span class="text-danger">{{ $errors->first('photo') }}</span>   
</div>
    </div> -->
     <div class="col-lg-4">
            <div class="form-group">
<label for="" class="required">Is it Veg Item ? </label>
<select class="form-control" name="veg_item" required>
   <option value="">--Select--</option> 
    <option value="Yes">Yes</option> 
     <option value="No">No</option> 
</select>

</div>
    </div>
      <div class="col-lg-3">
        <label for="" class="required">Is it Non-Veg Item ? </label>
            <div class="form-group">
<select class="form-control" name="non_veg_item" required>
   <option value="">--Select--</option> 
    <option value="Yes">Yes</option> 
     <option value="No">No</option> 
</select> 
</div>
    </div>
     <div class="col-lg-3">
            <div class="form-group">
<label for="" class="required">Is it Beverage ?  </label>
<select class="form-control" name="beverage_item" required>
   <option value="">--Select--</option> 
    <option value="Yes">Yes</option> 
     <option value="No">No</option> 
</select>   
</div>
    </div>
   
      <div class="col-lg-3">
            <div class="form-group">
<label for="" class="required">GST </label>
<select class="form-control" name="tax_information" required>
<option value="">--Choose GST--</option>
@foreach($gsts as $gst)
<option value="{{$gst->id}}">{{$gst->gst_name}}</option>
@endforeach
</select>  
</div>
    </div>
     <div class="col-lg-3">
            <div class="form-group">
<label for="" class="required">Making Time</label>
{!! Form::text("making_time_in_min",null,["class"=>"form-control number_test","placeholder"=>"Making Time In Miniutes","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('making_time_in_min') }}</span>   
</div>
    </div>
  <div class="col-lg-12">
    <div class="form-group">
<label for="" class="required" >Description</label>
{!! Form::textarea("description",null,["class"=>"form-control","placeholder"=>"Enter  Food Menu  Description","required"=>"","rows"=>2]) !!}
<span class="text-danger">{{ $errors->first('description') }}</span>   
</div>
  </div>

</div>
<hr>
 <h6><strong>Select Ingredients</strong></h6>
 <div class="dynamic_four" id="dynamic_four">


 <div id="fourrow1">
    <div class="row">
 <div class="col-md-3">
    <select name="ingredients[0][id]" class="form-control valid" >  
     <option value="" >--Select Ingredients--</option>
     @foreach($ingredients as $ingredient)
 <option value="{{$ingredient->id}}">{{$ingredient->product_name}} ({{CustomHelpers::get_master_table_data('units','id',$ingredient->unit,'unit') }} )</option>
     @endforeach
    </select>
    
 </div>
 
 <div class="col-md-3">
    <input type="text" name="ingredients[0][qty]"  class="form-control valid"  placeholder="Ingredients Qty" >
 </div>

  <div class="col-md-3">
    <select name="ingredients[0][use_for]" class="form-control valid" >  
    
   
 <option value="1">All</option>
 <option value="2">Only Dine-in</option>
 <option value="3">Only Take-away</option>
 <option value="4">Only Delivery</option>
 <option value="5">Take-away & Delivery</option>
 <option value="6">Dine-in & Take-away</option>   
 <option value="7">Dine-in & Delivery</option> 
 

    </select>
    
 </div>


  <div class="col-md-3">
   <button id="add_certification" class="btn btn-info" ><span class="fa fa-plus"></span> Add</button>  
 </div>
</div>

</div>
 </div>



</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}