@extends("layouts.backend.master")

@section('maincontent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">

     @if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1) 

    <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
   

 <div class="row">
   <div class="col-lg-3">
      <label>Select Region</label>
      <select name="region" id="region" class="form-control">
        <option value="0">All</option>
        @foreach($regions as $region)
    <option value="{{$region->id}}">{{$region->region_name}}</option>
        @endforeach
 
     </select>
      </div>
   <div class="col-lg-3">
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
   <label style="visibility: hidden;">NA</label>
 <button class="btn btn-success btn-block find">Find </button>
      </div>
     

   

</div>


        


</div>
</section>

@elseif(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise')) 
 
        
<input type="hidden" id="outlet" name="" value="{{Sentinel::getUser()->parent_id}}">
<input type="hidden" id="city" name="" value="NA">
<input type="hidden" id="region" name="" value="NA">
  
  



@endif

  <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    <div class="flex-container">
  <div class="flex-item-left"><h5>Food Menu</h5></div>
  <div class="flex-item-right"><a href="#"><button class="btn btn-success add_food_menu"><span class="fa fa-plus"></span> Add Food Menu</button></a></div>
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
                <th width="50px">S.No.</th>
               
                <th>Code</th>
                <th>Name</th>
                <th>Category</th>
                <th>CP</th>
                <th>CP%</th>
                <th>SP</th>
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
//
<div class="modal fade" id="session_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Food Menu</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="session_modal">
         
        </div>
        
        <!-- Modal footer -->
       
        
      </div>
    </div>
  </div>
 <!---->
  <div class="modal fade" id="recipe_upload">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Upload Recipes</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
       {!! Form::open(["files"=>true,'id'=>'store_recipes'])!!}


<!-- Modal content-->
<div class="">

<div class="modal-body">
<div class="row">
 
    <input type="hidden" name="food_menu_id" id="food_menu_id" value="">
  
   
     <div class="col-lg-12">
            <div class="form-group">
<label for="" >Upload Recipe</label>
{!! Form::file("recipe",["class"=>"form-control","required"=>""]) !!}
<span class="text-danger">{{ $errors->first('recipe') }}</span>   
</div>
    </div>
     


</div>



</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}
        
        <!-- Modal footer -->
       
        
      </div>
    </div>
  </div>
@endsection
@section('custom_js')

<script src="{{url('resources/assets/admin-lte/js/outlet_by_change.js')}}" type="text/javascript"></script>

<script type="text/javascript">
    $(document).on("keyup change",".number_test",function(){
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');

})
    //add certifications
 $(document).on("click","#add_certification",function(e){
    e.preventDefault()
var name_count1=$(".dynamic_four").children("div:last").attr("id").slice(7)
console.log(name_count1)
var name_count=parseInt(name_count1)-"1";
name_count1++
name_count++
$(".dynamic_four").append('<div id="fourrow'+name_count1+'" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray"><div class="row"><div class="col-md-3"><select name="ingredients['+name_count+'][id]" class="form-control valid" id="add_ing'+name_count+'"><option value="" >--Select Ingredients--</option></select></div><div class="col-md-3"><input type="text" name="ingredients['+name_count+'][qty]"  class="form-control valid"  placeholder="Ingredients Qty"></div><div class="col-md-3"><select name="ingredients['+name_count+'][use_for]" class="form-control valid" required><option value="1">All</option><option value="2">Only Dine-in</option><option value="3">Only Take-away</option><option value="4">Only Delivery</option><option value="5">Take-away & Delivery</option><option value="6">Dine-in & Take-away</option><option value="7">Dine-in & Delivery</option></select></div> <div class="col-md-3"><button type="button" name="remove" id="'+name_count1+'" class="btn btn-danger btn_remove_four" style="margin-bottom: 5px">x Remove </button></div></div></div>');
   //
  var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/get_ingredients_list_food_menu',
      
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
    //
// $(document).on("click",".remove",function(){
//    var r = confirm("Are you sure ?");

     
//        if (r === false) {
//            return false;
//         }
// })
  //
   //
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     //

     $(document).on("click",".import_recipe",function(){
    var id=$(this).attr('id')
   $("#food_menu_id").val('').val(id)
   $('#recipe_upload').modal('toggle');
  })
     $(document).on("submit", "#store_recipes", function (event) {

  event.preventDefault();

   
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#store_recipes")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/store_recipes_by_excel',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
            $('#recipe_upload').modal('hide');
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

     //export_recipe

     $(document).on("click",".export_recipe",function(){
    var id=$(this).attr('id')
   
   
      var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "get_export_recipe";
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
$(document).on("click",".delete",function(){
var id=$(this).attr('id')
if(confirm("Are you sure?"))
    {
  $("#overlay").fadeIn(300);
var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/delete_foodmenu',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {

         $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Deleted', "success");
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
   }
  })
     //
      $(document).on("submit", "#update_foodmenu", function (event) {

  event.preventDefault();

   $('#session_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#update_foodmenu")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/update_foodmenu',
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

     //edit

$(document).on("click",".edit",function(){
var id=$(this).attr('id')
var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/edit_foodmenu',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {


       $(".session_modal").html('').html(data)
       $('#session_modal').modal('toggle');

        },
        error:function(data)
        {

        }
    })
   
  })
  

     //update_first_stock
    $(document).on("submit", "#store_foodmenu", function (event) {

  event.preventDefault();

   $('#session_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#store_foodmenu")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/store_foodmenu',
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
        get_data('nochange')
        // var url=APP_URL+'/Utensil-List';
        // window.location.href = url;
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
  $(document).on("click",".add_food_menu",function(){
 var outlet_id=$("#outlet").val()
if(outlet_id=='')
{
    alert('Select Any Outlet')
}
else
{
    var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/add_foodmenu',
        data:{outlet_id:outlet_id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {


       $(".session_modal").html('').html(data)
       $('#session_modal').modal('toggle');
        
        },
        error:function(data)
        {

        }
    })
}

   
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
$(document).ready(function(){
get_data('change')
})

  //
  function get_data($statesave)
{

 var outlet_id=$("#outlet").val()
if(outlet_id!='')
{
  if ($.fn.DataTable.isDataTable('.yajra-datatable')) {
   $('.yajra-datatable').DataTable().destroy()
}

     var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: $statesave,
        ajax: {
        url: "{{ route('get_food_menu') }}",
         data: {outlet_id:outlet_id},
    },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
           
            {data: 'code', name: 'code'},
            {data: 'name', name: 'name'},
            {data: 'category', name: 'category'},
            {data: 'cp', name: 'cp'},
            {data: 'cp_percentage', name: 'cp_percentage'},
            {data: 'sp', name: 'sp'},
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