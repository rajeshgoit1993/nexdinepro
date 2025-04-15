@extends("layouts.backend.master")

@section('maincontent')
<style type="text/css">
  .outlet_detail
  {
    display: none;
  }
     
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
  <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    <div class="flex-container">
  <div class="flex-item-left"><h5>Newly-Submitted</h5></div>

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
 @include("admin.fanchises.accordian")

<a href="{{url()->previous()}}" class="btn btn-success" style="width: fit-content;"><span class="fa fa-arrow-left"></span> Back</a>
<!---->
 <?php  
  $request_segments=Request::segment(1);
  ?>
  <div style="padding: 0px 10px;">
    @if($request_segments=='Interior-Work-Actions') 

<h5>Interior-Work-Actions</h5>
    @elseif($request_segments=='Social-Media-Actions')
   
<h5>Social-Media-Actions</h5>
    @elseif($request_segments=='Operations-Actions')
<h5>Operations-Actions</h5>
    @elseif($request_segments=='Accounts-Actions')
<h5>Accounts-Actions</h5>
    @elseif($request_segments=='Fanchise-Pre-Launch')
<h5>Fanchise-Pre-Launch</h5>
    @elseif($request_segments=='Procurement-Actions')
<h5>Procurement-Actions</h5>
    @endif


 {!! Form::open(["files"=>true,'id'=>"registration_form","name"=>"registration_form"])!!}
  <input type="hidden" name="id" value="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}">

<div class="row">
 
  @if($request_segments=='Interior-Work-Actions')
  @if($registered_fanchise->architect_status==1)
  @else
 @include('admin.fanchises.prelaunch.create.architech_create')

@endif
<!---->
@elseif($request_segments=='Social-Media-Actions')
@if($registered_fanchise->social_media_status==1)
@else
 @include('admin.fanchises.prelaunch.create.social_create')

@endif
@elseif($request_segments=='Procurement-Actions')
@if($registered_fanchise->procurement_status==1)
@else
@include('admin.fanchises.prelaunch.create.procurement_create')

<!---->
@endif
@elseif($request_segments=='Operations-Actions')
@if($registered_fanchise->operations_status==1)
@else
@include('admin.fanchises.prelaunch.create.operations_create')

<!---->
@endif
@elseif($request_segments=='Accounts-Actions')
@if($registered_fanchise->accounts_status==1)
@else
@include('admin.fanchises.prelaunch.create.account_create')

@endif
@elseif($request_segments=='Franchise-Pre-Launch')

@include('admin.fanchises.prelaunch.create.franchise_create')



@endif


 
 
  </div>
<br>
 @if($request_segments=='Procurement-Actions')
 
 @else
  <button type="button" name="submit_prelaunch" id="submit_prelaunch" class="btn btn-info btn-lg">Save</button>
    @endif

  {!! Form::close() !!}    
  </div>
<!---->
</div>
</section>

</div>

</div>
@if($request_segments=='Procurement-Actions')


<style type="text/css">
  .badge {
  padding-left: 15px;
  padding-right: 15px;
  -webkit-border-radius: 15px;
  -moz-border-radius: 15px;
  border-radius: 15px;
}

.label-warning[href],
.badge-warning[href] {
  background-color: #c67605;
}
#lblCartCount {
    font-size: 20px;
    background: #ff0000;
    color: #fff;
    padding: 0 10px;
    vertical-align: top;
    margin-left: -10px; 
}
</style>
<div class="cart" style="    position: fixed;
    right: 50px;
    bottom: 30px;
    display: block;">

<i class="fa" style="font-size:50px">&#xf07a;</i>
<span class='badge badge-warning' id='lblCartCount'  fanchise_id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"> {{count($cart_data)}} </span>
</div>
    @endif
</section>

</div>

<div class="form">

</div>
<!---->
  <!-- Button to Open the Modal -->
  
<div class="modal fade" id="cart_data">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">First Stock List</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body cart_data_value">
        
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success submit_cart" fanchise_id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}">Submit</button>
        </div>
        
      </div>
    </div>
  </div>
  
  <!-- The Modal -->

@endsection
@section('custom_js')
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/accordian.js')}}"></script>
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/timeline.js')}}"></script>
franchiseregistration.js
<script type="text/javascript">
  //

   //

     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
 <?php  
if($request_segments=='Procurement-Actions'):
?>
$(document).on("click",".submit_cart",function(e){
  e.preventDefault();
 var APP_URL=$("#APP_URL").val();
 var fanchise_id=$(this).attr('fanchise_id')
  $.ajax({
        url:APP_URL+'/submit_cart_by_company',
        data:{fanchise_id:fanchise_id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
          swal("Done !", 'Successfully Sended First Time Stock List', "success");
      
         var url=APP_URL+'/Ongoing-Pre-launch';
        window.location.href = url;
     
        },
        error:function(data)
        {

        }
    })

})
<?php  
endif;
?>


</script>
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/franchiseregistration.js')}}"></script>

@endsection