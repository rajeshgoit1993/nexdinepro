@extends("layouts.backend.master")

@section('maincontent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<!-- /.content -->
@if(count($data)>0)
<div class="col-12">
        
              <div class="card-header">
                <h3 class="card-title">Acceptance Request</h3>

               
              </div>
              <!-- /.card-header -->
           <div class="table-responsive">
  <table class="table table-bordered yajra-datatable">
        <thead>
    <tr>
      <th>Login ID</th>
      
      <th>Name</th>
      <th>Mobile No</th>
      <th>State</th>
      <th>District </th>
      <th>City</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  
  </thead>
   <tbody>
    <?php
$sn=1;
    ?>
    @foreach($data as $fanchise_detail)  
 


  <tr>
  <td>{{$fanchise_detail->email}}</td>
  <td><span>{{$fanchise_detail->name}}</span></td>
  <td><span>{{$fanchise_detail->mobile}}</span></td>
  <td><span>{{$fanchise_detail->state}}</span></td>
  <td><span>{{$fanchise_detail->dist}}</span></td>
  <td><span>{{$fanchise_detail->city}}</span></td>                    
                    
   <td><span>
    @if($fanchise_detail->status==1)
    New Request
    @else
    Replied Request
    @endif

    </span></td>            
            
                   <td>

      <a href="#" class="view" data-toggle="modal" data-target="#view_modal_{{preg_replace('/[<=>]+/', '',CustomHelpers::custom_encrypt($fanchise_detail->id))}}" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><button class="btn btn-primary"><span class="fa fa-eye"></span> View</button></a>

    
 <a href="{{url('/store-Kyc')}}" class="kyc" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><button class="btn btn-success"><span class="fa fa-upload"></span> Do KYC</button></a>



  <div class="modal fade" id="view_modal_{{preg_replace('/[<=>]+/', '',CustomHelpers::custom_encrypt($fanchise_detail->id))}}">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          @include("admin.multidepartmentuser.store_details")
        </div>
       
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>


                    </td>

                  </tr>

                @endforeach
                </tbody>
    </table>










<!-- /.content -->
</div>
                         <!-- /.card -->
          </div>

@endif







<!-- /.content -->
</div>
</section>

</div>

</div>
</section>

</div>

  <div class="modal fade" id="close">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Push Back Remarks</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         {!! Form::open(['url' =>'close_upload', 'files' => true,'id'=>'close_upload','name'=>'close_upload']) !!}
         <input type="hidden" id="close_id" name="id" value="">  
        
          <label>Push Back Remarks</label>
          {!! Form::textarea("pushback_comments",null,["class"=>"form-control","rows"=>"2"]) !!}
         <br>
         {{ Form::submit('Submit',['class'=>'btn btn-success']) }}
         {!! Form::close() !!}
          
      
        </div>
        
        <!-- Modal footer -->
     
        
      </div>
    </div>
  </div>

@endsection

@section("custom_js")

<script type="text/javascript">
//
$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
//close
$(document).on("click",".closees",function(){
var id=$(this).attr("id")

$("#close_id").val(id)

$('#close').modal('toggle');
})
//close_upload
document.close_upload.onsubmit=function(e){
 
e.preventDefault();
var r = confirm('Are you sure?');
 if (r == true) {
var id=$(this).attr('id')
var APP_URL=$("#APP_URL").val();
var form_data = new FormData($("#close_upload")[0]);
$.ajax({
url: APP_URL+'/push_back_request',
data: form_data,
type: 'post',
contentType: false,
processData: false,
success: function (data) {

if(data=='success')
{
 swal("Done !", 'Successfully Pushback', "success");
   setTimeout(function () {
 location.reload();
 }, 300)
}



},
error: function (xhr, status, error) {


}
});
} else {
    alert('it didnt work');
 }
  return false;
}
 //
  //
  $(document).on("click",".accept",function(e){
    e.preventDefault();
var r = confirm('Are you sure?');
 if (r == true) {
var id=$(this).attr('id')
var APP_URL=$("#APP_URL").val();

$.ajax({
url: APP_URL+'/accept_request',
data: {id:id},
type: 'get',
// contentType: false,
// processData: false,
success: function (data) {

if(data=='success')
{

   swal("Done !", 'Successfully Updated', "success");
        var url=APP_URL+'/Fanchise-Account';
        window.location.href = url;
}



},
error: function (xhr, status, error) {


}
});
} else {
    alert('it didnt work');
 }
  return false;
  })
  //close_upload
$(document).on("click",".reject",function(e){
    e.preventDefault();
var r = confirm('Are you sure?');
 if (r == true) {
var id=$(this).attr('id')
var APP_URL=$("#APP_URL").val();

$.ajax({
url: APP_URL+'/reject_vp',
data: {id:id},
type: 'get',
// contentType: false,
// processData: false,
success: function (data) {

if(data=='success')
{
   swal("Done !", 'Successfully Accepted', "success");
   var url=APP_URL+'/Fanchise-Account';
        window.location.href = url;
}



},
error: function (xhr, status, error) {


}
});
} else {
    alert('it didnt work');
 }
  return false;
  })
 //
</script>
@endsection