{!! Form::open(["files"=>true,'id'=>'update_key_contacts'])!!}

<input type="hidden" name="id" value="{{$data->id}}">
<!-- Modal content-->
<div class="">



<div class="modal-body">
	<div class="row">
	<div class="col-lg-6">
		<div class="form-group">
<label for="" >Contacts Type</label>
<select class="form-control" name="key_contacts_type" required>
	<option value="Consultant" @if($data->key_contacts_type=='Consultant') selected @endif>Consultant</option>
	<option value="Key Contacts" @if($data->key_contacts_type=='Key Contacts') selected @endif>Key Contacts</option>
	<option value="Broker" @if($data->key_contacts_type=='Broker') selected @endif>Broker</option>
</select>   
</div>
	</div>	
<div class="col-lg-6">
		<div class="form-group">
<label for="" >Name</label>
{!! Form::text("name",$data->name,["class"=>"form-control","placeholder"=>"Enter  Name","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('name') }}</span>   
</div>
	</div>
	<div class="col-lg-6">
		<div class="form-group">
<label for="" >Contact No</label>
{!! Form::text("contact_no",$data->contact_no,["class"=>"form-control","placeholder"=>"Contact No","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('contact_no') }}</span>   
</div>
	</div>
	<div class="col-lg-6">
		<div class="form-group">
<label for="" >DOB</label>
{!! Form::date("dob",$data->dob,["class"=>"form-control","placeholder"=>"DOB","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('dob') }}</span>   
</div>
	</div>
	<div class="col-lg-6">
		<div class="form-group">
<label for="" >Anniversary</label>
{!! Form::date("anniversary",$data->anniversary,["class"=>"form-control","placeholder"=>"Enter  Anniversary"]) !!}
<span class="text-danger">{{ $errors->first('anniversary') }}</span>   
</div>
	</div>
	<div class="col-lg-6">
		<div class="form-group">
<label for="" >Spouse Name</label>
{!! Form::text("spouse_name",$data->spouse_name,["class"=>"form-control","placeholder"=>"Enter  Spouse Name"]) !!}
<span class="text-danger">{{ $errors->first('spouse_name') }}</span>   
</div>
	</div>
	<div class="col-lg-6">
		<div class="form-group">
<label for="" >Spouse DOB</label>
{!! Form::date("spouse_dob",$data->spouse_dob,["class"=>"form-control","placeholder"=>"Enter  Spouse DOB"]) !!}
<span class="text-danger">{{ $errors->first('spouse_dob') }}</span>   
</div>
	</div>
	<div class="col-lg-12">
		<div class="form-group">
<label for="" >Address</label>
{!! Form::textarea("address",$data->address,["class"=>"form-control","rows"=>"2","placeholder"=>"Enter  Address","required"=>""]) !!}
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