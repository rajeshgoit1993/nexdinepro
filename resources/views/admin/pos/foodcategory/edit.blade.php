{!! Form::open(["files"=>true,'id'=>'update_store_food_menu'])!!}
<input type="hidden" name="id" value="{{$data->id}}">

<!-- Modal content-->
<div class="">

<div class="modal-body">
<div class="form-group">
<label for="" class="required">Food Menu Category</label>
{!! Form::text("category_name",$data->category_name,["class"=>"form-control","placeholder"=>"Enter  Food Menu Category","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('category_name') }}</span>   
</div>
<!-- <div class="form-group">
<label for="" class="required">Category Type</label>
<select class="form-control" name="category_type" required>    
<option value="Veg" @if($data->category_type=='Veg') selected @endif>Veg</option>
<option value="Non-Veg" @if($data->category_type=='Non-Veg') selected @endif>Non-Veg</option>
<option value="Beverage" @if($data->category_type=='Beverage') selected @endif>Beverage</option>
</select>
</div>
 -->
<div class="form-group">
<label for="" class="required" >Description</label>
{!! Form::textarea("description",$data->description,["class"=>"form-control","placeholder"=>"Enter  Food Menu Category Description","required"=>"","rows"=>2]) !!}
<span class="text-danger">{{ $errors->first('description') }}</span>   
</div>




</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}