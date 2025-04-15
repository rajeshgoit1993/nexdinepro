

<!---->
  <div style="padding: 0px 10px;">
<h5>Cart List</h5>
 
<div class="row">
                <div class="col-12 table-responsive">
                <table class="table table-striped">
                <thead>
                <tr>
                    
                      <th>Product</th>
                      
                      <th style="text-align:center;">Qty</th>
                   
                      
                    </tr>
                    </thead>
                    <tbody>
                  
        @foreach($data as $cart)
          
        <tr>
              <td> {{CustomHelpers::get_master_table_data('master_products','id',CustomHelpers::get_master_table_data('store_products','id',$cart->wharehouse_product_id,'product_id'),'product_name')}} </td>      
             
                      <td>
 <div class="number" style="line-height: 1;">
<span class="minus"  cart_id="{{CustomHelpers::custom_encrypt($cart->id)}}">-</span>
  <input type="text" class="count" value="{{$cart->qty}}"/>
  <span class="plus" cart_id="{{CustomHelpers::custom_encrypt($cart->id)}}">+</span>
  </div>
                     

                </td>
                     
                  
                      
                    </tr>
                   
        @endforeach

  
  
    </tbody>
                </table>
                </div>
                </div>



  </div>
<!---->
