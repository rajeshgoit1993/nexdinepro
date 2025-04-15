@extends("layouts.backend.master")

@section('maincontent')
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
    <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    @if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1) 

 <div class="row">
   <div class="col-lg-2">
      <label>Select Region</label>
      <select name="region" id="region" class="form-control">
        <option value="0">All</option>
        @foreach($regions as $region)
    <option value="{{$region->id}}">{{$region->region_name}}</option>
        @endforeach
 
     </select>
      </div>
   <div class="col-lg-2">
      <label>Select City</label>
      <select name="city" id="city" class="form-control">
        <option value="0">All</option>
        @foreach($cities as $city)
    <option value="{{$city}}">{{$city}}</option>
        @endforeach
 
     </select>
      </div>
     <div class="col-lg-4">
      <label>Select Outlet</label>
      <select name="outlet" id="outlet" class="form-control">
    <option value="">--Select Outlet--</option>
   @include('report.pos.outlets')
     </select>
      </div>
        <div class="col-lg-2">
             <label>Select Item Iype</label>
      <select name="item_type" id="item_type" class="form-control valid" required>
     <option value="">--Select Item Iype--</option>
     
     <option value="Utensil">Utensil</option>
     <option value="Equipment">Equipment</option>
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
      </div>
      <div class="col-lg-2">
   <label style="visibility: hidden;">NA</label>
 <button class="btn btn-success btn-block find">Find Item</button>
      </div>
     

   

</div>

@elseif(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise')) 
 
         <div class="row">
<input type="hidden" id="outlet" name="" value="{{Sentinel::getUser()->parent_id}}">
<input type="hidden" id="city" name="" value="NA">
<input type="hidden" id="region" name="" value="NA">
     <div class="col-md-10">
        <label>Select Item Iype</label>
     <select name="item_type" id="item_type" class="form-control valid" required>
     <option value="">--Select Item Iype--</option>
     
     <option value="Utensil">Utensil</option>
     <option value="Equipment">Equipment</option>
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
      </div>
      <div class="col-md-2">
      <label style="visibility: hidden;">NA</label>
 <button class="btn btn-success btn-block find">Find Item</button>
      </div>

  


</div>

@endif
        


</div>
</section>

    <section class="col-lg-12 connectedSortable">
    <div class="card direct-chat direct-chat-primary">
        <div class="flex-container">
  <div class="flex-item-left"><h5>Product List</h5></div>
  <div class="flex-item-right">
    <a href="#" ><button class="btn btn-success add_product"><span class="fa fa-plus"></span> Add Product</button></a>
    <a href="#"><button class="btn btn-primary export"><span class="
fas fa-file-export"></span> Export</button></a>

<a href="#" class="import_stock btn btn-info "><i class="fas fa-file-import"></i> Import Stock</a>


  </div>
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
                <th>Product Type</th>
                <th>Product Name</th>
                <th>Code</th>
                <th>Unit</th>
                <th>Rate</th>
                
                <th>GST</th>
               
                <th>Thsld QTY</th>
                <th>Avl QTY</th>
                <th>Desc</th>
                <th>Action</th>
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
            <input type="hidden" name="image_type" value="0">
        <!-- Modal body -->
        <div class="modal-body">
       <div class="col-lg-12">
<div class="form-group">
<label for="" >Item Images</label>
{!! Form::file("images[]",["class"=>"form-control","id"=>"images","required"=>"","multiple"=>'',"accept"=>"image/png, image/gif, image/jpeg"]) !!}
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
  <div class="modal fade" id="add_modal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Product</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
       <div class="add_product_body"></div>
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

  <!-- Edit Modal -->
  <div class="modal fade" id="edit_qty_modal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
       <div class="edit_qty_body"></div>
        <!-- Modal footer -->
       
        
      </div>
    </div>
  </div>

     <!---->
  <div class="modal fade" id="stock_upload">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Release the Stock</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
       {!! Form::open(["files"=>true,'id'=>'store_stock'])!!}


<!-- Modal content-->
<div class="">

<div class="modal-body">
<div class="row">
 

  
   
     <div class="col-lg-12">
        <div class="form-group">
<label for="" >Date</label>
<input type="date" name="date" value="{{date('Y-m-d')}}" max="{{date('Y-m-d')}}" min="{{date('Y-m-d')}}" class="form-control"> 
</div>

<div class="form-group upload_form">
  
</div>


    </div>
     


</div>



</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Release the Stock',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}
        
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

//
</script>
<script type="text/javascript">
    //
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     //
        $(document).on("click",".import_stock",function(){

var outlet_id=$("#outlet").val();

    if(outlet_id=='')
    {
   alert('Select Any Outlet')
    }
    else
    {
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/get_import_stock_form',
        data:{outlet_id:outlet_id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
       $(".upload_form").html('').html(data)
      $('#stock_upload').modal('toggle');

        },
        error:function(data)
        {

        }
    })

    }
  


 
  })
        //
    
     $(document).on("submit", "#store_stock", function (event) {

  event.preventDefault();

   
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#store_stock")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/store_stock_by_excel',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
            $('#stock_upload').modal('hide');
       swal("Done !", 'Successfully Updated', "success");
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
});
 //
     //
    $(document).on("click",".edit_qty",function(){
    var id=$(this).attr('id');
    var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/edit_stock_list',
        data:{id:id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
           
          $(".edit_qty_body").html('').html(data)
           $('.select2').select2();
        },
        error:function(data)
        {

        }
    })

     $('#edit_qty_modal').modal('toggle');

    })
    //update_first_stock
    $(document).on("submit", "#update_product_qty", function (event) {

  event.preventDefault();

   $('#edit_qty_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#update_product_qty")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/update_stock_list',
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
  //region
  $(document).on("change","#region",function(){
var region=$(this).val()
  $("#overlay").fadeIn(300);
var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/get_region_wise_data',
        data:{region:region},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {

         $("#overlay").fadeOut(300);
        $("#city").html('').html(data.output_city)
         $("#outlet").html('').html('<option value="">--Select Outlet--</option>'+data.output_outlet)

        },
        error:function(data)
        {

        }
    })

})
//
$(document).on("change","#city",function(){
var city=$(this).val()
var region=$("#region").val()
  $("#overlay").fadeIn(300);
var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/get_city_wise_outlet',
        data:{city:city,region:region},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {

         $("#overlay").fadeOut(300);
        $("#outlet").html('').html('<option value="">--Select Outlet--</option>'+data)

        },
        error:function(data)
        {

        }
    })

})


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
 $('#images').val('')

  $("#item_id").val("").val(id)
  //
  var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/get_item_image',
        data:{id:id,image_type:0},
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
    //add_product
    $(document).on("click",".add_product",function(){
    var outlet_id=$("#outlet").val();

    if(outlet_id=='')
    {
   alert('Select Any Outlet')
    }
    else
    {
       var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/add_product',
        data:{outlet_id:outlet_id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
           
          $(".add_product_body").html('').html(data)
           $('.select2').select2();
           $('#add_modal').modal('toggle');  
        },
        error:function(data)
        {

        }
    })

     
    }
   

    })
     $(document).on("submit", "#create_product_list", function (event) {

  event.preventDefault();

   
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#create_product_list")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/store_product',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
        $('#add_modal').modal('hide');
       swal("Done !", 'Successfully Added', "success");
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
    $(document).on("click",".edit",function(){
    var id=$(this).attr('id');
    var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/edit_product_list',
        data:{id:id},
        type:'post',
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
    //update_first_stock
    $(document).on("submit", "#update_product_list", function (event) {

  event.preventDefault();

   
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#update_product_list")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/update_product_list',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
        $('#edit_modal').modal('hide');
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


    })
      //
$(document).on("click",".remove",function(){
   var r = confirm("Are you sure ?");

     
       if (r === false) {
           return false;
        }
})
$(document).on("click",".export",function(){
  var outlet_id=$("#outlet").val()
if(outlet_id=='')
{
    alert('Select Any Outlet')
}
else
{
  
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "export_master_product";
  
     var element2 = document.createElement("INPUT");         
    element2.name="_token"
    element2.value = $('meta[name="csrf-token"]').attr('content')
    element2.type = 'hidden'
    form.appendChild(element2);

   var element1 = document.createElement("INPUT");         
    element1.name="outlet_id"
    element1.value = outlet_id;
    element1.type = 'hidden'
    form.appendChild(element1);
    
   
    form.submit(); 
}
})

  //
$(document).ready(function(){
   get_data('change')  


})
$(document).on("click",".find",function(){
  var outlet_id=$("#outlet").val()
if(outlet_id=='')
{
    alert('Select Any Outlet')
}
else
{
  get_data('change')  
}
})
function get_data($statesave)
{

var item_type=$("#item_type").val()
if(item_type=='')
{
    var item_type='NA';
}
var outlet_id=$("#outlet").val()
if(outlet_id=='')
{
    alert('Select Any Outlet')
}
else
{
if ($.fn.DataTable.isDataTable('.yajra-datatable')) {
   $('.yajra-datatable').DataTable().destroy()
}

     var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: $statesave,
        ajax: {
        url: "{{ route('get_product') }}",
        data: {outlet_id:outlet_id,item_type:item_type},
    },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'image', name: 'image'},
            {data: 'item_type', name: 'item_type'},
            {data: 'product_name', name: 'product_name'},
             {data: 'code', name: 'code'},
            {data: 'unit', name: 'unit'},
            {data: 'rate', name: 'rate'},
           
             {data: 'gst', name: 'gst'},
            
            {data: 'threshold_qty', name: 'threshold_qty'},
            {data: 'available_qty', name: 'available_qty'},
            {data: 'description', name: 'description'},
       
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });     
}

}
 
</script>

@endsection