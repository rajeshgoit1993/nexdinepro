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

     <div class="col-md-10">

 <select name="store" id="store" class="form-control valid" required>
     <option value="">--Select Vendor--</option>
     @foreach($datas as $data)
     <option value="{{ $data->id }}">{{ $data->name }}</option>
     @endforeach
     </select >

      </div>
     <!--    <div class="col-md-5">

 <select name="store" id="store" class="form-control valid" required>
     <option value="">--Select Type--</option>

     <option value="ingredients">Factory Ingredients</option>
     <option value="items">Items</option>
     </select >

      </div> -->

      <div class="col-md-2">
<button class="btn btn-success btn-block find">Find Data</button>

        </div>


</div>


</div>
</section>


<!-- 	<section class="col-lg-12 connectedSortable">
	<div class="card direct-chat direct-chat-primary">
		<div class="flex-container">
  <div class="flex-item-left"><h5>Stores List</h5></div>
  <div class="flex-item-right"><a href="{{URL::route('add_store')}}"><button class="btn btn-success"><span class="fa fa-plus"></span> Add Store</button></a></div>
</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
</div>
</section> -->
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<!-- /.content -->
  <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th width="50px">S.No.</th>
             
                <th>Image</th>
               <th>Name</th>
               <th>Unit</th>
              
              <!-- 
               <th>Actions</th> -->
            </tr>
        </thead>
        <tbody>
       </tbody>
    </table>







<!-- Edit Modal -->
  <div class="modal fade" id="edit_modal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title custom_title">Edit</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
       <div class="add_body"></div>
        <!-- Modal footer -->
       
        
      </div>
    </div>
  </div>


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
  //
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
//
 //add certifications
 $(document).on("click","#add_certification",function(e){
    e.preventDefault()
var name_count1=$(".dynamic_four").children("div:last").attr("id").slice(7)
console.log(name_count1)
var name_count=parseInt(name_count1)-"1";
name_count1++
name_count++
$(".dynamic_four").append('<div id="fourrow'+name_count1+'" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray"><div class="row"><div class="col-md-5"><select name="ingredients['+name_count+'][id]" class="form-control valid" id="add_ing'+name_count+'"><option value="" >--Select Ingredients--</option></select></div><div class="col-md-4"><input type="text" name="ingredients['+name_count+'][qty]"  class="form-control valid"  placeholder="Ingredients Qty"></div><div class="col-md-3"><button type="button" name="remove" id="'+name_count1+'" class="btn btn-danger btn_remove_four" style="margin-bottom: 5px">x Remove </button></div></div></div>');
   //
  var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/get_ingredients_list',
      
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
            console.log(data)
          $("#add_ing"+name_count).html('').html(data)
          
        },
        error:function(data)
        {

        }
    })
//
 })
 //
 $(document).on('click', '.btn_remove_four', function() {
      var button_id = $(this).attr("id");
      $('#fourrow'+button_id+'').remove();
      }
      );
//
$(document).on("click",".edit",function(){
  
    $(".custom_title").html('').html('Add/Edit Product Ingredients')
    var id=$(this).attr('id');
    var factory_id=$("#store").val()
    var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/add_edit_product_ingredients',
        data:{id:id,factory_id:factory_id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
           
          $(".add_body").html('').html(data)
            $('.select2').select2();
        },
        error:function(data)
        {

        }
    })
     
     $('#edit_modal').modal('toggle');


  
  

    })
 //
 $(document).on("submit", "#add_product_ingredients", function (event) {

  event.preventDefault();

   $('#edit_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#add_product_ingredients")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/add_product_ingredients',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Added', "success");
        get_store_data('nochange')
        // var url=APP_URL+'/Utensil-List';
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
});
  //
$(document).on("click",".find",function(){

var store=$("#store").val()

if(store=='')
{
  alert('Kindly Select Store')
}
else
{

get_store_data('change')

   } 
})
function get_store_data($statesave)
  {
if($statesave=='change')
{
 $statesave=false;
}
else
{
$statesave=true;
}
   
var store=$("#store").val()

if ($.fn.DataTable.isDataTable('.yajra-datatable')) {
   $('.yajra-datatable').DataTable().destroy()
}
    
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: $statesave,
        ajax: {
        url: "{{ route('get_vendor_product') }}",
        data: {store:store},
    },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
           
            {data: 'image', name: 'image'},
            {data: 'name', name: 'name'},
            {data: 'unit', name: 'unit'},
        
         
            
        ]
      
    });
  }
</script>

@endsection