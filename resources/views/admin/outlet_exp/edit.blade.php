{!! Form::open(["files"=>true,'id'=>'update_franchise_exp'])!!}

<input type="hidden" name="id" value="{{$exp_data->id}}">
<!-- Modal content-->
<div class="">



<div class="modal-body">
	<div class="row">
		<div class="col-lg-12">
      <label>Select Outlet</label>
      <select name="outlet_id" id="outlet_id" class="form-control">
     @foreach($data as $datas)
    
     <option value="{{$datas->id}}" @if($exp_data->outlet_id==$datas->id) selected @endif>{{CustomHelpers::get_brand_name(POS_SettingHelpers::get_brand_by_admin_id($datas->id))}} ({{$datas->city}}) {{ $datas->name }}</option>
     @endforeach
    </select>
      </div>
<div class="col-lg-12">
   
   <div class="dynamic_four" id="dynamic_four">
 <div id="fourrow1">
    <div class="row">
 <div class="col-md-4">
 	<label for="" >Date</label>

 <input type="date" name="exp_date" value="{{$exp_data->exp_date}}"  class="form-control"  placeholder="Date" required>

    
 </div>
 
 <div class="col-md-4">
 		<div class="form-group">
<label for="" >Exp Type</label>
<select class="form-control" name="exp_type" required>
	<option value="Travel" @if($exp_data->exp_type=='Travel') selected @endif>Travel</option>
	<option value="Accommodation" @if($exp_data->exp_type=='Accommodation') selected @endif>Accommodation </option>
	<option value="Food" @if($exp_data->exp_type=='Food') selected @endif>Food </option>
	<option value="Other" @if($exp_data->exp_type=='Other') selected @endif>Other </option>
</select>   
</div>

 </div>

  <div class="col-md-4">
  		<div class="form-group">
<label for="" >Expense</label>
<input type="text" name="exp" value="{{$exp_data->exp}}"  class="form-control"  placeholder="Expense" required>

</div>

  
 </div>


</div>

</div>
</div>  


</div>

	<div class="col-lg-12">
		<div class="form-group">
<label for="" >Exp Desc</label>
{!! Form::textarea("exp_desc",$exp_data->exp_desc,["class"=>"form-control","rows"=>"2","placeholder"=>"Exp Desc"]) !!}
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