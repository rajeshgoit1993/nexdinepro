{!! Form::open(["files"=>true,'id'=>'store_franchise_exp'])!!}


<!-- Modal content-->
<div class="">

<div class="modal-body">
	<div class="row">
		 <div class="col-lg-12">
      <label>Select Outlet</label>
      <select name="outlet_id" id="outlet_id" class="form-control">
     @foreach($data as $datas)
    
     <option value="{{$datas->id}}">{{CustomHelpers::get_brand_name(POS_SettingHelpers::get_brand_by_admin_id($datas->id))}} ({{$datas->city}}) {{ $datas->name }}</option>
     @endforeach
    </select>
      </div>

<div class="col-lg-12">
   
   <div class="dynamic_four" id="dynamic_four">
 <div id="fourrow1">
    <div class="row">
 <div class="col-md-3">
 	<label for="" >Date</label>

 <input type="date" name="exp[0][exp_date]"  class="form-control"  placeholder="Date" required>

    
 </div>
 
 <div class="col-md-3">
 		<div class="form-group">
<label for="" >Exp Type</label>
<select class="form-control" name="exp[0][exp_type]" required>
	<option value="Travel">Travel</option>
	<option value="Accommodation">Accommodation </option>
	<option value="Food">Food </option>
	<option value="Other">Other </option>
</select>   
</div>

 </div>

  <div class="col-md-3">
  		<div class="form-group">
<label for="" >Expense</label>
<input type="text" name="exp[0][exp]"  class="form-control"  placeholder="Expense" required>

</div>

  
 </div>

  <div class="col-md-3">
  	<label for="" style="visibility:hidden;display: block;">NA</label>
   <button id="add_exp" class="btn btn-info" ><span class="fa fa-plus"></span> Add</button>  
 </div>
</div>

</div>
</div>  


</div>


	

	
	

	
	<div class="col-lg-12">
		<div class="form-group">
<label for="" >Exp Desc</label>
{!! Form::textarea("exp_desc",null,["class"=>"form-control","rows"=>"2","placeholder"=>"Exp Desc"]) !!}
<span class="text-danger">{{ $errors->first('address') }}</span>   
</div>
	</div>
	</div>




</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}