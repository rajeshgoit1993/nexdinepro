
<li class="nav-item {{ Request::is('Food-Menu-Category') || Request::is('Food-Menu') || Request::is('Franchise-Tables') || Request::is('Payment-Method') || Request::is('Franchise-Food-Menu') || Request::is('ConsumptionReport') || Request::is('foodMenuSales') || Request::is('Outlet-Menu-Price') || Request::is('DSR-MTD') || Request::is('DSR-RSC-MTD') || Request::is('POS-Reports') || Request::is('Hourly-Reports')

? 'menu-open' :'' }}">
<a href="#" class="nav-link">
<i class="nav-icon fas fa-table"></i>           
<p> Billing / Sales (POS) <i class="fas fa-angle-left right"></i></p>             
 </a>             
<ul class="nav nav-treeview">    

@if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1)           
 <li class="nav-item">               
<a href="{{URL::route('food_menues_category')}}" class="nav-link {{ Request::is('Food-Menu-Category') 

? 'active' :'' }}">              
<i class="far fa-circle nav-icon"></i>            
 <p>Food Menu Category</p>            
</a>              
</li> 
 <li class="nav-item">               
<a href="{{URL::route('food_menues')}}" class="nav-link {{ Request::is('Food-Menu') 

? 'active' :'' }}">              
<i class="far fa-circle nav-icon"></i>            
 <p>Food Menu</p>            
</a>              
</li>
 <li class="nav-item">               
<a href="{{URL::route('outlet_menu_price')}}" class="nav-link {{ Request::is('Outlet-Menu-Price') 

? 'active' :'' }}">              
<i class="far fa-circle nav-icon"></i>            
 <p>Outlet Menu Price</p>            
</a>              
</li>
<!--  <li class="nav-item">               
<a href="#" class="nav-link">              
<i class="far fa-circle nav-icon"></i>            
 <p>Normal Bill</p>            
</a>              
</li>
<li class="nav-item">  
  <a href="#" class="nav-link">             
  <i class="far fa-circle nav-icon"></i> <p>Split Bills</p>               
 </a>                
 </li>               
<li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i>  
 <p>Customized bills</p>             
</a>              
</li>                
<li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i>
<p>Cancelled bills</p>                  
 </a>                 
 </li>   -->
 @elseif(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise'))    

 <li class="nav-item">               
<a href="{{URL::route('food_menues_category')}}" class="nav-link {{ Request::is('Food-Menu-Category') 

? 'active' :'' }}">              
<i class="far fa-circle nav-icon"></i>            
 <p>Food Menu Category</p>            
</a>              
</li> 
 <li class="nav-item">               
<a href="{{URL::route('food_menues')}}" class="nav-link {{ Request::is('Food-Menu') 

? 'active' :'' }}">              
<i class="far fa-circle nav-icon"></i>            
 <p>Food Menu</p>            
</a>              
</li>


<li class="nav-item"><a href="{{URL::route('franchise_tables')}}" class="nav-link {{ Request::is('Franchise-Tables') 

? 'active' :'' }}"><i class="far fa-circle nav-icon"></i>
<p>Tables Setting</p>                  
 </a>                 
 </li> 


 <!--  <li class="nav-item"><a href="{{URL::route('franchise_food_menu')}}" class="nav-link {{ Request::is('Franchise-Food-Menu') 

? 'active' :'' }}"><i class="far fa-circle nav-icon"></i>
<p>Food Menu</p>                  
 </a>                 
 </li> -->

 <li class="nav-item"><a href="{{URL::route('pos')}}" class="nav-link " target="_blank"><i class="far fa-circle nav-icon"></i>
<p>POS</p>                  
 </a>                 
 </li>
  <li class="nav-item"><a href="{{URL::route('kitchen')}}" class="nav-link " target="_blank"><i class="far fa-circle nav-icon"></i>
<p>Kitchen</p>                  
 </a>                 
 </li>
   <li class="nav-item"><a href="{{URL::route('waiter')}}" class="nav-link " target="_blank"><i class="far fa-circle nav-icon"></i>
<p>Waiter</p>                  
 </a>                 
 </li>



                                                    
@endif
 <li class="nav-item"><a href="{{URL::route('foodmenusales')}}" class="nav-link {{ Request::is('foodMenuSales') 

? 'active' :'' }}"><i class="far fa-circle nav-icon"></i>
<p>Food Sale Report</p>                  
 </a>                 
 </li>
  <li class="nav-item"><a href="{{URL::route('pos_reports')}}" class="nav-link {{ Request::is('POS-Reports') 

? 'active' :'' }}"><i class="far fa-circle nav-icon"></i>
<p>Reports</p>                  
 </a>                 
 </li>

<li class="nav-item"><a href="{{URL::route('hourly_reports')}}" class="nav-link {{ Request::is('Hourly-Reports') 

? 'active' :'' }}"><i class="far fa-circle nav-icon"></i>
<p>Hourly Reports</p>                  
 </a>                 
 </li>


  <li class="nav-item"><a href="{{URL::route('consumptionreport')}}" class="nav-link {{ Request::is('ConsumptionReport') 

? 'active' :'' }}"><i class="far fa-circle nav-icon"></i>
<p>Consumption Report</p>                  
 </a>                 
 </li>

</ul>              
</li> 
