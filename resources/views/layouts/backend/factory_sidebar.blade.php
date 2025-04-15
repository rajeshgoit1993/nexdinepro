 <li class="nav-item {{ Request::is('Manage-Factory') || Request::is('Add-Factory') || Request::is('Edit-Factory') || Request::is('Manage-Factory-Products') || Request::is('Factory-Ingredients') || Request::is('Manage-Factory-Orders') || Request::is('Factory-Orders-Dispatched') || Request::is('Factory-Orders-Delivered') || Request::is('New-Factory-Orders-From-Wharehouse') || Request::is('Ongoing-Factory-Orders-From-Wharehouse') || Request::is('Dispatched-Factory-Orders-From-Wharehouse') || Request::is('Delivered-Factory-Orders-From-Wharehouse') || Request::is('Factory-Newly-Submitted-Order') || Request::is('Factory-Ongoing-Order') ||   Request::is('Factory-Delivered-Order')? 'menu-open' :'' }}  ">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-industry"></i>
              <p>
                Manage Factory
                <i class="fas fa-angle-left right"></i>
                    @if(NotificationHelpers::new_factory_order_from_wharehouse('factory')>0 || NotificationHelpers::ongoing_factory_order_from_wharehouse('factory')>0)
    <span class="badge badge-info right">
 
   <?php 
      $all_factory=0;
    ?>
    @if(NotificationHelpers::new_factory_order_from_wharehouse('factory')>0)
    <?php 
      $all_factory=$all_factory+NotificationHelpers::new_factory_order_from_wharehouse('factory');
    ?>
    @endif
   @if(NotificationHelpers::ongoing_factory_order_from_wharehouse('factory')>0)
    <?php 
      $all_factory=$all_factory+NotificationHelpers::ongoing_factory_order_from_wharehouse('factory');
    ?>
    @endif
    {{$all_factory}}
  </span>
  @endif

              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="{{URL::route('manage_factory')}}" class="nav-link {{ Request::is('Manage-Factory') || Request::is('Add-Factory') || Request::is('Edit-Factory') ? 'active' :'' }}
                ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Factory List</p>
                </a>
              </li>


              <li class="nav-item  {{ Request::is('Manage-Factory-Products')  ? 'active' :'' }}">
                <a href="{{URL::route('manage_factory_product')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Factory Wise Product</p>
                </a>
              </li>


              


              <li class="nav-item {{  Request::is('Manage-Factory-Orders') || Request::is('Factory-Orders-Dispatched') || Request::is('Factory-Orders-Delivered') ? 'menu-open' :'' }}">
                <a href="#" class="nav-link {{  Request::is('Manage-Factory-Orders') || Request::is('Factory-Orders-Dispatched') || Request::is('Factory-Orders-Delivered') ? 'active' :'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                   Franchise Order
                    <i class="fas fa-angle-left right"></i>  @if(NotificationHelpers::get_factory_new_order_notification()>0)
    <span class="badge badge-info right">{{NotificationHelpers::get_factory_new_order_notification()}}</span>
  @endif
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item {{ Request::is('Manage-Factory-Orders')  ? 'active' :'' }}">
                    <a href="{{URL::route('manage_factory_orders')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>New Order</p>
                       @if(NotificationHelpers::get_factory_new_order_notification()>0)
    <span class="badge badge-info right">{{NotificationHelpers::get_factory_new_order_notification()}}</span>
  @endif

                    </a>
                  </li>
                
                    <li class="nav-item {{ Request::is('Factory-Orders-Dispatched')  ? 'active' :'' }}">
                    <a href="{{URL::route('manage_factory_dispatched')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Dispatched</p>
                      

                    </a>
                  </li>
                

                  <li class="nav-item {{ Request::is('Factory-Orders-Delivered')  ? 'active' :'' }}">
                    <a href="{{URL::route('manage_factory_delivered')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Delivered</p>
                     

                    </a>
                  </li>
                
                
                </ul>
              </li>


       <li class="nav-item {{  Request::is('New-Factory-Orders-From-Wharehouse') || Request::is('Ongoing-Factory-Orders-From-Wharehouse') || Request::is('Dispatched-Factory-Orders-From-Wharehouse') || Request::is('Delivered-Factory-Orders-From-Wharehouse') ? 'menu-open' :'' }}">
                <a href="#" class="nav-link {{  Request::is('New-Factory-Orders-From-Wharehouse') || Request::is('Ongoing-Factory-Orders-From-Wharehouse') || Request::is('Dispatched-Factory-Orders-From-Wharehouse') || Request::is('Delivered-Factory-Orders-From-Wharehouse')  ? 'active' :'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                 Wharehouse Orders
                    <i class="fas fa-angle-left right"></i> 
             @if(NotificationHelpers::new_factory_order_from_wharehouse('factory')>0 || NotificationHelpers::ongoing_factory_order_from_wharehouse('factory'))
    <span class="badge badge-info right">
 
   <?php 
      $wharehouse_to_factory=0;
    ?>
    @if(NotificationHelpers::new_factory_order_from_wharehouse('factory')>0)
    <?php 
      $wharehouse_to_factory=$wharehouse_to_factory+NotificationHelpers::new_factory_order_from_wharehouse('factory');
    ?>
    @endif
  @if(NotificationHelpers::ongoing_factory_order_from_wharehouse('factory')>0)
    <?php 
      $wharehouse_to_factory=$wharehouse_to_factory+NotificationHelpers::ongoing_factory_order_from_wharehouse('factory');
    ?>
    @endif
    {{$wharehouse_to_factory}}
  </span>
  @endif
                  </p>
                </a>
                <ul class="nav nav-treeview">
                 
                
                  <li class="nav-item {{ Request::is('New-Factory-Orders-From-Wharehouse')  ? 'active' :'' }}">
                    <a href="{{URL::route('new_factory_order_from_wharehouse')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>New Orders @if(NotificationHelpers::new_factory_order_from_wharehouse('factory')>0)
    <span class="badge badge-info right">{{NotificationHelpers::new_factory_order_from_wharehouse('factory')}}</span>
  @endif</p>
                    </a>
                  </li>
                 <li class="nav-item {{ Request::is('Ongoing-Factory-Orders-From-Wharehouse')  ? 'active' :'' }}">
                    <a href="{{URL::route('ongoing_factory_order_from_wharehouse')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ongoing Orders  @if(NotificationHelpers::ongoing_factory_order_from_wharehouse('factory')>0)
    <span class="badge badge-info right">{{NotificationHelpers::ongoing_factory_order_from_wharehouse('factory')}}</span>
  @endif</p>
                    </a>
                  </li>
                  <li class="nav-item {{ Request::is('Dispatched-Factory-Orders-From-Wharehouse')  ? 'active' :'' }}">
                    <a href="{{URL::route('dispatched_factory_order_from_wharehouse')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Dispatched Orders</p>
                    </a>
                  </li>
                   <li class="nav-item {{ Request::is('Delivered-Factory-Orders-From-Wharehouse')  ? 'active' :'' }}">
                    <a href="{{URL::route('delivered_factory_order_from_wharehouse')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Delivered Orders</p>
                    </a>
                  </li>

                </ul>
              </li>

              <li class="nav-item {{  Request::is('Factory-Ingredients') || Request::is('Factory-Newly-Submitted-Order') || Request::is('Factory-Ongoing-Order') ||   Request::is('Factory-Delivered-Order')   ? 'menu-open' :'' }}">
                <a href="#" class="nav-link {{  Request::is('Factory-Ingredients') || Request::is('Factory-Newly-Submitted-Order') || Request::is('Factory-Ongoing-Order') ||   Request::is('Factory-Delivered-Order') ? 'active' :'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                   Factory Own
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item  {{ Request::is('Factory-Ingredients')  ? 'active' :'' }}">
                <a href="{{URL::route('factory_ingredients')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Available Ingredients</p>
                </a>
              </li>
                
                  <li class="nav-item {{ Request::is('Factory-Newly-Submitted-Order')  ? 'active' :'' }}">
                    <a href="{{URL::route('factory_newly_submitted_order')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Newly Submitted Order</p>
                    </a>
                  </li>
                 
                   <li class="nav-item {{ Request::is('Factory-Ongoing-Order')  ? 'active' :'' }}">
                    <a href="{{URL::route('factory_ongoing_submitted_order')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ongoing Order</p>
                    </a>
                  </li>
                   <li class="nav-item {{ Request::is('Factory-Delivered-Order')  ? 'active' :'' }}">
                    <a href="{{URL::route('factory_completed_submitted_order')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Completed Order</p>
                    </a>
                  </li>
                </ul>
              </li>



          

            </ul>
          </li>