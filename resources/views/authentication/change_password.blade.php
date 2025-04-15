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
<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<!-- /.content -->
{!! Form::open(["files"=>true])!!}


<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">

<h4 class="modal-title">Password Change</h4>
</div>
<div class="modal-body">


  <div class="row">
  
<div class="col-md-6">
  <div class="row">
<div class="col-md-12">
  <label>Current Password</label>
  <input type="password" name="current"  class="form-control" placeholder="Current Password">
  @if($errors->has('current'))
      <span class="errors">
        <strong>{{ $errors->first('current') }}</strong>
      </span>
  @endif
</div>
<div class="col-md-12">
  <label>New Password</label>
  <input type="password" name="new"  class="form-control" placeholder="New Password">
  @if($errors->has('new'))
      <span class="errors">
        <strong>{{ $errors->first('new') }}</strong>
      </span>
  @endif
</div>
<div class="col-md-12">
  <label>Confirm New Password</label>
  <input type="password" name="confirm"  class="form-control" placeholder="Confirm New Password">
</div>

</div>


</div>
<!---->


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
//

  
@endsection
@section('custom_js')
<script type="text/javascript">
    //
// $(document).on("click",".remove",function(){
//    var r = confirm("Are you sure ?");

     
//        if (r === false) {
//            return false;
//         }
// })
  //
   //
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     //

</script>

@endsection