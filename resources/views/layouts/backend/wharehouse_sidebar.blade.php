<li class="nav-item {{ Request::is('Manage-Warehouse') || Request::is('Add-Warehouse') || Request::is('Edit-Warehouse') || Request::is('Manage-Warehouse-Products') || Request::is('Manage-Warehouse-Orders') || Request::is('Warehouse-Newly-Submitted-Order') || Request::is('Warehouse-Ongoing-Order') || Request::is('Warehouse-Delivered-Order') || Request::is('Ongoing-Franchise-Orders') || Request::is('Completed-Franchise-Orders')   ? 'menu-open' :'' }}  ">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-store"></i>
              <p>
                Manage Warehouse
                <i class="fas fa-angle-left right"></i>
                 @if(NotificationHelpers::get_wherehouse_new_order_notification()>0)
    <span class="badge badge-info right">{{NotificationHelpers::get_wherehouse_new_order_notification()}}</span>
  @endif
              </p>
            </a>
            <ul class="nav nav-treeview">
                @if(Sentinel::getUser()->inRole('superadmin'))
              <li class="nav-item ">
                <a href="{{URL::route('manage_stores')}}" class="nav-link {{ Request::is('Manage-Warehouse') || Request::is('Add-Warehouse') || Request::is('Edit-Warehouse') ? 'active' :'' }}
                ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Warehouse List</p>
                </a>
              </li>
                  @endif
          <li class="nav-item {{  Request::is('Manage-Warehouse-Products') || Request::is('Warehouse-Newly-Submitted-Order') || Request::is('Warehouse-Ongoing-Order') || Request::is('Warehouse-Delivered-Order')  ? 'menu-open' :'' }}">
                <a href="#" class="nav-link {{  Request::is('Manage-Warehouse-Products') || Request::is('Warehouse-Newly-Submitted-Order') || Request::is('Warehouse-Ongoing-Order') || Request::is('Warehouse-Delivered-Order')? 'active' :'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                   Warehouse Own
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item  {{ Request::is('Manage-Warehouse-Products')  ? 'active' :'' }}">
                <a href="{{URL::route('manage_store_product')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Available Product</p>
                </a>
              </li>
                
                  <li class="nav-item {{ Request::is('Warehouse-Newly-Submitted-Order')  ? 'active' :'' }}">
                    <a href="{{URL::route('wharehouse_newly_submitted_order')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Newly Submitted Order</p>
                    </a>
                  </li>
                 
                   <li class="nav-item  {{ Request::is('Warehouse-Ongoing-Order')  ? 'active' :'' }}">
                    <a href="{{URL::route('wharehouse_ongoing_submitted_order')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ongoing Order</p>
                    </a>
                  </li>
                   <li class="nav-item {{ Request::is('Warehouse-Delivered-Order')  ? 'active' :'' }}">
                    <a href="{{URL::route('wharehouse_completed_submitted_order')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Completed Order</p>
                    </a>
                  </li>
                </ul>
              </li>

             
     
       <li class="nav-item {{  Request::is('Manage-Warehouse-Orders') || Request::is('Ongoing-Franchise-Orders') || Request::is('Completed-Franchise-Orders')  ? 'menu-open' :'' }}">
                <a href="#" class="nav-link {{  Request::is('Manage-Warehouse-Orders') || Request::is('Ongoing-Franchise-Orders') || Request::is('Completed-Franchise-Orders')  ? 'active' :'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                  Franchise  Orders
                    <i class="fas fa-angle-left right"></i> 
                    @if(NotificationHelpers::get_wherehouse_new_order_notification()>0)
    <span class="badge badge-info right">{{NotificationHelpers::get_wherehouse_new_order_notification()}}</span>
  @endif

                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item  {{ Request::is('Manage-Warehouse-Orders')  ? 'active' :'' }}">
                <a href="{{URL::route('manage_store_order')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Orders</p>  
                  @if(NotificationHelpers::get_wherehouse_new_order_notification()>0)
  <span class="badge badge-info right">{{NotificationHelpers::get_wherehouse_new_order_notification()}}</span>
  @endif
                </a>
              </li>
                
                  <li class="nav-item {{ Request::is('Ongoing-Franchise-Orders')  ? 'active' :'' }}">
                    <a href="{{URL::route('ongoing_franchise_orders')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ongoing Orders</p>
                    </a>
                  </li>
                 
              
                 <li class="nav-item {{ Request::is('Completed-Franchise-Orders')  ? 'active' :'' }}">
                    <a href="{{URL::route('completed_franchise_orders')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Completed Orders</p>
                    </a>
                  </li>

                </ul>
              </li>




            
            </ul>
          </li>