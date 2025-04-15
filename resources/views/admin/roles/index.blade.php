@extends("layouts.backend.master")

@section('maincontent')
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
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
  <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    <div class="flex-container">
  <div class="flex-item-left"><h5>Role List</h5></div>
 <div class="flex-item-right"><a href="{{URL::route('add_role')}}"><button class="btn btn-success"><span class="fa fa-plus"></span> Add Role</button></a></div> 
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
      <th>Role Name</th>
      <th>Role</th>
      <th>Created Date</th>
      <th>Access Page</th>
 <!--      <th>Actions</th> -->
    </tr>
    </thead>
  <?php
   $sn=1;
  ?>
   <tbody>
    @foreach($roles as $row)   


                  <tr id="">
                    <td>{{$sn++}}</td>
                    <td class="role_name">
                      <span>{{$row->name}}</span>
                    </td>

                    <td class="role_slug">
                      <span>
                        @if($row->slug=='fanchise')
                        franchise
                        @else
                        {{$row->slug}}
                        @endif
                      
                      </span>
                    </td>

                    <td class="role_created_date">
                      <span>{{$row->created_at}}</span>
                    </td>
                    <td class="role_created_date">
                      @if($row->id==1 || $row->id==2 || $row->id==12 || $row->id==17 || $row->id==18 || $row->id==19 || $row->id==20 || $row->id==21 || $row->id==27)

                      @else
                   <button type="button" class="btn btn-primary open_page" id="{{CustomHelpers::custom_encrypt($row->id)}}">
                     Open
                  </button>
                   <a href="{{url('Role-edit/'.CustomHelpers::custom_encrypt($row->id))}}"><button class="btn btn-success"><span class="glyphicon glyphicon-edit"></span> Edit</button></a>
                   
                      @endif
                    </td>
                <!--    <td>
   
           <a href="{{url('Role-Delete/'.$row->id)}}"><button class="btn btn-danger" onclick="return confirm('Are you sure?');" ><span class="glyphicon glyphicon-remove"></span> Delete</button></a>

                    </td> -->

                  </tr>

                @endforeach
                </tbody>
    </table>







<!---->



  <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Access Page</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
     {!! Form::open(["files"=>true,'id'=>"page_access_form","name"=>"page_access_form"])!!}
  <input type="hidden" name="id" id="page_access_data" value="">   
        <!-- Modal body -->
        <div class="modal-body page_access_data">
         
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


<!-- /.content -->
</div>
</div>
</section>

</div>

</div>
</section>

</div>
@endsection
@section('custom_js')
<script type="text/javascript">
  //

     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  //
$(document).on("click","#submit",function(){
  var form_data = new FormData($("#page_access_form")[0]);
 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/save_page_access_data',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
         
        if(data=='success')
        {
       swal("Done !", 'Successfully Updated', "success");
        var url=APP_URL+'/Role';
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


})
//
$(document).on("click",".open_page",function(){
var id=$(this).attr('id')
$("#page_access_data").val('').val(id)

var APP_URL=$("#APP_URL").val();
 $.ajax({
        url:APP_URL+'/get_page_access_data',
        data:{id:id},
        type:'post',
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