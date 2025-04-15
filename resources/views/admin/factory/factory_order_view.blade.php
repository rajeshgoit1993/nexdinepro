
<table class="table table-bordered">
    <tr>
        <td rowspan="2">S.No.</td>
        <td  rowspan="2">Order ID</td>
        <td colspan="5">Order Details</td>
    
    </tr>
     <tr>
       
        <td width="20%">Assign To</td>
        <td width="20%">Product Details</td>
        <td width="20%">Order QTY</td>
        <td width="20%">Confirm QTY</td>
        <td width="20%">Est Rate</td>
    </tr>
    <?php 
     $a=1;
    ?>
    @foreach($data as $row=>$col)

      <tr>
        <td>{{$a++}}</td>   
        <td>{{$id}}</td>
        <td colspan="5" style="padding:0px !important">
            <table class="table">
         @foreach($col as $datas)  
          <?php  
$id=$datas->factory_order_id;
$store=$datas->factory_vendor_id;
$factory_vendor_type=$datas->assign_type;
         ?>
          <tr>
              <td width="20%">
                  @if($datas->assign_type=='factory')
         {{CustomHelpers::get_master_table_data('stores','id',$datas->factory_vendor_id,'name')}}
            @else
         {{CustomHelpers::get_master_table_data('users','id',$datas->factory_vendor_id,'name')}}
            @endif
              </td>
              <td width="20%">
                  Product Name: {{CustomHelpers::get_master_table_data('factory_ingredients','id',$datas->product_id,'product_name')}}  
            <hr style="margin:0px;padding: 0px;">

              </td>
              <td width="20%">{{ $datas->qty }}</td>
              <td width="20%">{{ $datas->confirm_qty }}</td>
              <td width="20%">{{ $datas->est_cost }}</td>
          </tr>
      
         @endforeach  
          <tr>
         <td colspan="5">
        <?php 
    $invoice=DB::table('wharehouse_factory_invoice_by_factory_vendors')->where([['factory_vendor_id','=',(int)$store],['order_id','=',(int)$id],['order_type','=','factory'],['factory_vendor_type','=',$factory_vendor_type]])->first();
  
      ?>
      

             Invoice Attachment @if($invoice!='')
    <a href="{{url('public/uploads/factory_vendor_invoice/'.$invoice->invoice)}}" target="_blank">view</a> 
   
        @endif
         </td>
        </tr>
        </table>
       
        </td> 
        
            
      </tr>

     @endforeach
</table>





























