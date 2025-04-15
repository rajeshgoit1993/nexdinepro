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
  <div class="flex-item-left"><h5>My Account</h5></div>

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
@if($fanchise_detail->active_status==1)
<?php 
$expire_date=$fanchise_detail->expire_date;
$today=date('Y-m-d');
?>
@if($expire_date>=$today)
<p style="color:green;">Active <br> {{date('d-m-y', strtotime($expire_date))}}</p>
@else
<p style="color:red;">Expired <br> {{date('d-m-y', strtotime($expire_date))}}</p>
@endif
@else

<p style="color:red;">In-Active</p>

@endif

 
    </span></td>                        
             
            
                   <td>
   


    <a href="#" class="view" data-toggle="modal" data-target="#view_modal_{{preg_replace('/[<=>]+/', '',CustomHelpers::custom_encrypt($fanchise_detail->id))}}" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><button class="btn btn-primary btn-sm"><span class="fa fa-eye"></span> View</button></a>

    

   
     
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
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Enter Collection Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
     {!! Form::open(["files"=>true,'id'=>"page_access_form","name"=>"page_access_form"])!!}
  <input type="hidden" name="id" id="page_access_data" value="">   
        <!-- Modal body -->
        <div class="modal-body page_access_data">
        <div class="col-lg-12">
 <div class="form-group">
        <label>Received Date</label>

<input type="date" value="" class="form-control" name="items_received_date" id="items_received_date" placeholder="First Instalment Date" style="padding: 5px;color: #4a4a4a;min-width: 60px;">
      <span id="error_items_received_date" class="text-danger"></span> 
        </div>
</div>

<div class="col-lg-12">
 <div class="form-group">
        <label>Remarks</label>
<textarea class="form-control  items_received_remarks" name="items_received_remarks" id="items_received_remarks" placeholder="Items Received Remarks" style="padding: 5px;color: #4a4a4a;min-width: 60px;"></textarea>

      <span id="error_items_received_remarks" class="text-danger"></span> 
        </div>
</div>   


        </div>
       <div style="text-align:center;">
<button type="button" name="submit" id="submit" class="btn btn-info mb-2">Save</button>
       </div>

      {!! Form::close() !!}
  
        <!-- Modal footer -->
        <div class="modal-footer">
       
        </div>
        
      </div>
    </div>
  </div>

  <!-- The Modal -->
  <!-- The Modal -->

@endsection
@section('custom_js')
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/accordian.js')}}"></script>
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/timeline.js')}}"></script>

<script type="text/javascript">

//kyc

  //
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     //
      //item_send
    $(document).on("click",".item_send",function(){
     var id=$(this).attr('id')
     $("#page_access_data").val('').val(id)
     $('#myModal').modal('toggle');
    })
  //
    $('#submit').click(function(e){
e.preventDefault()
 var error_items_received_date = '';
  var error_items_received_remarks=''
  

  if($.trim($('#items_received_date').val()).length == 0)
  {
   error_items_received_date = 'Kindly Enter Date';
   $('#error_items_received_date').text(error_items_received_date);
   $('#items_received_date').addClass('has-error');
  }
  else
  {
   error_items_received_date = '';
   $('#error_items_received_date').text(error_items_received_date);
   $('#items_received_date').removeClass('has-error');
  }
 
 if($.trim($('#items_received_remarks').val()).length == 0)
  {
   error_items_received_remarks = 'Kindly Remarks';
   $('#error_items_received_remarks').text(error_items_received_remarks);
   $('#items_received_remarks').addClass('has-error');
  }
  else
  {
   error_items_received_remarks = '';
   $('#error_items_received_remarks').text(error_items_received_remarks);
   $('#items_received_remarks').removeClass('has-error');
  }
  
 
  //
  if( error_items_received_date != '' || error_items_received_remarks != '')
  {
   return false;
  }
  else
  {
    $("#overlay").fadeIn(300);
  var form_data = new FormData($("#page_access_form")[0]);
 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/update_collection_fanchise',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Updated', "success");
        var url=APP_URL+'/Fanchise-Account';
        window.location.href = url;
     
       }
       else
      {
        swal("Error", data, "error"); 
       
       }

        },
        error:function(data)
        {

        }
    })
  }

  })
    //fill_pre_launch
$(document).on("click",".fill_pre_launch",function(){
     var id=$(this).attr('id')
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Franchise-Pre-Launch";
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