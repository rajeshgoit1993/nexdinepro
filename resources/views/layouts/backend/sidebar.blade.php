
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link" style="background:white">
      <img src="{{url('public/uploads/logo/left.png')}}" alt="AdminLTE Logo" class="brand-image  elevation-3" >
      <span class="brand-text font-weight-light">
 
 <?php  

$logo_path=CustomHelpers::logo_path(Sentinel::getUser()->parent_id);

 ?>

    <img src="{{$logo_path}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="float: none;
    border-radius: 2px;
    max-height: 40px;
    width:70%;
   
   
">

    </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('/resources/assets/admin-lte/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"> @if(Sentinel::check())

  
   {{Sentinel::getUser()->name }}

@endif</a>
        </div>
      </div>



      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
@if(Sentinel::getUser()->inRole('superadmin'))


          <li class="nav-item ">
            <a href="{{URL::route('admin_dashboard')}}" class="nav-link {{ Request::is('Dashboard')

? 'active' :'' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
               
              </p>
            </a>
          </li>
           <li class="nav-item ">
     <a href="{{URL::route('key_contacts')}}" class="nav-link {{ Request::is('Manage-contacts')

? 'active' :'' }}">
              <i class="nav-icon fas fa-phone"></i>
              <p>
               Manage Contacts
               
              </p>
            </a>
          </li> 
         <li class="nav-item ">
     <a href="{{URL::route('franchise_exp')}}" class="nav-link {{ Request::is('Franchise-Exp')

? 'active' :'' }}">
              <i class="nav-icon fas fa-money-bill-alt"></i>
              <p>
               Franchise Expenses 
               
              </p>
            </a>
          </li> 


        
 
 @include("layouts.backend.franchise_registration_sidebar")


    <li class="nav-item {{ Request::is('Role') || Request::is('Manage-Multi-Dept-Employee') || Request::is('Add-Role') || Request::is('Add-Manage-Multi-Dept-Employee') || Request::is('Edit-User')  || Request::is('Edit-Account') || Request::is('User-Department') || Request::is('User-Designation')  ? 'menu-open' :'' }}">
<a href="#" class="nav-link">
<i class="nav-icon fas fa-user"></i>           
<p> Manage Users <i class="fas fa-angle-left right"></i></p>             
 </a>             
<ul class="nav nav-treeview">               
 <li class="nav-item">               
<a href="{{URL::route('role')}}" class="nav-link {{ Request::is('Role') ? 'active' :'' }}">              
<i class="far fa-circle nav-icon"></i>            
 <p>Roles</p>            
</a>              
</li>              
<li class="nav-item"><a href="{{URL::route('manage_dept_employee')}}" class="nav-link {{ Request::is('Manage-Multi-Dept-Employee') || Request::is('Add-Manage-Multi-Dept-Employee') || Request::is('Edit-User') || Request::is('Edit-Account') || Request::is('Add-Role') ? 'active' :'' }}"><i class="far fa-circle nav-icon"></i>  
 <p>Users</p>             
</a>              
</li>

 <li class="nav-item">               
<a href="{{URL::route('user_department')}}" class="nav-link {{ Request::is('User-Department') ? 'active' :'' }}">              
<i class="far fa-circle nav-icon"></i>            
 <p>Department</p>            
</a>              
</li>

 <li class="nav-item">               
<a href="{{URL::route('user_designation')}}" class="nav-link {{ Request::is('User-Designation') ? 'active' :'' }}">              
<i class="far fa-circle nav-icon"></i>            
 <p>Designation</p>            
</a>              
</li>

<!-- <li class="nav-item"><a href="" class="nav-link "><i class="far fa-circle nav-icon"></i>  
 <p>Stores</p>             
</a>              
</li> --> 
<!-- 
<li class="nav-item"><a href="{{URL::route('manage_vendor')}}" class="nav-link {{ Request::is('Manage-Vendors') || Request::is('Add-Vendor') || Request::is('Edit-Vendor') ? 'active' :'' }}"><i class="far fa-circle nav-icon"></i>  
 <p>Vendors</p>             
</a>              
</li>  -->

              
</ul>              
</li> 
  
<!--HRMS-->
<!--   <li class="nav-item {{ Request::is('Weekoff') || Request::is('Holiday') || Request::is('Attendence') || Request::is('Shift') || Request::is('Office')  ? 'menu-open' :'' }}">
<a href="#" class="nav-link">
<i class="nav-icon fas fa-solid fa-users"></i>           
<p> HRMS <i class="fas fa-angle-left right"></i></p>             
 </a>             
<ul class="nav nav-treeview">               
 <li class="nav-item">               
<a href="{{URL::route('attendence')}}" class="nav-link {{ Request::is('Attendence') ? 'active' :'' }}">              
<i class="far fa-circle nav-icon"></i>            
 <p>Emp. Attendence</p>            
</a>              
</li>              
<li class="nav-item"><a href="{{URL::route('holiday')}}" class="nav-link {{ Request::is('Holiday') ? 'active' :'' }}"><i class="far fa-circle nav-icon"></i>  
 <p>Holiday</p>             
</a>              
</li>

 <li class="nav-item">               
<a href="{{URL::route('weekoff')}}" class="nav-link {{ Request::is('Weekoff') ? 'active' :'' }}">              
<i class="far fa-circle nav-icon"></i>            
 <p>Week Off</p>            
</a>              
</li>

<li class="nav-item">               
<a href="{{URL::route('shift')}}" class="nav-link {{ Request::is('Shift') ? 'active' :'' }}">              
<i class="far fa-circle nav-icon"></i>            
 <p>Shift</p>            
</a>              
</li>

<li class="nav-item">               
<a href="{{URL::route('office')}}" class="nav-link {{ Request::is('Office') ? 'active' :'' }}">              
<i class="far fa-circle nav-icon"></i>            
 <p>Office Address</p>            
</a>              
</li>


              
</ul>              
</li> --> 
  

<!--Manage Vendor Start-->

<!--Manage Vendor End-->

        




@include("layouts.backend.pos")

<!----> 
  @include("layouts.backend.products_sidebar")           
  @include("layouts.backend.setting_sidebar")              




<!--Fanchise Work start-->
   @elseif(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise') || Sentinel::getUser()->inRole('waiter') || Sentinel::getUser()->inRole('kitchen') || Sentinel::getUser()->inRole('cashier'))               
   <li class="nav-item ">
            <a href="{{URL::route('admin_dashboard')}}" class="nav-link {{ Request::is('Dashboard')

? 'active' :'' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
               
              </p>
            </a>
          </li>  
  
 
   <li class="nav-item ">
            <a href="{{URL::route('fanchise_account')}}" class="nav-link {{ Request::is('Fanchise-Account') || Request::is('Kyc')

? 'active' :'' }}">
              <i class="nav-icon fas fa-user"></i>
              <p>
                My Account
               
              </p>
            </a>
          </li>            
 


@if(Sentinel::getUser()->status>=1)
  @include("layouts.backend.products_sidebar")      

<!-- <li class="nav-item ">
            <a href="{{URL::route('franchise_stock')}}" class="nav-link {{ Request::is('Franchise-Stock') 

? 'active' :'' }}">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Stock
               
              </p>
            </a>
          </li> -->

<li class="nav-item ">
            <a href="{{URL::route('purchase')}}" class="nav-link {{ Request::is('Purchase') || Request::is('Add-Purchase') 

? 'active' :'' }}  @if(Request::segment(1)=='Edit-Daily-Purchase') active @endif">
              <i class="nav-icon fas fa-truck"></i>
              <p>
               Daily Purchase 
               
              </p>
            </a>
          </li>



<li class="nav-item ">
            <a href="{{URL::route('waste')}}" class="nav-link {{ Request::is('Waste') || Request::is('Add-Food-Menu-Waste') || Request::is('Add-Ingredients-Waste') 

? 'active' :'' }} @if(Request::segment(1)=='Edit-Food-Menu-Waste' || Request::segment(1)=='Edit-Ingredient-Waste') active @endif">
              <i class="nav-icon fas fa-trash"></i>
              <p>
               Waste
               
              </p>
            </a>
          </li>

 <li class="nav-item ">
            <a href="{{URL::route('supplier')}}" class="nav-link {{ Request::is('Supplier') 

? 'active' :'' }}">
              <i class="nav-icon fas fa-industry"></i>
              <p>
               Supplier
               
              </p>
            </a>
          </li>  

<!---->


<li class="nav-item {{ Request::is('Supply-Order-Payment') || Request::is('Franchise-Credit-History')  ? 'menu-open' :'' }}">
<a href="#" class="nav-link">
<i class="nav-icon fas fa-rupee-sign"></i>
<p>
Payment History
<i class="fas fa-angle-left right"></i>
</p>
</a>

<ul class="nav nav-treeview">
<!-- <li class="nav-item">
<a href="{{URL::route('supply_order_payment')}}" class="nav-link  {{ Request::is('Supply-Order-Payment')  ? 'active' :'' }}">
<i class="far fa-circle nav-icon"></i>
<p>Order Payment</p>
</a>
</li> -->
<li class="nav-item">
<a href="{{URL::route('franchise_credit_history')}}" class="nav-link {{ Request::is('Franchise-Credit-History') ? 'active' :'' }}">
<i class="far fa-circle nav-icon"></i>
<p>Credit History</p>


</a>
</li>


</ul>
</li>
<!---->
 <li class="nav-item {{  Request::is('Manage-Staff') || Request::is('Add-Staff') || Request::is('Edit-Staff')   ? 'menu-open' :'' }}">
<a href="#" class="nav-link">
<i class="nav-icon fas fa-user"></i>           
<p> Manage Staff <i class="fas fa-angle-left right"></i></p>             
 </a>             
<ul class="nav nav-treeview">               
              
<li class="nav-item"><a href="{{URL::route('manage_staff')}}" class="nav-link {{ Request::is('Manage-Staff') || Request::is('Add-Staff') || Request::is('Edit-Staff')  ? 'active' :'' }}"><i class="far fa-circle nav-icon"></i>  
 <p>Staff</p>             
</a>              
</li>                


              
</ul>              
</li> 
<!---->
@include("layouts.backend.pos")
@elseif(Sentinel::getUser()->inRole('cashier'))
 <li class="nav-item"><a href="{{URL::route('pos')}}" class="nav-link " target="_blank"><i class="far fa-circle nav-icon"></i>
<p>POS</p>                  
 </a>                 
 </li>
@elseif(Sentinel::getUser()->inRole('kitchen'))
 <li class="nav-item"><a href="{{URL::route('kitchen')}}" class="nav-link " target="_blank"><i class="far fa-circle nav-icon"></i>
<p>Kitchen</p>                  
 </a>                 
 </li>
 @elseif(Sentinel::getUser()->inRole('waiter'))
<li class="nav-item"><a href="{{URL::route('waiter')}}" class="nav-link " target="_blank"><i class="far fa-circle nav-icon"></i>
<p>Waiter</p>                  
 </a>                 
 </li>
@endif
<!--Fanchise Work end-->
 @elseif(Sentinel::getUser()->inRole('vendor')) 

<li class="nav-item ">
            <a href="{{URL::route('admin_dashboard')}}" class="nav-link {{ Request::is('Dashboard') || Request::is('view-actions')

? 'active' :'' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
               
              </p>
            </a>
          </li>
@if(Sentinel::getUser()->status>=2)
<li class="nav-item ">
            <a href="{{URL::route('my_account')}}" class="nav-link {{ Request::is('My-Account') || Request::is('Kyc')

? 'active' :'' }}">
              <i class="nav-icon fas fa-user"></i>
              <p>
                My Account
               
              </p>
            </a>
          </li>  
@endif

@include("layouts.backend.vendor_sidebar")
<!--other use work start-->
@else
  <li class="nav-item ">
            <a href="{{URL::route('admin_dashboard')}}" class="nav-link {{ Request::is('Dashboard') 

? 'active' :'' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
               
              </p>
            </a>
          </li>

          @include("layouts.backend.dailytimesheet_sidebar")

          
<?php 
$id=Sentinel::getUser()->id;
$user_fanchise_menu=CustomHelpers::get_page_access_data($id,'fanchise_menu');
$new_work_menu=CustomHelpers::get_page_access_data_without_new_registration($id,'new_work_menu');
$area_manager_work=CustomHelpers::get_page_access_data($id,'area_manager_work');

 ?>
 @if($area_manager_work==1)
@include("layouts.backend.daily_purchase_sidebar")

 @endif



  @if($new_work_menu==1)

 <li class="nav-item ">
            <a href="{{URL::route('new_work_list')}}" class="nav-link {{ Request::is('New-Worklist') || Request::is('view-actions')

? 'active' :'' }}">
              <i class="nav-icon fa fa-list-alt"></i>
              <p>
                New WorkList
               
              </p>
            </a>
          </li>
 
@endif
@if($user_fanchise_menu==1)

@include("layouts.backend.franchise_registration_sidebar")
 
@endif
@if(CustomHelpers::get_page_access_data($id,'billing')==1)

@include("layouts.backend.pos")
 
@endif
@if(CustomHelpers::get_page_access_data($id,'master_product')==1)

  @include("layouts.backend.products_sidebar")  
 
@endif
@if(CustomHelpers::get_page_access_data($id,'setting')==1)

  @include("layouts.backend.setting_sidebar")  
 
@endif
  <li class="nav-item ">
            <a href="{{URL::route('user_account')}}" class="nav-link {{ Request::is('User-Account') || Request::is('view-actions')

? 'active' :'' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                My Account
               
              </p>
            </a>
          </li>
   
<!--other use work end-->
<?php 
$user_id=Sentinel::getUser()->id;
$wharehouse_check=DB::table('store_assign_users')->where([['user_id','=',$user_id],['type','=',1]])->get();
$factory_check=DB::table('store_assign_users')->where([['user_id','=',$user_id],['type','=',2]])->get();

?>
@if(count($wharehouse_check)>0)
 @include("layouts.backend.wharehouse_sidebar")

@endif
@if(count($factory_check)>0)
 @include("layouts.backend.factory_sidebar")
@endif
   @endif         
      
@if(Sentinel::getUser()->roles[0]->id==16) 

@include("layouts.backend.accounts_sidebar")

 <li class="nav-item ">
     <a href="{{URL::route('franchise_exp')}}" class="nav-link {{ Request::is('Franchise-Exp')

? 'active' :'' }}">
              <i class="nav-icon fas fa-money-bill-alt"></i>
              <p>
               Franchise Expenses 
               
              </p>
            </a>
          </li>
          
 @endif  

          <li class="nav-header">LABELS</li>
           <li class="nav-item">
            <a href="{{URL::route('change_password')}}" class="nav-link {{ Request::is('Change-Password') ? 'active' :'' }}">
              <i class="nav-icon fas fa-key"></i>
              <p>
                Change Password
             
              </p>
            </a>
      
          </li>

          <li class="nav-item">
             <form action="{{URL::to('/logout')}}" id="logout-form" method="POST">
                                        {{ csrf_field() }}

                  <input type="hidden" name="latitude" id="latitude" >
            <input type="hidden" name="longitude" id="longitude">
            <input type="hidden" name="accuracy" id="accuracy">
                                   
                </form>                         
            <a href="#"   class="nav-link logout">
              <i class="nav-icon far fa-circle text-danger"></i>
              <p class="text">Sign out</p>
            </a>
          </li>
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>