

<input type="hidden" name="wharehouse_order_id" value="{{$id}}">
<input type="hidden" name="factory_vendor_id" value="{{$store}}">
@if($status==1)
<input type="hidden" name="serial_number"  value="1">
<table class="table">
	<tr>
		<th>S.No.</th>
		<th>Wharehouse Name</th>
		<th>Order Details</th>
		<th>Order QTY</th>
		<th>Confirm QTY</th>
		<th>Est Rate</th>
	</tr>
	<?php 
     $a=1;
	?>
	@foreach($data as $datas)

	<input type="hidden" name="order_detail_id[]" value="{{$datas->id}}">
	<tr>
		<td>{{$a++}}</td>
		<td>{{ CustomHelpers::get_master_table_data('stores','id',$datas->wharehouse_id,'name') }}
		<hr style="margin:0px;padding: 0px;">
		Order ID: {{$datas->wharehouse_order_id}}
	</td>
		<td>
			Product Name: {{CustomHelpers::get_master_table_data('master_products','id',CustomHelpers::get_master_table_data('store_products','id',$datas->product_id,'product_id'),'product_name')}}
			<hr style="margin:0px;padding: 0px;">

			@if($datas->assign_type=='factory')
         Factory: {{CustomHelpers::get_master_table_data('stores','id',$datas->factory_vendor_id,'name')}}
            @else
          Vendor: {{CustomHelpers::get_master_table_data('users','id',$datas->factory_vendor_id,'name')}}
            @endif

		</td>
		<td> {{ $datas->qty }} </td>
		<td> <input type="text" name="confirm_qty[{{$datas->id}}][]" value="{{$datas->confirm_qty}}" placeholder="Confirm QTY" class="form-control" required> </td>
		<td> <input type="text" value="{{$datas->est_cost}}"  name="est_cost[{{$datas->id}}][]" placeholder="Est Rate" class="form-control" required> </td>
	</tr>
  <?php  

$factory_vendor_type=$datas->assign_type;
    ?>
	 @endforeach
</table>
<div class="col-lg-12">
	<label>Attach Invoice</label>

  <?php  
    $invoice=DB::table('wharehouse_factory_invoice_by_factory_vendors')->where([['factory_vendor_id','=',$store],['order_id','=',(int)$id],['order_type','=','wharehouse'],['factory_vendor_type','=',$factory_vendor_type]])->first();
  
  ?>
  @if($invoice=='')
	<input type="file" name="factory_vendor_invoice" class="form-control" required>
	@else
	<a href="{{url('public/uploads/factory_vendor_invoice/'.$invoice->invoice)}}" target="_blank">view</a> <br>
	<input type="file" name="factory_vendor_invoice" class="form-control">
	@endif
</div>
<div class="col-lg-12" style="text-align:right;">
	 <button type="submit"  class="btn btn-info btn-sm mt-2">Save</button>
</div>
@elseif($status==2)
<input type="hidden" name="serial_number"  value="2">
<table class="table">
	<tr>
		<th>S.No.</th>
		<th>Wharehouse Name</th>
		<th>Order Details</th>
		<th>Order QTY</th>
		<th>Confirm QTY</th>
		<th>Est Rate</th>
	</tr>
	<?php 
     $a=1;
	?>
	@foreach($data as $datas)

	<input type="hidden" name="order_detail_id[]" value="{{$datas->id}}">
	<tr>
		<td>{{$a++}}</td>
		<td>{{ CustomHelpers::get_master_table_data('stores','id',$datas->wharehouse_id,'name') }}
		<hr style="margin:0px;padding: 0px;">
		Order ID: {{$datas->wharehouse_order_id}}
	</td>
		<td>
			Product Name: {{CustomHelpers::get_master_table_data('master_products','id',CustomHelpers::get_master_table_data('store_products','id',$datas->product_id,'product_id'),'product_name')}}
			<hr style="margin:0px;padding: 0px;">

			@if($datas->assign_type=='factory')
         Factory: {{CustomHelpers::get_master_table_data('stores','id',$datas->factory_vendor_id,'name')}}
            @else
          Vendor: {{CustomHelpers::get_master_table_data('users','id',$datas->factory_vendor_id,'name')}}
            @endif

		</td>
		<td> {{ $datas->qty }} </td>
		<td> {{$datas->confirm_qty}}</td>
		<td> {{$datas->est_cost}} </td>
	</tr>
     <?php  

$factory_vendor_type=$datas->assign_type;
    ?>
	 @endforeach
</table>
<div class="col-lg-12">
	<label>Attach Invoice</label>

  <?php  
    $invoice=DB::table('wharehouse_factory_invoice_by_factory_vendors')->where([['factory_vendor_id','=',$store],['order_id','=',(int)$id],['order_type','=','wharehouse'],['factory_vendor_type','=',$factory_vendor_type]])->first();
  
  ?>
  @if($invoice=='')

	@else
	Invoice <a href="{{url('public/uploads/factory_vendor_invoice/'.$invoice->invoice)}}" target="_blank">view</a>
	@endif
</div>

<div class="col-lg-12" style="text-align:right;">
	 <button type="submit"  class="btn btn-info btn-sm mt-2">Accept</button>
</div>
@elseif($status==3)
<input type="hidden" name="serial_number"  value="3">
<table class="table">
	<tr>
		<th>S.No.</th>
		<th>Wharehouse Name</th>
		<th>Order Details</th>
		<th>Order QTY</th>
		<th>Confirm QTY</th>
		<th>Est Rate</th>
		<th>Select</th>
	</tr>
	<?php 
     $a=1;
	?>
	@foreach($data as $datas)


	<tr>
		<td>{{$a++}}</td>
		<td>{{ CustomHelpers::get_master_table_data('stores','id',$datas->wharehouse_id,'name') }}
		<hr style="margin:0px;padding: 0px;">
		Order ID: {{$datas->wharehouse_order_id}}
	</td>
		<td>
			Product Name: {{CustomHelpers::get_master_table_data('master_products','id',CustomHelpers::get_master_table_data('store_products','id',$datas->product_id,'product_id'),'product_name')}}
			<hr style="margin:0px;padding: 0px;">

			@if($datas->assign_type=='factory')
         Factory: {{CustomHelpers::get_master_table_data('stores','id',$datas->factory_vendor_id,'name')}}
            @else
          Vendor: {{CustomHelpers::get_master_table_data('users','id',$datas->factory_vendor_id,'name')}}
            @endif

		</td>
		<td> {{ $datas->qty }} </td>
		<td> {{$datas->confirm_qty}}</td>
		<td> {{$datas->est_cost}} </td>
		<td> <input type="checkbox" name="order_detail_id[]" value="{{$datas->id}}"></td>
	</tr>
 <?php  

$factory_vendor_type=$datas->assign_type;
    ?>
	 @endforeach
</table>
<div class="col-lg-12">
	<label>Attach Invoice</label>

  <?php  
    $invoice=DB::table('wharehouse_factory_invoice_by_factory_vendors')->where([['factory_vendor_id','=',$store],['order_id','=',(int)$id],['order_type','=','wharehouse'],['factory_vendor_type','=',$factory_vendor_type]])->first();
  
  ?>
  @if($invoice=='')

	@else
	Invoice <a href="{{url('public/uploads/factory_vendor_invoice/'.$invoice->invoice)}}" target="_blank">view</a>
	@endif
</div>
     <div class="row">
    <div class="col-md-6">
     <div class="form-group">
          <label for="">Status</label>
         <select class="form-control" name="status" required> 
         
           <option value="4">Dispatch</option>
          
         </select>
      
        </div>
 </div>
 <div class="col-md-6">
     <div class="form-group">
          <label for="">Dispatch Date</label>
          <input type="date" name="dispatch_date" id="dispatch_date" class="form-control" placeholder="Date" value="" required>
       
        </div>
 </div>
 <div class="col-md-12">
     <div class="form-group">
          <label for="">Courier Name</label>
          <textarea name="courier_name" id="courier_name" class="form-control" placeholder="  Courier Name" required></textarea>
     
         
        </div>
 </div>


 
 
  </div>
<div class="col-lg-12" style="text-align:right;">
	 <button type="submit"  class="btn btn-info btn-sm mt-2">Dispatch</button>
</div>

@endif


