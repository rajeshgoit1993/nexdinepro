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
 <!--    <style type="text/css">
  .count {
    disabled: true; 
  }
</style> -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
<!--  <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    
         <div class="row">

     <div class="col-md-10">

 <select name="store" id="store" class="form-control valid" required>
     <option value="">--Select Warehouse--</option>
     @foreach($datas as $data)
     <option value="{{ $data->id }}">{{ $data->name }}</option>
     @endforeach
     </select >

      </div>
     
      <div class="col-md-2">
<button class="btn btn-success btn-block find">Find Data</button>

        </div>


</div>


</div>
</section> -->

    @if(Sentinel::getUser()->inRole('superadmin')):
    <?php  
   $store_count=DB::table('stores')->where('type','=',1)->whereIn('status',[1,2])->get();
    ?>
    @if(count($store_count)>1)
 <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    
         <div class="row">

     <div class="col-md-10">

    <select name="store" id="store" class="form-control valid" required>
     <option value="">--Select Warehouse--</option>
     @foreach($datas as $data)
     <option value="{{ $data->id }}">{{ $data->name }}</option>
     @endforeach
     </select >

      </div>
     
      <div class="col-md-2">
<button class="btn btn-success btn-block find">Find Orders</button>

        </div>


</div>


</div>
</section>

@else
<?php 
 $store=DB::table('stores')->where('type','=',1)->whereIn('status',[1,2])->first();
?>
<input type="hidden" name="" id="store" value="{{$store->id}}">

@endif
 @else
<?php 
  $user_id=Sentinel::getUser()->id;
  $store_ids=DB::table('store_assign_users')->where([['user_id','=',$user_id],['type','=',1]])->pluck('store_id');
     
  $stores=DB::table('stores')->where('type','=',1)->whereIn('status',[1,2])->whereIn('id',$store_ids)->get();
?>
 @if(count($stores)>1)
 <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    
         <div class="row">

     <div class="col-md-10">

    <select name="store" id="store" class="form-control valid" required>
     <option value="">--Select Warehouse--</option>
     @foreach($stores as $data)
     <option value="{{ $data->id }}">{{ $data->name }}</option>
     @endforeach
     </select >

      </div>
     
      <div class="col-md-2">
<button class="btn btn-success btn-block find">Find Orders</button>

        </div>


</div>


</div>
</section>
 @else
    @foreach($stores as $data)
<input type="hidden" name="" id="store" value="{{$data->id}}">
     @endforeach

 @endif
 @endif
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
               <th>Threshold QTY</th>
               <th>Available Qty</th>
               <th>Status</th>
               <th>Actions</th>
            </tr>
        </thead>
        <tbody>
       </tbody>
    </table>






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
  
<div class="modal fade" id="edit_modal">
    <div class="modal-dialog">
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
  //
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //
     $(document).on("click",".edit",function(){
    var id=$(this).attr('id');
    var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/edit_wharehouse_stock',
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
    $(document).on("submit", "#update_wharehouse_product_list", function (event) {

  event.preventDefault();

   $('#edit_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#update_wharehouse_product_list")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/update_wharehouse_product_list',
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
    $(document).on("click",".submit_cart",function(e){
  e.preventDefault();
 var APP_URL=$("#APP_URL").val();
 var store_id=$(this).attr('store_id')
 $('#cart_data').modal('hide');
 $("#overlay").fadeIn(300);
  $.ajax({
        url:APP_URL+'/submit_cart_by_wharehouse',
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
          get_store_data('change')
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
        url:APP_URL+'/wharehouse_qty_change',
        data:{cart_id:cart_id,new_value:new_value},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
        if(new_value==0)
       {
       get_store_data('change')
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
        url:APP_URL+'/wharehouse_qty_change',
        data:{cart_id:cart_id,new_value:new_value},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
        if(new_value==0)
       {
       get_store_data('change')
        }


        },
        error:function(data)
        {

        }
    })

  
   }
   
})

    //
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
        url:APP_URL+'/wharehouse_qty_change',
        data:{cart_id:cart_id,new_value:new_value},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
        if(new_value==0)
       {
       get_store_data('change')
        }


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
        url:APP_URL+'/wharehouse_qty_change',
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
    });
    //
    $(document).on("click","#lblCartCount",function(){
 
   //
 
      
        var APP_URL=$("#APP_URL").val();
        var store_id=$("#store").val()

        $(".submit_cart").attr("store_id",store_id)
       
  $.ajax({
        url:APP_URL+'/get_wharehouse_cart_data',
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
    //add_to_cart
$(document).on("click",".add_to_cart",function(){

 var APP_URL=$("#APP_URL").val();
 var item_id=$(this).attr('item_id')
 var store_id=$(this).attr('store_id')
 var current=$(this)
   $.ajax({
        url:APP_URL+'/wharehouse_add_to_cart',
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



     //disable
   $(document).on("click",".disable",function(){
    var id=$(this).attr('id')
    var button=$(this)
    var r = confirm("Are you sure ?");

     
       if (r === false) {
           return false;
        }
        else
        {
   
     var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/disable_store_product',
        data:{id:id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
         get_store_data('nochange')
           table.ajax.reload(null, false);
         // swal("Done !", 'Successfully Updated', "success");
        // setTimeout(function(){ location.reload(); }, 1000);
        },
        error:function(data)
        {

        }
    })
     }

    })  
     //enable
   $(document).on("click",".enable",function(){
    var id=$(this).attr('id')

     var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/enable_store_product',
        data:{id:id},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
        
          get_store_data('nochange')
           table.ajax.reload(null, false);
         // swal("Done !", 'Successfully Updated', "success");
        // setTimeout(function(){ location.reload(); }, 1000);
        },
        error:function(data)
        {

        }
    })
    }) 

 $(document).ready(function()
 {
   var store=$("#store").val() 
   if(store=='')
{
 
}
else
{

get_store_data('change')

   } 
 })
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
        url: "{{ route('get_store_product') }}",
        data: {store:store},
    },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
         
            {data: 'image', name: 'image'},
            {data: 'name', name: 'name'},
            {data: 'unit', name: 'unit'},
            {data: 'threshold_qty', name: 'threshold_qty'},
            {data: 'available_qty', name: 'available_qty'},
            {data: 'status', name: 'status'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
      
    });
    //

 var store_id=$("#store").val()
var APP_URL=$("#APP_URL").val();
   $.ajax({
        url:APP_URL+'/wharehouse_cart_count',
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
    //
  }
</script>

@endsection