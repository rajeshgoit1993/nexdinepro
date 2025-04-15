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


<div class="flex-item-left"><h5>Add Role</h5></div>




<div class="flex-item-right"><a href="{{URL::route('role')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
</div>


</div>
</section>
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<!-- /.content -->

<!---->

<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>

{!! Form::open(["files"=>true])!!}


    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
     
        <h4 class="modal-title">Add  Role</h4>
      </div>
      <div class="modal-body">
         <div class="form-group">
        
          <label for="">Role Name</label>
            {!! Form::text("role_name",null,["class"=>"form-control"]) !!}
            <span class="text-danger">{{ $errors->first('role_name') }}</span>   
        </div>
     
         <div class="form-group">
        
          <label for="">Role Slug</label>
            {!! Form::text("role_slug",null,["class"=>"form-control"]) !!}
            <span class="text-danger">{{ $errors->first('role_slug') }}</span>   
        </div>

      </div>
      <div class="modal-footer" style="text-align: left;">
        {!! Form::submit('Save',["class"=>"btn btn-success"]) !!}
        
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