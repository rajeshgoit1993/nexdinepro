<i class=""></i> 
 <li class="nav-item {{ Request::is('GST-List') || Request::is('Add-GST-List') || Request::is('Brand-List') || Request::is('Add-Brand-List') ||  Request::is('Unit-List') || Request::is('Add-Unit-List') || Request::is('TransportCharge-List') || Request::is('Add-TransportCharge-List') || Request::is('Manage-City') || Request::is('Warehouse-Setting') || Request::is('POS-PaymentMethod') || Request::is('Add-POS-PaymentMethod') || Request::is('Region') || Request::is('Add-Region') ? 'menu-open' :'' }}   @if(Request::segment(1)=='GSTList-Edit' || Request::segment(1)=='Brand-Edit' ||  Request::segment(1)=='Unit-Edit' ||  Request::segment(1)=='POSPaymentMethod-Edit' ||  Request::segment(1)=='Region-Edit' || Request::segment(1)=='TransportCharge-Edit') menu-open @endif">
<a href="#" class="nav-link">
<i class="nav-icon fas fa-tools"></i>
<p>
Setting
<i class="right fas fa-angle-left"></i>
</p>
</a>
<ul class="nav nav-treeview">

 <!-- <li class="nav-item">  
  <a href="{{URL::route('brand_list')}}" class="nav-link {{ Request::is('Brand-List') || Request::is('Add-Brand-List')

? 'active' :'' }} @if(Request::segment(1)=='Brand-Edit') active @endif">             
  <i class="far fa-circle nav-icon"></i> 
  <p>Brands</p>               
 </a>                
 </li> -->


<li class="nav-item">  
  <a href="{{URL::route('gst_list')}}" class="nav-link {{ Request::is('GST-List') || Request::is('Add-GST-List')

? 'active' :'' }} @if(Request::segment(1)=='GSTList-Edit') active @endif">             
  <i class="far fa-circle nav-icon"></i> 
  <p>GST</p>               
 </a>                
 </li>

 <li class="nav-item">  
  <a href="{{URL::route('unit_list')}}" class="nav-link {{ Request::is('Unit-List') || Request::is('Add-Unit-List')

? 'active' :'' }} @if(Request::segment(1)=='Unit-Edit') active @endif">             
  <i class="far fa-circle nav-icon"></i> 
  <p>Unit</p>               
 </a>                
 </li>
 <li class="nav-item">  
  <a href="{{URL::route('pos_payment_menthod')}}" class="nav-link {{ Request::is('POS-PaymentMethod') || Request::is('Add-POS-PaymentMethod')

? 'active' :'' }} @if(Request::segment(1)=='POSPaymentMethod-Edit') active @endif">             
  <i class="far fa-circle nav-icon"></i> 
  <p>POS Payment Method</p>               
 </a>                
 </li>
 <li class="nav-item">  
  <a href="{{URL::route('region')}}" class="nav-link {{ Request::is('Region') || Request::is('Add-Region')

? 'active' :'' }} @if(Request::segment(1)=='Region-Edit') active @endif">             
  <i class="far fa-circle nav-icon"></i> 
  <p>Region</p>               
 </a>                
 </li>
<!--  <li class="nav-item">  
  <a href="{{URL::route('transport_list')}}" class="nav-link {{ Request::is('TransportCharge-List') || Request::is('Add-TransportCharge-List')

? 'active' :'' }} @if(Request::segment(1)=='TransportCharge-Edit') active @endif">             
  <i class="far fa-circle nav-icon"></i> 
  <p>Transport Charge</p>               
 </a>                
 </li> -->
 
  <li class="nav-item">  
  <a href="{{URL::route('add_city')}}" class="nav-link {{ Request::is('Manage-City') 

? 'active' :'' }}">             
  <i class="far fa-circle nav-icon"></i> 
  <p>Manage City</p>               
 </a>                
 </li>
 
 <!--  <li class="nav-item">  
  <a href="{{URL::route('warehouse_setting')}}" class="nav-link {{ Request::is('Warehouse-Setting') 

? 'active' :'' }}">             
  <i class="far fa-circle nav-icon"></i> 
  <p>Warehouse Setting</p>               
 </a>                
 </li> -->

</ul>
</li>