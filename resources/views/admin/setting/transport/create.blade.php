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
  <div class="flex-item-left"><h5>Add Transport Charge</h5></div>
  <div class="flex-item-right"><a href="{{URL::route('gst_list')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
</div>
@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
@if(Session::get('error'))
<div class="alert alert-danger" role="alert">
  {{ Session::get('error') }}
</div>
@endif
</div>
</section>
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<!-- /.content -->

<!---->
{!! Form::open(["files"=>true])!!}


<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">


</div>
<div class="modal-body">
<div class="row">

       <div class="col-lg-6">
          
          <div class="form-group">
     <label>State</label>
     <select name="state" id="state" class="form-control" required>
     <option value="">--Select State--</option>
     @foreach($states as $state)
     <option value="{{ $state->state_title }}" state_id="{{ $state->id }}">{{ $state->state_title }}</option>
     @endforeach
     </select >

     <span id="error_state" class="text-danger"></span>
        </div> 
     </div>
      <div class="col-lg-6">
          <div class="form-group">
     <label>District</label>
     <select name="dist" id="dist" class="form-control" required>
     <option value="">--Select District--</option>
   
     </select >

     <span id="error_dist" class="text-danger"></span>
        </div> 
     </div>
      <div class="col-lg-6">
          <div class="form-group">
     <label>City</label>
     <select name="city" id="city" class="form-control" required>
     <option value="">--Select City--</option>
   
     </select >

     <span id="error_city" class="text-danger"></span>
        </div> 
     </div>

        <div class="col-lg-6">
          <div class="form-group">
     <label>GST</label>
     <select name="gst_id" id="gst_id" class="form-control" required>
     <option value="">--Select GST--</option>
   @foreach($gsts as $gst)
   <option value="{{$gst->id}}">{{$gst->gst_name}}</option>
   @endforeach
     </select >

     <span id="error_city" class="text-danger"></span>
        </div> 
     </div>
        
     <div class="col-lg-6">
          <div class="form-group">
     <label>Unit</label>
     <select name="unit" id="unit" class="form-control" required>
     <option value="">--Select Unit--</option>
   @foreach($units as $unit)
   <option value="{{$unit->id}}">{{$unit->unit}}</option>
   @endforeach
     </select >

     <span id="error_city" class="text-danger"></span>
        </div> 
     </div>

<div class="col-lg-6">
<div class="form-group">
<label for="" >Amount</label>
{!! Form::text("fee",null,["class"=>"form-control number_test","placeholder"=>"Enter  Amount","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('fee') }}</span>   
</div>
</div>
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
<script type="text/javascript">
$(document).on("keyup change",".number_test",function(){
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');

})

</script>
<script type="text/javascript">
	

$(document).on("change","#state",function(){
var state_id=$('option:selected', this).attr('state_id')
 $("#overlay").fadeIn(300);
	 var APP_URL=$("#APP_URL").val();
	 $.ajax({
        url:APP_URL+'/get_dist',
        data:{state_id:state_id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
        	  $("#overlay").fadeOut(300);
        	$("#dist").html('').html(data)
           $("#city").html('').html('<option value="">--Select City--</option>')
      
        },
        error:function(data)
        {

        }
    })


})
$(document).on("change","#dist",function(){
var dist_id=$('option:selected', this).attr('dist_id')
$("#overlay").fadeIn(300);
	 var APP_URL=$("#APP_URL").val();
	 $.ajax({
        url:APP_URL+'/get_city',
        data:{dist_id:dist_id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
        	  $("#overlay").fadeOut(300);
        	$("#city").html('').html(data)
           
      
        },
        error:function(data)
        {

        }
    })


})
//
</script>
@endsection