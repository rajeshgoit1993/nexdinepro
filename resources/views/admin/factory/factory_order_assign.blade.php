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
  <div class="flex-item-left"><h5>Assign Order To Factory/Vendor</h5></div>
  <div class="flex-item-right"><a href="{{URL::route('newly_wharehouse_order_accounts')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
</div>


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

<!---->
{!! Form::open(["files"=>true])!!}


<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">


</div>
<div class="modal-body">
<div class="row">
<div class="col-lg-4">	
<strong>Product Name</strong>
</div>
<div class="col-lg-4">	
<strong>Assign To (Vendor/Factory)</strong>
</div>
<div class="col-lg-4">	
<strong>Select Vendor/Factory</strong>
</div>
</div>
<div class="col-lg-12">
	<hr>
</div>
@foreach($orders_items as $orders_item)
<input type="hidden" name="assign[{{$orders_item->id}}][order_item_id]" value="{{$orders_item->id}}">
<div class="row">
<div class="col-lg-4">	
{{CustomHelpers::get_master_table_data('factory_ingredients','id',$orders_item->product_id,'product_name')}}
</div>
<div class="col-lg-4">	

     <div class="form-group">
     	<input type="hidden" name="" class="product_id" value="{{$orders_item->product_id}}">
         <select class="form-control factory_vendor" name="assign[{{$orders_item->id}}][factory_vendor]" required> 
         <option value="">--Select One--</option>
       <!--    <option value="factory">Factory</option> -->
           <option value="vendor">Vendor</option>
     </select>

</div>
</div>
<div class="col-lg-4 factory_vendor_ids">	
  <div class="form-group">
         <select class="form-control factory_vendor_id" name="assign[{{$orders_item->id}}][factory_vendor_id]" required> 
         <option value="">--Select One--</option>
         
     </select>

</div>
</div>
</div>
<div class="col-lg-12">
	<hr>
</div>
@endforeach
</div>
<div class="modal-footer" style="text-align: left;">
{!! Form::submit('Submit',["class"=>"btn btn-success"]) !!}

</div>
</div>


{!! Form::close() !!}








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
	
$(document).on("change",".factory_vendor",function(){
    
    var button=$(this)
	var product_id=$(this).siblings(".product_id").val()
	var factory_vendor=$(this).val()
	if(factory_vendor!='')
	{

	
$("#overlay").fadeIn(300);
   //
        var APP_URL=$("#APP_URL").val();
       

  $.ajax({
        url:APP_URL+'/get_product_vendor',
        data:{product_id:product_id,factory_vendor:factory_vendor},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
        $("#overlay").fadeOut(300); 
         if(data=='<option value="">--Select One--</option>')
            {
           swal("Error !", 'No data found', "error");  
           button.parent().parent().siblings('.factory_vendor_ids').children().children('.factory_vendor_id').html('').html(data)   
            }
            else
            {
          button.parent().parent().siblings('.factory_vendor_ids').children().children('.factory_vendor_id').html('').html(data)
            }

         
        },
        error:function(data)
        {

        }
    })
    //
    }
    else
    {
    	 button.parent().parent().siblings('.factory_vendor_ids').children().children('.factory_vendor_id').html('').html('<option value="">--Select One--</option>')   
    }
})

</script>
@endsection