@extends("layouts.backend.master")

@section('maincontent')
<style type="text/css">
 
    hr 
    {
      margin-top: .3rem !important;
      margin-bottom: .3rem !important;
    }
    </style>
    <style type="text/css">
  .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<!-- Content Wrapper. Contains page content -->
<input type="hidden" name="type" id="type" value="{{$val}}">
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
  <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    <div class="flex-container">
  <div class="flex-item-left"><h5>
    @if($val==1)
Running Franchise
    @elseif($val==2)
Expired Subscription
    @elseif($val==3)
Inactive Franchise
    @endif
   

</h5></div>

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
      <th>S.No.</th>
     
      <th>Contact Details</th>
     
      
      <th>Location</th>
      
   
      <th>Subscription </th>
 
     <th>Expire Date </th>
      <th>Actions</th>
    </tr>
  
  </thead>

       
   <tbody>
   
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
  <!-- The Modal -->
    <div class="modal fade" id="ongoing_data">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Franchise Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body ongoing_data">
       
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>

<!---->
 <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Outlet Setting</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
     {!! Form::open(["files"=>true,'id'=>"outlet_setting_form","name"=>"outlet_setting_form"])!!}
  <input type="hidden" name="id" id="outlet_setting_data" value="">   
        <!-- Modal body -->
        <div class="modal-body page_access_data">
         
        </div>
       <div style="text-align:center;">
<button type="button" name="submit" id="submit_outlet_setting_form" class="btn btn-info mb-2">Save</button>
       </div>

      {!! Form::close() !!}
  
        <!-- Modal footer -->
        <div class="modal-footer">
       
        </div>
        
      </div>
    </div>
  </div>

  <!---->
   <!-- The Modal -->
  <div class="modal fade" id="change_password">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Change Password</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
     {!! Form::open(["files"=>true,'id'=>"change_password_form","name"=>"change_password_form"])!!}
  <input type="hidden" name="id" id="change_password_data"  value="">   
        <!-- Modal body -->
        <div class="modal-body">
         <div class="col-md-12">
  <label>New Password</label>
  <input type="password" required  name="new" class="form-control" placeholder="New Password" fdprocessedid="xm9on4j">
  </div>
  <div class="col-md-12">
  <label>Confirm New Password</label>
  <input type="password" required name="confirm" class="form-control" placeholder="Confirm New Password" >
</div>
        </div>
       <div style="text-align:center;">
<button type="submit" name="submit" id="change_password_form_submit" class="btn btn-info mb-2">Submit</button>
       </div>

      {!! Form::close() !!}
  
        <!-- Modal footer -->
        <div class="modal-footer">
       
        </div>
        
      </div>
    </div>
  </div>

<!---->
 <div class="modal fade" id="add_fund_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Fund</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
     {!! Form::open(["files"=>true,'id'=>"add_fund_form","name"=>"add_fund_form"])!!}

        <!-- Modal body -->
        <div class="modal-body add_fund_body">
         
        </div>
       <div style="text-align:center;">
<button type="submit" name="submit" id="" class="btn btn-info mb-2">Save</button>
       </div>

      {!! Form::close() !!}
  
        <!-- Modal footer -->
        <div class="modal-footer">
       
        </div>
        
      </div>
    </div>
  </div>


@endsection
@section('custom_js')
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/accordian.js')}}"></script>
<script type="text/javascript" src="{{url('resources/assets/admin-lte/js/timeline.js')}}"></script>

<script type="text/javascript">
//
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  //
    $(document).on('change','.active_status',function(){

    var status_value=$(this).val()
    var id =$(this).siblings('.fanchise_id').val()
    var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/active_status',
        type:'POST',
        data:{id:id,status_value:status_value},
        success:function(data)
        {
         alert("Status Successfully Changed")
         get_data('change')
        },
        error:function(data)
        {

        }
    })

     
})

$(document).on("click",".open_page",function(){
var id=$(this).attr('id')
$("#outlet_setting_data").val('').val(id)

var APP_URL=$("#APP_URL").val();
 $.ajax({
        url:APP_URL+'/get_outlet_setting_data',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
         $(".page_access_data").html('').html(data)
       
        $('#myModal').modal('toggle');
                                
         //
        
         
        },
        error:function(data)
        {

        }
    })

})
//
$(document).on("click",".add_fund",function(e){
  e.preventDefault()
var id=$(this).attr('id')
 var APP_URL=$("#APP_URL").val();
$.ajax({

  url:APP_URL+'/add_fund_form',
  data:{id:id},
  type:'get',
  success:function(data){
    $(".add_fund_body").html('').html(data)
$('#add_fund_modal').modal('toggle');

  },
  error:function(){

  }

})



})
//
 $(document).on("submit", "#add_fund_form", function (event) {

  event.preventDefault();

  var form_data = new FormData($("#add_fund_form")[0]);
 var APP_URL=$("#APP_URL").val();
$("#overlay").fadeIn(300);
  $.ajax({
        url:APP_URL+'/fund_save',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
         $("#overlay").fadeOut(300);
        if(data=='success')
        {
           $('#add_fund_modal').modal('hide');
       swal("Done !", 'Successfully Updated', "success");
       get_data('change')
        // var url=APP_URL+'/Launch-Franchise';
        // window.location.href = url;
     
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


})
//change_password
$(document).on("click",".change_password",function(){
var id=$(this).attr('id')
$("#change_password_data").val('').val(id)

$('#change_password').modal('toggle');

})
//change_password_form
  $(document).on("submit", "#change_password_form", function (event) {

  event.preventDefault();

  var form_data = new FormData($("#change_password_form")[0]);
 var APP_URL=$("#APP_URL").val();
$("#overlay").fadeIn(300);
  $.ajax({
        url:APP_URL+'/change_password_outlet',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
         $("#overlay").fadeOut(300);
        if(data=='success')
        {
           $('#change_password').modal('hide');
       swal("Done !", 'Successfully Updated', "success");
        // var url=APP_URL+'/Launch-Franchise';
        // window.location.href = url;
     get_data('change')
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


})
//outlet_menu
$(document).on("change",".outlet_menu",function(){
  var menu_id=$(this).val()
if(this.checked) {

       var APP_URL=$("#APP_URL").val();
 $.ajax({
        url:APP_URL+'/outlet_menu_enable',
        data:{menu_id:menu_id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
          $(".total_menues").html('').html(data)
         
        },
        error:function(data)
        {

        }
    })
    }
  else
    {
       var APP_URL=$("#APP_URL").val();
 $.ajax({
        url:APP_URL+'/outlet_menu_disable',
        data:{menu_id:menu_id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
         $(".total_menues").html('').html(data)
         
        },
        error:function(data)
        {

        }
    })   
      
    }
})

//outlet_setting_form
$(document).on("click","#submit_outlet_setting_form",function(){
  var form_data = new FormData($("#outlet_setting_form")[0]);
 var APP_URL=$("#APP_URL").val();
 $('#myModal').modal('hide');
  $.ajax({
        url:APP_URL+'/save_outlet_setting_form',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
         
        if(data=='success')
        {
       swal("Done !", 'Successfully Updated', "success");
        // var url=APP_URL+'/Launch-Franchise';
        // window.location.href = url;
     get_data('change')
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


})
  

//
$(document).on("click",".edit",function(){
    var id=$(this).attr('id')
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Edit-Launched-Franchise";
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
$(document).on("click",".view",function(){
var id=$(this).attr('id')
 
     var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/get_fanchise_basic_data',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {

          
          $(".ongoing_data").html('').html(data)
      



         $('#ongoing_data').modal('toggle');

        },
        error:function(data)
        {

        }
    })


})


//




  

    //
$(document).on("click",".remove",function(){
   var r = confirm("Are you sure ?");

     
       if (r === false) {
           return false;
        }
})
  //

 $(document).ready(function(){

get_data('change')

})


function get_data($statesave)
{

var type=$("#type").val();

if ($.fn.DataTable.isDataTable('.yajra-datatable')) {
   $('.yajra-datatable').DataTable().destroy()
}


     var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: $statesave,
        ajax: {
        url: "{{ route('get_lunched_franchise') }}",
        data: {type:type},
    },
      
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
          
            {data: 'basic_details', name: 'basic_details'},
            {data: 'location', name: 'location'},
            
           {data: 'subscription', name: 'subscription'},
           {data: 'expire_date', name: 'expire_date'},
       
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ],
        initComplete: function(settings, json) {

      $(".custom_body").each(function() {
        var id=$(this).attr('id');
      
        
       //
          });
      },  

    });
    //

   
}

</script>

@endsection