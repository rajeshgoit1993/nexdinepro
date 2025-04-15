@extends("layouts.backend.master")

@section('maincontent')
<style type="text/css">
  span {cursor:pointer; }
    .number{
      margin:10px;
      text-align: center;
    }
    .minus, .plus{
      width:35px;
      height:35px;
      background:#f2f2f2;
      border-radius:4px;
      padding:8px 5px 8px 5px;
      border:1px solid #ddd;
      display: inline-block;
      vertical-align: middle;
      text-align: center;
    }
    input{
      height:35px;
      width: 100px;
      text-align: center;
      font-size: 26px;
      border:1px solid #ddd;
      border-radius:4px;
      display: inline-block;
      vertical-align: middle;
      
    </style>
    <!-- <style type="text/css">
  .count {
    disabled: true; 
  }
</style> -->
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
     <option value="">--Select Factory--</option>
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


	<section class="col-lg-12 connectedSortable">
	<div class="card direct-chat direct-chat-primary">
		<div class="flex-container">
  <div class="flex-item-left"><h5>Factory Ingredients List</h5></div>
  <div class="flex-item-right"><a href="#"><button class="btn btn-success add"><span class="fa fa-plus"></span> Add Ingredients</button></a></div>
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
               <th>Name</th>
               <th>Unit</th>
                <th>Rate</th>
              
               
                <th>Threshold QTY</th>
               <th>Available Qty</th>
               <th>Actions</th>
            </tr>
        </thead>
        <tbody>
       </tbody>
    </table>








 <!-- Edit Modal -->
  <div class="modal fade" id="edit_modal">
    <div class="modal-dialog modal-xl">
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
<div class="modal fade" id="cart_data">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
       <!--    <h4 class="modal-title">First Stock List</h4> -->
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body cart_data_value">
        
        </div>
        
        <!-- Modal footer -->
         <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success submit_cart" store_id="">Submit</button>
        </div>
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


<style type="text/css">
  .badge {
  padding-left: 15px;
  padding-right: 15px;
  -webkit-border-radius: 15px;
  -moz-border-radius: 15px;
  border-radius: 15px;
}

.label-warning[href],
.badge-warning[href] {
  background-color: #c67605;
}
#lblCartCount {
    font-size: 20px;
    background: #ff0000;
    color: #fff;
    padding: 0 10px;
    vertical-align: top;
    margin-left: -10px; 
}
</style>
<div class="cart" style="    position: fixed;
    right: 50px;
    bottom: 30px;
    display: block;">

<i class="fa" style="font-size:50px">&#xf07a;</i>
<span class='badge badge-warning' id='lblCartCount'> 

</span>
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

  $(document).on("keyup change",".count",function(){
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    var count_value=$(this).val();
     if(count_value>=1)
     {
       var current=$(this)
        //
        var new_value=count_value;
        var APP_URL=$("#APP_URL").val();
         if(new_value==0)
       {
        current.parent().parent().parent().css("display","none")
        }
        var cart_id=$(this).siblings('.plus').attr('cart_id')
   $.ajax({
        url:APP_URL+'/factory_qty_change',
        data:{cart_id:cart_id,new_value:new_value},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
        if(new_value==0)
       {
       get_factory_ingredients_data('change')
        }


        },
        error:function(data)
        {

        }
    })


     }
   
})

//

 $(document).on("focusout",".count",function(){
   
    var count_value=$(this).val();
   if(count_value<1)
   {
  
    //
         var current=$(this)
        //
        var new_value=count_value;
        var APP_URL=$("#APP_URL").val();
         if(new_value==0)
       {
        current.parent().parent().parent().css("display","none")
        }
        var cart_id=$(this).siblings('.plus').attr('cart_id')
   $.ajax({
        url:APP_URL+'/factory_qty_change',
        data:{cart_id:cart_id,new_value:new_value},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
            
        if(new_value==0)
       {
       get_factory_ingredients_data('change')
        }


        },
        error:function(data)
        {

        }
    })

  
   }
   
})


        $(document).ready(function() {
        // $('.count').prop('disabled', true);

   $(document).on('click','.minus',function(){
      var current=$(this)
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        count = count < 0 ? 0 : count;
        $input.val(count);
        $input.change();
         //
        var new_value=$input.val();
        var APP_URL=$("#APP_URL").val();
       if(new_value==0)
       {
        current.parent().parent().parent().css("display","none")
        }
         var cart_id=$(this).attr('cart_id')
  
  $.ajax({
        url:APP_URL+'/factory_qty_change',
        data:{cart_id:cart_id,new_value:new_value},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
        if(new_value==0)
       {
       get_factory_ingredients_data('change')
        }

            
//           if(data.button!='')
//           {
// current.parent().siblings('.cart').html('').html(data.button)
// current.parent().html('')
//           }
//           $("#lblCartCount").html('').html(data.count)
        },
        error:function(data)
        {

        }
    })
    //
        return false;
      });
      $(document).on('click','.plus',function(){
  // $('.count').prop('disabled', true);
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        //
        var new_value=$input.val();
        var APP_URL=$("#APP_URL").val();

        var cart_id=$(this).attr('cart_id')
  $.ajax({
        url:APP_URL+'/factory_qty_change',
        data:{cart_id:cart_id,new_value:new_value},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
          
        },
        error:function(data)
        {

        }
    })
    //

        return false;
      });
    })
        //
         //add_to_cart
$(document).on("click",".add_to_cart",function(){

 var APP_URL=$("#APP_URL").val();
 var item_id=$(this).attr('item_id')
 var store_id=$(this).attr('store_id')
 var current=$(this)
   $.ajax({
        url:APP_URL+'/factory_add_to_cart',
        data:{item_id:item_id,store_id:store_id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
         current.removeClass('add_to_cart')
         current.html('').html('Added')
        
         $('#lblCartCount').html('').html(data.count)
        
        },
        error:function(data)
        {

        }
    }) 
})
//
 $(document).on("click","#lblCartCount",function(){
 
   //
 
      
        var APP_URL=$("#APP_URL").val();
        var store_id=$("#store").val()

        $(".submit_cart").attr("store_id",store_id)
       
  $.ajax({
        url:APP_URL+'/get_factory_cart_data',
        data:{store_id:store_id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {

          $(".cart_data_value").html('').html(data)
         $('#cart_data').modal('toggle');
          // $('.count').prop('disabled', true);
        },
        error:function(data)
        {

        }
    })
    //


})
 //
   $(document).on("click",".submit_cart",function(e){
  e.preventDefault();
 var APP_URL=$("#APP_URL").val();
 var store_id=$(this).attr('store_id')
 $('#cart_data').modal('hide');
 $("#overlay").fadeIn(300);
  $.ajax({
        url:APP_URL+'/submit_cart_by_factory',
        data:{store_id:store_id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300); 
            if(data=='success')
            {
          swal("Done !", 'Successfully Ordered', "success");
          get_factory_ingredients_data('change')
            }
            else
            {
           swal("Error !", 'Cart Item Empty', "error");     
            }
          
        
     
        },
        error:function(data)
        {

        }
    })

})
    //
    $(document).on("click",".add",function(){
    var store=$("#store").val()

    if(store=='')
    {
   alert('Kindly Select Store')
    }
   else
   {
    $(".custom_title").html('').html('Add Ingredients')
    var id=$("#store").val()
    var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/create_factory_ingredients',
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


   } 
  

    })
 //
  $(document).on("submit", "#add_factory_ingredients", function (event) {

  event.preventDefault();

   $('#edit_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#add_factory_ingredients")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/add_factory_ingredients',
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
        get_factory_ingredients_data('nochange')
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
    $(document).on("click",".edit",function(){
  


    $(".custom_title").html('').html('Edit Ingredients')
    var id=$(this).attr('id');
    var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/edit_factory_ingredients',
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
      $(document).on("submit", "#update_factory_ingredients", function (event) {

  event.preventDefault();

   $('#edit_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#update_factory_ingredients")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/update_factory_ingredients',
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
        get_factory_ingredients_data('nochange')
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
$(document).on("click",".find",function(){

var store=$("#store").val()

if(store=='')
{
  alert('Kindly Select Store')
}
else
{

get_factory_ingredients_data('change')

   } 
})
function get_factory_ingredients_data($statesave)
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
        url: "{{ route('get_factory_ingredients_data') }}",
        data: {store:store},
    },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
           
            {data: 'product_name', name: 'product_name'},
            {data: 'unit', name: 'unit'},
            {data: 'rate_margin', name: 'rate_margin'},
     
            {data: 'threshold_qty', name: 'threshold_qty'},
            {data: 'avl_qty', name: 'avl_qty'},
         
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
      
    });

     var store_id=$("#store").val()
var APP_URL=$("#APP_URL").val();
   $.ajax({
        url:APP_URL+'/factory_cart_count',
        data:{store_id:store_id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
        
         $('#lblCartCount').html('').html(data.count)
        
        },
        error:function(data)
        {

        }
    })

  }
</script>

@endsection