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

 <select name="brand" id="brand" class="form-control valid" required>
     <option value="">--Select Brands--</option>
     @foreach($brands as $brand)
     <option value="{{ $brand->id }}">{{ $brand->brand }}</option>
     @endforeach
     </select >

      </div>
       <div class="col-md-5">

 <select name="item_type" id="item_type" class="form-control valid" required>
     <option value="">--Select Item Iype--</option>
     
 
     <option value="Disposable">Disposable</option>
     <option value="Frozen">Frozen</option>
     <option value="Masala">Masala</option>
     <option value="Grocery">Grocery</option>
<option value="Vegetable">Vegetable</option>
<option value="Syrup">Syrup</option>
<option value="Sauce">Sauce</option>
<option value="Bakery">Bakery</option>
<option value="Crush">Crush</option>
<option value="Dairy">Dairy</option>
</select>  
     </select >

      </div>

      <div class="col-md-2">
<button class="btn btn-success btn-block find">Find Item</button>

        </div>


</div>


</div>
</section>
	<section class="col-lg-12 connectedSortable">
	<div class="card direct-chat direct-chat-primary">
		<div class="flex-container">
  <div class="flex-item-left"><h5>Stock List</h5></div>
 <!--  <div class="flex-item-right"><a href="{{URL::route('add_supplylist')}}"><button class="btn btn-success"><span class="fa fa-plus"></span> Add Item</button></a></div> -->
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
  <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th >S.No.</th>
                <th>Image</th>
                <th>Item Type</th>
                <th>Item Name</th>
                <th>Unit</th>
                <th>Company Rate</th>
                <th>Fanchise Rate</th>
                <th>GST</th>
                <th>Brand</th>
                <th>Threshold QTY</th>
                <th>Desc</th>
                <!-- <th width="250px">Action</th> -->
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>


 

  <!-- The Modal -->
  <div class="modal fade" id="uploads">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Images</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="post" action="#" id="uploads_image" name="uploads_image" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="" id="item_id">
            <input type="hidden" name="image_type" value="1" >
        <!-- Modal body -->
        <div class="modal-body">
       <div class="col-lg-12">
<div class="form-group">
<label for="" >Item Images</label>
{!! Form::file("images[]",["class"=>"form-control","required"=>"","multiple"=>'',"accept"=>"image/png, image/gif, image/jpeg"]) !!}
<span class="text-danger">{{ $errors->first('images') }}</span>   
</div>
</div>
<div class="col-lg-12 uploads_body">


</div>
        

<div align="center">
         <button type="button" name="btn_login_details" id="btn_login_details" class="btn btn-info btn-lg">Save</button>
        </div>
        </div>

        </form>
        <!-- Modal footer -->
       
        
      </div>
    </div>
  </div>


  <!-- Edit Modal -->
  <div class="modal fade" id="edit_modal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit</h4>
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
$(document).on("keyup change",".number_test",function(){
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');

})

</script>
<script type="text/javascript">
    //
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     //
     $(document).on("click",".delete_image",function(e){
        e.preventDefault()
        var id =$(this).attr('id')
        var button=$(this)
        var result = confirm("Want to delete?");
              if (result) {
                var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/delete_item_image',
        data:{id:id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
            button.parent().parent().css("display","none")

        },
        error:function(data)
        {

        }
    })

            

         }
     })
     //
    $(document).on("click",".uploads",function(){
  var id=$(this).attr('id')


  $("#item_id").val("").val(id)
  //
  var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/get_item_image',
        data:{id:id,image_type:1},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
            console.log(data)
          $(".uploads_body").html('').html(data)

        },
        error:function(data)
        {

        }
    })
  //
  $('#uploads').modal('toggle');
})
    //
    $('#btn_login_details').click(function(){
        $('#uploads').modal('hide');
    $("#overlay").fadeIn(300);
  var form_data = new FormData($("#uploads_image")[0]);
 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/uploads_list_image',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
        swal("Done !", 'Successfully Images Uploaded', "success");
        get_data('nochange')
     
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
    //
    $(document).on("click",".edit",function(){
    var id=$(this).attr('id');
    var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/edit_supply_list',
        data:{id:id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
            console.log(data)
          $(".add_body").html('').html(data)
            $('.select2').select2();
        },
        error:function(data)
        {

        }
    })
     
     $('#edit_modal').modal('toggle');

    })
    //update_first_stock
    $(document).on("submit", "#update_supply_list", function (event) {

  event.preventDefault();

   $('#edit_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#update_supply_list")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/update_supply_list',
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
        get_data('nochange')
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
	  //
$(document).on("click",".remove",function(){
   var r = confirm("Are you sure ?");

     
       if (r === false) {
           return false;
        }
})
  //
// $(document).ready(function(){
// get_data('change')
// })
$(document).on("click",".find",function(){
  get_data('change')  
})
function get_data($statesave)
{
var brand=$("#brand").val()
if(brand=='')
{
    var brand='NA';
    alert('Kindly Select Brand')
    return false;
}
var item_type=$("#item_type").val()
if(item_type=='')
{
    var item_type='NA';
}

if ($.fn.DataTable.isDataTable('.yajra-datatable')) {
   $('.yajra-datatable').DataTable().destroy()
}

 var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
        url: "{{ route('supplylist') }}",
         data: {brand:brand,item_type:item_type},
    },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'image', name: 'image'},
             {data: 'item_type', name: 'item_type'},
            {data: 'product_name', name: 'product_name'},
            {data: 'unit', name: 'unit'},
            {data: 'company_rate', name: 'company_rate'},
            {data: 'franchise_rate', name: 'franchise_rate'},
            {data: 'gst', name: 'gst'},
            {data: 'thumb', name: 'thumb'},
            {data: 'threshold_qty', name: 'threshold_qty'},
            {data: 'description', name: 'description'},
       
            
        ]
    });
}
 
</script>

@endsection