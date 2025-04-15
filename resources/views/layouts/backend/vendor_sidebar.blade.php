<li class="nav-item {{ Request::is('Manage-Vendors') || Request::is('Add-Vendor') || Request::is('Edit-Vendor') || Request::is('Manage-Vendor-Products')  || Request::is('Manage-Vendor-Orders') || Request::is('Vendor-Orders-Dispatched') || Request::is('Vendor-Orders-Delivered') || Request::is('New-Vendor-Orders-From-Wharehouse') || Request::is('Ongoing-Vendor-Orders-From-Wharehouse') || Request::is('Dispatched-Vendor-Orders-From-Wharehouse') || Request::is('Delivered-Vendor-Orders-From-Wharehouse') || Request::is('New-Vendor-Orders-From-Factory') || Request::is('Ongoing-Vendor-Orders-From-Factory') || Request::is('Dispatched-Vendor-Orders-From-Factory') || Request::is('Delivered-Vendor-Orders-From-Factory') || Request::is('Edit-Vendor-Account') ? 'menu-open' :'' }}  ">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-industry"></i>
              <p>
                Manage Vendor
                <i class="fas fa-angle-left right"></i>
                    @if(NotificationHelpers::new_factory_order_from_wharehouse('vendor')>0 || NotificationHelpers::ongoing_factory_order_from_wharehouse('vendor')>0 || NotificationHelpers::new_vendor_order_from_factory('vendor')>0 || NotificationHelpers::ongoing_vendor_order_from_factory('vendor')>0)
    <span class="badge badge-info right">
 
   <?php 
      $all_factory=0;
    ?>
    @if(NotificationHelpers::new_factory_order_from_wharehouse('vendor')>0)
    <?php 
      $all_factory=$all_factory+NotificationHelpers::new_factory_order_from_wharehouse('vendor');
    ?>
    @endif
   @if(NotificationHelpers::ongoing_factory_order_from_wharehouse('vendor')>0)
    <?php 
      $all_factory=$all_factory+NotificationHelpers::ongoing_factory_order_from_wharehouse('vendor');
    ?>
    @endif
     @if(NotificationHelpers::new_vendor_order_from_factory('vendor')>0)
    <?php 
      $all_factory=$all_factory+NotificationHelpers::new_vendor_order_from_factory('vendor');
    ?>
    @endif
  @if(NotificationHelpers::ongoing_vendor_order_from_factory('vendor')>0)
    <?php 
      $all_factory=$all_factory+NotificationHelpers::ongoing_vendor_order_from_factory('vendor');
    ?>
    @endif

    {{$all_factory}}
  </span>
  @endif

              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="{{URL::route('manage_vendor')}}" class="nav-link {{ Request::is('Manage-Vendors') || Request::is('Add-Vendor') || Request::is('Edit-Vendor') || Request::is('Edit-Vendor-Account') ? 'active' :'' }}
                ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vendor List</p>
                </a>
              </li>


              <li class="nav-item  {{ Request::is('Manage-Vendor-Products')  ? 'active' :'' }}">
                <a href="{{URL::route('manage_vendor_product')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vendor Wise Product</p>
                </a>
              </li>


              


              <li class="nav-item {{  Request::is('Manage-Vendor-Orders') || Request::is('Vendor-Orders-Dispatched') || Request::is('Vendor-Orders-Delivered') ? 'menu-open' :'' }}">
                <a href="#" class="nav-link {{  Request::is('Manage-Vendor-Orders') || Request::is('Vendor-Orders-Dispatched') || Request::is('Vendor-Orders-Delivered') ? 'active' :'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                   Franchise Order
                    <i class="fas fa-angle-left right"></i>  @if(NotificationHelpers::get_vendor_new_order_notification()>0)
    <span class="badge badge-info right">{{NotificationHelpers::get_vendor_new_order_notification()}}</span>
  @endif
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item {{ Request::is('Manage-Vendor-Orders')  ? 'active' :'' }}">
                    <a href="{{URL::route('manage_vendor_orders')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>New Order</p>
                       @if(NotificationHelpers::get_vendor_new_order_notification()>0)
    <span class="badge badge-info right">{{NotificationHelpers::get_vendor_new_order_notification()}}</span>
  @endif

                    </a>
                  </li>
                
                    <li class="nav-item {{ Request::is('Vendor-Orders-Dispatched')  ? 'active' :'' }}">
                    <a href="{{URL::route('manage_vendor_dispatched')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Dispatched</p>
                      

                    </a>
                  </li>
                

                  <li class="nav-item {{ Request::is('Vendor-Orders-Delivered')  ? 'active' :'' }}">
                    <a href="{{URL::route('manage_vendor_delivered')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Delivered</p>
                     

                    </a>
                  </li>
                
                
                </ul>
              </li>


      
    
             

 <li class="nav-item {{  Request::is('New-Vendor-Orders-From-Wharehouse') || Request::is('Ongoing-Vendor-Orders-From-Wharehouse') || Request::is('Dispatched-Vendor-Orders-From-Wharehouse') || Request::is('Delivered-Vendor-Orders-From-Wharehouse') ? 'menu-open' :'' }}">
                <a href="#" class="nav-link {{  Request::is('New-Vendor-Orders-From-Wharehouse') || Request::is('Ongoing-Vendor-Orders-From-Wharehouse') || Request::is('Dispatched-Vendor-Orders-From-Wharehouse') || Request::is('Delivered-Vendor-Orders-From-Wharehouse')  ? 'active' :'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                 Wharehouse Orders
                    <i class="fas fa-angle-left right"></i> 
             @if(NotificationHelpers::new_factory_order_from_wharehouse('vendor')>0 || NotificationHelpers::ongoing_factory_order_from_wharehouse('vendor'))
    <span class="badge badge-info right">
 
   <?php 
      $wharehouse_to_factory=0;
    ?>
    @if(NotificationHelpers::new_factory_order_from_wharehouse('vendor')>0)
    <?php 
      $wharehouse_to_factory=$wharehouse_to_factory+NotificationHelpers::new_factory_order_from_wharehouse('vendor');
    ?>
    @endif
  @if(NotificationHelpers::ongoing_factory_order_from_wharehouse('vendor')>0)
    <?php 
      $wharehouse_to_factory=$wharehouse_to_factory+NotificationHelpers::ongoing_factory_order_from_wharehouse('vendor');
    ?>
    @endif
    {{$wharehouse_to_factory}}
  </span>
  @endif
                  </p>
                </a>
                <ul class="nav nav-treeview">
                 
                
                  <li class="nav-item {{ Request::is('New-Vendor-Orders-From-Wharehouse')  ? 'active' :'' }}">
                    <a href="{{URL::route('new_vendor_order_from_wharehouse')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>New Orders @if(NotificationHelpers::new_factory_order_from_wharehouse('vendor')>0)
    <span class="badge badge-info right">{{NotificationHelpers::new_factory_order_from_wharehouse('vendor')}}</span>
  @endif</p>
                    </a>
                  </li>
                 <li class="nav-item {{ Request::is('Ongoing-Vendor-Orders-From-Wharehouse')  ? 'active' :'' }}">
                    <a href="{{URL::route('ongoing_vendor_order_from_wharehouse')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ongoing Orders  @if(NotificationHelpers::ongoing_factory_order_from_wharehouse('vendor')>0)
    <span class="badge badge-info right">{{NotificationHelpers::ongoing_factory_order_from_wharehouse('vendor')}}</span>
  @endif</p>
                    </a>
                  </li>
                  <li class="nav-item {{ Request::is('Dispatched-Vendor-Orders-From-Wharehouse')  ? 'active' :'' }}">
                    <a href="{{URL::route('dispatched_vendor_order_from_wharehouse')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Dispatched Orders</p>
                    </a>
                  </li>
                   <li class="nav-item {{ Request::is('Delivered-Vendor-Orders-From-Wharehouse')  ? 'active' :'' }}">
                    <a href="{{URL::route('delivered_vendor_order_from_wharehouse')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Delivered Orders</p>
                    </a>
                  </li>

                </ul>
              </li>
             <!---->
          <li class="nav-item {{  Request::is('New-Vendor-Orders-From-Factory') || Request::is('Ongoing-Vendor-Orders-From-Factory') || Request::is('Dispatched-Vendor-Orders-From-Factory') || Request::is('Delivered-Vendor-Orders-From-Factory') ? 'menu-open' :'' }}">
                <a href="#" class="nav-link {{  Request::is('New-Vendor-Orders-From-Factory') || Request::is('Ongoing-Vendor-Orders-From-Factory') || Request::is('Dispatched-Vendor-Orders-From-Factory') || Request::is('Delivered-Vendor-Orders-From-Factory')  ? 'active' :'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                 Factory Orders
                    <i class="fas fa-angle-left right"></i> 
             @if(NotificationHelpers::new_vendor_order_from_factory('vendor')>0 || NotificationHelpers::ongoing_vendor_order_from_factory('vendor'))
    <span class="badge badge-info right">
 
   <?php 
      $factory_to_vendor=0;
    ?>
    @if(NotificationHelpers::new_vendor_order_from_factory('vendor')>0)
    <?php 
      $factory_to_vendor=$factory_to_vendor+NotificationHelpers::new_vendor_order_from_factory('vendor');
    ?>
    @endif
  @if(NotificationHelpers::ongoing_vendor_order_from_factory('vendor')>0)
    <?php 
      $factory_to_vendor=$factory_to_vendor+NotificationHelpers::ongoing_vendor_order_from_factory('vendor');
    ?>
    @endif
    {{$factory_to_vendor}}
  </span>
  @endif
                  </p>
                </a>
                <ul class="nav nav-treeview">
                 
                
                  <li class="nav-item {{ Request::is('New-Vendor-Orders-From-Factory')  ? 'active' :'' }}">
                    <a href="{{URL::route('new_vendor_order_from_factory')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>New Orders @if(NotificationHelpers::new_vendor_order_from_factory('vendor')>0)
    <span class="badge badge-info right">{{NotificationHelpers::new_vendor_order_from_factory('vendor')}}</span>
  @endif</p>
                    </a>
                  </li>
                 <li class="nav-item {{ Request::is('Ongoing-Vendor-Orders-From-Factory')  ? 'active' :'' }}">
                    <a href="{{URL::route('ongoing_vendor_order_from_factory')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ongoing Orders  @if(NotificationHelpers::ongoing_vendor_order_from_factory('vendor')>0)
    <span class="badge badge-info right">{{NotificationHelpers::ongoing_vendor_order_from_factory('vendor')}}</span>
  @endif</p>
                    </a>
                  </li>
                  <li class="nav-item {{ Request::is('Dispatched-Vendor-Orders-From-Factory')  ? 'active' :'' }}">
                    <a href="{{URL::route('dispatched_vendor_order_from_factory')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Dispatched Orders</p>
                    </a>
                  </li>
                   <li class="nav-item {{ Request::is('Delivered-Vendor-Orders-From-Factory')  ? 'active' :'' }}">
                    <a href="{{URL::route('delivered_vendor_order_from_factory')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Delivered Orders</p>
                    </a>
                  </li>

                </ul>
              </li>
             <!---->
            </ul>
          </li>
