@extends("layouts.backend.master")

@section('maincontent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
	<section class="col-lg-12 connectedSortable">
	<div class="card direct-chat direct-chat-primary">
		<div class="flex-container">
  <div class="flex-item-left"><h5>Change Password</h5></div>

</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
</div>
</section>
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<!-- /.content -->

<div class="row">


<div class="col-md-12">
      <div class="form-card">


<div class="mb-2">
  <h3>Kindly Change Default Password.</h3>

  {!! Form::open(["files"=>true,'route'=>'first_password_create'])!!}
   <div class="row">
    <div class="col-md-12">
      <h6 style="font-size: 11px"><span style="font-weight: bold;">Password Policy: </span> Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters.</h6>
    </div>
    <div class="col-md-6">
      <div class="form-group">
          <label for="" class="required">Password</label>
          <input type="password" name="password" class="form-control" id="password" placeholder="Abc@12345" required="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
           
        </div>
    </div>
   <div class="col-md-6">
      <div class="form-group">
          <label for="" class="required">Confirm Password</label>
         <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm Password" required="">
        </div>
    </div>
    <!-- <div class="col-md-6">
      <div class="notice_date">
         
      </div>
       
    </div> -->
    
   </div>

       
      
      
        
 
     
      
        {!! Form::submit('Submit',["class"=>"btn btn-success"]) !!}
        
     

 
{!! Form::close() !!}
</div>
</div>
</div>
</div>


</div>
</section>

</div>

</div>
</section>

</div>
@endsection