@extends("layouts.backend.master")

@section('maincontent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
	<section class="col-lg-12 connectedSortable">
	<div class="card direct-chat direct-chat-primary">
		
         <div class="row">

<div class="col-md-5">

 <select name="state" id="state" class="form-control valid" required>
     <option value="">--Select State--</option>
     @foreach($states as $state)
     <option value="{{ $state->state_title }}" state_id="{{ $state->id }}">{{ $state->state_title }}</option>
     @endforeach
     </select >

      </div>
      <div class="col-md-5">

   <select name="dist" id="dist" class="form-control valid" required>
     <option value="">--Select District--</option>
   
     </select>

      </div>
      <div class="col-md-2">
<button class="btn btn-success btn-block find_city">Find City</button>

        </div>


</div>


</div>
</section>

    <section class="col-lg-12 connectedSortable">
    <div class="card direct-chat direct-chat-primary">
        <div class="flex-container">
  <div class="flex-item-left"><h5>City List</h5></div>
  <div class="flex-item-right"><a href="#"><button class="btn btn-success add_city"><span class="fa fa-plus"></span> Add City</button></a></div>
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
  <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th width="50px">S.No.</th>
               
                 <th>City</th>
                 
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>










<!-- /.content -->
</div>
</section>

</div>

</div>
</section>

</div>
<!---->
 <!-- The Modal -->
  <div class="modal fade" id="city_add">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add City</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
       
        <!-- Modal body -->
        <div class="modal-body">
      <form action="#" method="post" id="city_save" name="city_save">
             {{csrf_field()}}
    <div class="modal-body">
   <input type="hidden" name="districtid" id="districtid">
    <input type="hidden" name="state_id" id="state_id">
     <div class="form-group">
<label for="">City</label>
<input type="text" name="name" class="form-control" required=""  required>

 
</div>
    
<button type="submit" class="btn btn-success">Save</button>
             
             </div>
       </form>
        </div>

        
        <!-- Modal footer -->
       
        
      </div>
    </div>
  </div>
<!---->
<div class="modal fade" id="edit_add">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add City</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
       
        <!-- Modal body -->
         <form action="#" method="post" id="city_update" name="city_update">
             {{csrf_field()}}
        <div class="modal-body edit_city_part">
     
 
             
             
     
        </div>
  </form>
        
        <!-- Modal footer -->
       
        
      </div>
    </div>
  </div>
@endsection
@section('custom_js')
<script type="text/javascript">
        $(document).on('click',".add_city",function(e){
    e.preventDefault();
var state=$("#state").val()
var dist=$("#dist").val()
if(state=='' || dist=='')
{
 alert('Kindly Select State & District both')
}
else
{
  var state=$("#state option:selected").attr("state_id")
  var dist=$("#dist option:selected").attr("dist_id")

$("#districtid").val('').val(dist)
$("#state_id").val('').val(state)
  $('#city_add').modal('toggle');

}

 })

//
//city_save
 $("#city_save").on("submit", function(e){
 e.preventDefault()
 var APP_URL=$("#APP_URL").val();
     $.ajax({
            url : APP_URL+'/city_save',
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            // dataType: "JSON",
            success: function(data)
            {

               if(data=='success')
               {
              swal({
                  title: "Done !",
                  text: "Successfully Added !",
                  icon: "success",
                  timer:500
                   });
          
               get_city_datable()
               }
               else
               {
              swal("Error", data, "error"); 
               }
          
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });

 })
 //
    $(document).on('click',".edit",function(e){
    e.preventDefault();


 var id=$(this).attr('id')
 var APP_URL=$("#APP_URL").val();

//
  $.ajax({
        type: 'get',
        url: APP_URL + '/edit-city',
        // dataType: 'json',
        data: {id:id},
        success: function (data) {
        
            $(".edit_city_part").html('').html(data)
         $('#edit_add').modal('toggle');
        },
        error: function (data) {
            //console.log('Error : '+data);
          
        }
    });

//


    })
    //
     $("#city_update").on("submit", function(e){
 e.preventDefault()
  var APP_URL=$("#APP_URL").val();
     $.ajax({
            url : APP_URL + '/update_city',
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            // dataType: "JSON",
            success: function(data)
            {
               if(data=='success')
               {
                swal({
                  title: "Done !",
                  text: "Successfully Updated !",
                  icon: "success",
                  timer:500
                   });
           
               get_city_datable()
              
               }
               else
               {
              swal("Error", data, "error"); 
               }
          
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });

 })
     //
     $(document).on('click',".delete",function(e){
e.preventDefault();
 var id=$(this).attr('id')
    var APP_URL=$("#APP_URL").val();
 var button=$(this).parent().parent()
 // .css('display','none')
  var isGood =confirm('Are you sure ?');
  if (isGood) {
$("#overlay").fadeIn(300);
      $.ajax({
        type: 'get',
        url: APP_URL + '/delete-city',
        // dataType: 'json',
        data: {id:id},
        success: function (data) {
         button.css('display','none')
         // console.log(data)
           $("#overlay").fadeOut(300);
           //  get_city_datable()
        },
        error: function (data) {
            //console.log('Error : '+data);
          
        }
    });
    
  } else {
   
  }
 })
    //
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
//

//
$(document).on("click",".find_city",function(){

var state=$("#state").val()
var dist=$("#dist").val()
if(state=='' || dist=='')
{
  alert('Kindly Select State & District both')
}
else
{

get_city_datable()

   } 
})
//
function get_city_datable()
  {

   
var dist_id=$("#dist option:selected").attr("dist_id")

if ($.fn.DataTable.isDataTable('.yajra-datatable')) {
   $('.yajra-datatable').DataTable().destroy()
}
    
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
        url: "{{ route('get_city') }}",
        data: {dist_id:dist_id},
    },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
          
       
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
      
    });
  }


	  //
$(document).on("click",".remove",function(){
   var r = confirm("Are you sure ?");

     
       if (r === false) {
           return false;
        }
})
  //

  // $(function () {
    
  //   var table = $('.yajra-datatable').DataTable({
  //       processing: true,
  //       serverSide: true,
  //       ajax: {
  //       url: "{{ route('transport') }}",
  //       data: {a:'2'},
       
  //   },
       
  //       columns: [
  //           {data: 'DT_RowIndex', name: 'DT_RowIndex'},
  //           {data: 'state', name: 'state'},
  //           {data: 'dist', name: 'dist'},
  //           {data: 'city', name: 'city'},
  //           {data: 'unit', name: 'unit'},
  //           {data: 'fee', name: 'fee'},
  //           {data: 'gst', name: 'gst'},
       
  //           {
  //               data: 'action', 
  //               name: 'action', 
  //               orderable: true, 
  //               searchable: true
  //           },
  //       ]
  //   });
    
  // });
</script>

@endsection