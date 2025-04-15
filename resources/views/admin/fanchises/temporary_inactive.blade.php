@extends("layouts.backend.master")

@section('maincontent')
<style type="text/css">
   hr 
    {
      margin-top: .3rem !important;
      margin-bottom: .3rem !important;
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
  <div class="flex-item-left"><h5>Temporary inactive</h5></div>

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
<div class="table-responsive">
  <table class="table table-bordered yajra-datatable">
        <thead>
    <tr>
      <th>Brands</th>
      <th>Contact Details</th>
     
      
      <th>Location</th>
      
   
     
 <th>Status</th>
  
      <th>Actions</th>
    </tr>
  
  </thead>
   <tbody>
    <?php
$sn=1;
    ?>
    @foreach($data as $fanchise_detail)  
 
  <?php 

$booking_data=DB::table('fanchise_registrations')->where('fanchise_id','=',$fanchise_detail->id)->first();
   ?>

  <tr>
     <td>{{CustomHelpers::get_brand_name($booking_data->brands)}}</td>
  <td>
      <?php  
$email=CustomHelpers::partiallyHideEmail($fanchise_detail->email);
$mobile=CustomHelpers::mask_mobile_no($fanchise_detail->mobile);  

  ?>
    <b>ID:</b> {{$email}}
   <hr>
   <b>Name:</b> {{$fanchise_detail->name}}
   <hr>
   <b>Mobile:</b> {{$mobile}}
  </td>

  <td>
<b>State:</b> {{$fanchise_detail->state}}
<hr>
<b>City:</b> {{$fanchise_detail->city}}
   </td>
      <td id={{$fanchise_detail->id}}>
  <select class="active_status" style="width: 100px">
   

<option value="1" @if($fanchise_detail->active_status=="1") selected @endif>Active</option>
<option value="2" @if($fanchise_detail->active_status=="2") selected @endif>Temporary inactive</option>
<option value="3" @if($fanchise_detail->active_status=="3") selected @endif>Inactive</option>


  </select>
</td>       
            
                   <td>

      <a href="#" class="view" data-toggle="modal" data-target="#view_modal_{{preg_replace('/[<=>]+/', '',CustomHelpers::custom_encrypt($fanchise_detail->id))}}" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-primary  btn-sm"><span class="fa fa-eye"></span> View</button></a>
        
         

  <div class="modal fade" id="view_modal_{{preg_replace('/[<=>]+/', '',CustomHelpers::custom_encrypt($fanchise_detail->id))}}">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          @include("admin.fanchises.accordian")
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
</div>
</section>

</div>

</div>
</section>

</div>

<div class="form">

</div>
<!---->
  <!-- Button to Open the Modal -->
  

  <!-- The Modal -->

@endsection
@section('custom_js')
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/accordian.js')}}"></script>
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/timeline.js')}}"></script>

<script type="text/javascript">
  //
// $(document).on("click",".view",function(){
//   var id=$(this).attr('id')
//    var APP_URL=$("#APP_URL").val();
//    var url= 'aaa';
//      window.open(url,"_blank", "toolbar=no,scrollbars=yes,resizable=yes,width=1200,height=400");
//   $('#view_modal').modal('toggle');
// })
  //
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     //
     $(document).on('change','.active_status',function(){

    var status_value=$(this).val()
    var id =$(this).parent().attr('id')
    var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/active_status',
        type:'POST',
        data:{id:id,status_value:status_value},
        success:function(data)
        {
         alert("Status Successfully Changed")
        },
        error:function(data)
        {

        }
    })

     
})
  //
  $(document).on("click",".edit",function(){
    var id=$(this).attr('id')
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Edit-Fanchise";
     var element2 = document.createElement("INPUT");         
    element2.name="_token"
    element2.value = $('meta[name="csrf-token"]').attr('content')
    element2.type = 'hidden'
    form.appendChild(element2);

   var element1 = document.createElement("INPUT");         
    element1.name="id"
    element1.value = id;
    element1.type = 'hidden'
    form.appendChild(element1);
  
    form.submit();

  })
    //
$(document).on("click",".remove",function(){
   var r = confirm("Are you sure ?");

     
       if (r === false) {
           return false;
        }
})
  //

  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
       
       
       
    });
    
  });
</script>

@endsection