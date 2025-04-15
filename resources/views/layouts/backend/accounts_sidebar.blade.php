     <li class="nav-item {{ Request::is('New-Order-Payments') || Request::is('Ongoing-Order') || Request::is('Completed-Order') || Request::is('Newly-Order') || Request::is('Accepted-Order-Payments') || Request::is('Newly-Wharehouse-Order-Accounts') || Request::is('Ongoing-Wharehouse-Order-Accounts') || Request::is('Completed-Wharehouse-Order-Accounts') || Request::is('Newly-Factory-Order-Accounts') || Request::is('Ongoing-Factory-Order-Accounts') || Request::is('Completed-Factory-Order-Accounts') || Request::is('Newly-Assigned-Wharehouse-Order') || Request::is('Replied-to-Accounts-Wharehouse-Order') || Request::is('Dispatched-Wharehouse-Order') || Request::is('Newly-Assigned-Factory-Order') || Request::is('Replied-to-Accounts-Factory-Order') || Request::is('Dispatched-Factory-Order')  ? 'menu-open' :'' }}   @if(Request::segment(1)=='Wharehouse-Order-Assign' || Request::segment(1)=='Factory-Order-Assign') menu-open @endif">
<a href="#" class="nav-link">
<i class="nav-icon fas fa-balance-scale"></i>
<p>
Accounts 
<i class="fas fa-angle-left right"></i>
 @if(CustomHelpers::get_order_payment_notification()>0 || NotificationHelpers::newly_wharehouse_order_accounts()>0 || NotificationHelpers::ongoing_accounts_order_from_wharehouse()>0 || NotificationHelpers::newly_factory_order_accounts()>0 || NotificationHelpers::ongoing_accounts_order_from_factory()>0 || NotificationHelpers::dispatched_accounts_order_from_wharehouse()>0 || NotificationHelpers::dispatched_accounts_order_from_factory()>0)
  <span class="badge badge-info right">
    <?php 
      $accounts=0;
    ?>
    @if(CustomHelpers::get_order_payment_notification()>0)
    <?php 
      $accounts=$accounts+CustomHelpers::get_order_payment_notification();
    ?>
    @endif
   @if(NotificationHelpers::newly_wharehouse_order_accounts()>0)
    <?php 
      $accounts=$accounts+NotificationHelpers::newly_wharehouse_order_accounts();
    ?>
    @endif
       @if(NotificationHelpers::ongoing_accounts_order_from_wharehouse()>0)
    <?php 
      $accounts=$accounts+NotificationHelpers::ongoing_accounts_order_from_wharehouse();
    ?>
    @endif
@if(NotificationHelpers::newly_factory_order_accounts()>0)
    <?php 
      $accounts=$accounts+NotificationHelpers::newly_factory_order_accounts();
    ?>
    @endif
    @if(NotificationHelpers::ongoing_accounts_order_from_factory()>0)
    <?php 
      $accounts=$accounts+NotificationHelpers::ongoing_accounts_order_from_factory();
    ?>
    @endif
     @if(NotificationHelpers::dispatched_accounts_order_from_wharehouse()>0)
    <?php 
      $accounts=$accounts+NotificationHelpers::dispatched_accounts_order_from_wharehouse();
    ?>
    @endif
   @if(NotificationHelpers::dispatched_accounts_order_from_factory()>0)
    <?php 
      $accounts=$accounts+NotificationHelpers::dispatched_accounts_order_from_factory();
    ?>
    @endif
    {{$accounts}}
  </span>
  @endif
</p>
</a>

<ul class="nav nav-treeview">
<li class="nav-item">
<a href="{{URL::route('new_order_payments')}}" class="nav-link  {{ Request::is('New-Order-Payments') || Request::is('Order-Placed') || Request::is('Order-Checkout')  ? 'active' :'' }}">
<i class="far fa-circle nav-icon"></i>
<p>New Order Payments 
  @if(CustomHelpers::get_order_payment_notification()>0)
  <span class="badge badge-info right">{{CustomHelpers::get_order_payment_notification()}}</span>
  @endif
</p>
</a>
</li>
<!-- <li class="nav-item">
<a href="{{URL::route('ongoing_order')}}" class="nav-link {{ Request::is('Ongoing-Order') ? 'active' :'' }}">
<i class="far fa-circle nav-icon"></i>
<p>Ongoing Order</p>
</a>
</li> -->
<li class="nav-item">
<a href="{{URL::route('accepted_order_payments')}}" class="nav-link {{ Request::is('Accepted-Order-Payments') ? 'active' :'' }} ">
<i class="far fa-circle nav-icon"></i>
<p> Confirmed Payments</p>
</a>
</li>

 <li class="nav-item {{  Request::is('Newly-Wharehouse-Order-Accounts') || Request::is('Ongoing-Wharehouse-Order-Accounts') || Request::is('Completed-Wharehouse-Order-Accounts') || Request::is('Newly-Assigned-Wharehouse-Order') || Request::is('Replied-to-Accounts-Wharehouse-Order') || Request::is('Dispatched-Wharehouse-Order')  ? 'menu-open' :'' }}  @if(Request::segment(1)=='Wharehouse-Order-Assign') menu-open @endif">
                <a href="#" class="nav-link {{  Request::is('Newly-Wharehouse-Order-Accounts') || Request::is('Ongoing-Wharehouse-Order-Accounts') || Request::is('Completed-Wharehouse-Order-Accounts') || Request::is('Newly-Assigned-Wharehouse-Order') || Request::is('Replied-to-Accounts-Wharehouse-Order') || Request::is('Dispatched-Wharehouse-Order')  ? 'active' :'' }}  @if(Request::segment(1)=='Wharehouse-Order-Assign') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                   Warehouse Orders
                    <i class="fas fa-angle-left right"></i>
                    @if(NotificationHelpers::newly_wharehouse_order_accounts()>0 || NotificationHelpers::ongoing_accounts_order_from_wharehouse()>0 || NotificationHelpers::dispatched_accounts_order_from_wharehouse()>0)
  <span class="badge badge-info right">

  

      <?php 
      $accounts_wharehouse=0;
    ?>
    @if(NotificationHelpers::newly_wharehouse_order_accounts()>0)
    <?php 
      $accounts_wharehouse=$accounts_wharehouse+NotificationHelpers::newly_wharehouse_order_accounts();
    ?>
    @endif
   @if(NotificationHelpers::ongoing_accounts_order_from_wharehouse()>0)
    <?php 
      $accounts_wharehouse=$accounts_wharehouse+NotificationHelpers::ongoing_accounts_order_from_wharehouse();
    ?>
    @endif
     @if(NotificationHelpers::dispatched_accounts_order_from_wharehouse()>0)
    <?php 
      $accounts_wharehouse=$accounts_wharehouse+NotificationHelpers::dispatched_accounts_order_from_wharehouse();
    ?>
    @endif
    {{$accounts_wharehouse}}

   </span>
                       @endif

                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item {{ Request::is('Newly-Wharehouse-Order-Accounts') ? 'active' :'' }} @if(Request::segment(1)=='Wharehouse-Order-Assign') active @endif">
                <a href="{{URL::route('newly_wharehouse_order_accounts')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Newly Order   @if(NotificationHelpers::newly_wharehouse_order_accounts()>0)
  <span class="badge badge-info right">{{NotificationHelpers::newly_wharehouse_order_accounts()}}</span>
  @endif </p>
                </a>
              </li>
                
                  <li class="nav-item {{ Request::is('Newly-Assigned-Wharehouse-Order') ? 'active' :'' }}">
                    <a href="{{URL::route('newly_assigned_wharehouse_order')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Newly Assigned  </p>
                    </a>
                  </li>

                  <li class="nav-item {{ Request::is('Replied-to-Accounts-Wharehouse-Order') ? 'active' :'' }}">
                    <a href="{{URL::route('replied_to_accounts_wharehouse_order')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Replied to Accounts @if(NotificationHelpers::ongoing_accounts_order_from_wharehouse()>0)
    <span class="badge badge-info right">{{NotificationHelpers::ongoing_accounts_order_from_wharehouse()}}</span>
  @endif </p>
                    </a>
                  </li>

                  <li class="nav-item {{ Request::is('Ongoing-Wharehouse-Order-Accounts') ? 'active' :'' }}">
                    <a href="{{URL::route('ongoing_wharehouse_order_accounts')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ongoing Order   </p>
                    </a>
                  </li>

                   <li class="nav-item {{ Request::is('Dispatched-Wharehouse-Order') ? 'active' :'' }}">
                    <a href="{{URL::route('dispatched_wharehouse_order_accounts')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Dispatched  
                        @if(NotificationHelpers::dispatched_accounts_order_from_wharehouse()>0)
    <span class="badge badge-info right">{{NotificationHelpers::dispatched_accounts_order_from_wharehouse()}}</span>
  @endif </p>
                    </a>
                  </li>

                  <li class="nav-item  {{ Request::is('Completed-Wharehouse-Order-Accounts') ? 'active' :'' }}">
                    <a href="{{URL::route('completed_wharehouse_order_accounts')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Completed</p>
                    </a>
                  </li>
              

                </ul>
              </li>

               <li class="nav-item {{  Request::is('Newly-Factory-Order-Accounts') || Request::is('Ongoing-Factory-Order-Accounts') || Request::is('Completed-Factory-Order-Accounts') || Request::is('Newly-Assigned-Factory-Order') || Request::is('Replied-to-Accounts-Factory-Order') || Request::is('Dispatched-Factory-Order') ? 'menu-open' :'' }}  @if(Request::segment(1)=='Factory-Order-Assign') menu-open @endif">
                <a href="#" class="nav-link {{  Request::is('Newly-Factory-Order-Accounts') || Request::is('Ongoing-Factory-Order-Accounts') || Request::is('Completed-Factory-Order-Accounts') ? 'active' :'' }}  @if(Request::segment(1)=='Factory-Order-Assign') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                   Factory Orders
                    <i class="fas fa-angle-left right"></i>
                     @if(NotificationHelpers::newly_factory_order_accounts()>0 || NotificationHelpers::ongoing_accounts_order_from_factory()>0 || NotificationHelpers::dispatched_accounts_order_from_factory()>0)
  <span class="badge badge-info right">

  

      <?php 
      $accounts_factory=0;
    ?>
    @if(NotificationHelpers::newly_factory_order_accounts()>0)
    <?php 
      $accounts_factory=$accounts_factory+NotificationHelpers::newly_factory_order_accounts();
    ?>
    @endif
   @if(NotificationHelpers::ongoing_accounts_order_from_factory()>0)
    <?php 
      $accounts_factory=$accounts_factory+NotificationHelpers::ongoing_accounts_order_from_factory();
    ?>
    @endif
    @if(NotificationHelpers::dispatched_accounts_order_from_factory()>0)
    <?php 
      $accounts_factory=$accounts_factory+NotificationHelpers::dispatched_accounts_order_from_factory();
    ?>
    @endif
    {{$accounts_factory}}

   </span>
                       @endif

                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item {{ Request::is('Newly-Factory-Order-Accounts') ? 'active' :'' }} @if(Request::segment(1)=='Factory-Order-Assign') active @endif">
                <a href="{{URL::route('newly_factory_order_accounts')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Newly Order   @if(NotificationHelpers::newly_factory_order_accounts()>0)
  <span class="badge badge-info right">{{NotificationHelpers::newly_factory_order_accounts()}}</span>
  @endif </p>
                </a>
              </li>
                
                  <li class="nav-item {{ Request::is('Newly-Assigned-Factory-Order') ? 'active' :'' }}">
                    <a href="{{URL::route('newly_assigned_factory_order_accounts')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Newly Assigned  </p>
                    </a>
                  </li>

                   <li class="nav-item {{ Request::is('Replied-to-Accounts-Factory-Order') ? 'active' :'' }}">
                    <a href="{{URL::route('replied_factory_order_accounts')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Replied to Accounts   @if(NotificationHelpers::ongoing_accounts_order_from_factory()>0)
    <span class="badge badge-info right">{{NotificationHelpers::ongoing_accounts_order_from_factory()}}</span>
  @endif</p>
                    </a>
                  </li>

                   <li class="nav-item {{ Request::is('Ongoing-Factory-Order-Accounts') ? 'active' :'' }}">
                    <a href="{{URL::route('ongoing_factory_order_accounts')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ongoing Order </p>
                    </a>
                  </li>

                   <li class="nav-item {{ Request::is('Dispatched-Factory-Order') ? 'active' :'' }}">
                    <a href="{{URL::route('dispatch_factory_order_accounts')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Dispatched   @if(NotificationHelpers::dispatched_accounts_order_from_factory()>0)
    <span class="badge badge-info right">{{NotificationHelpers::dispatched_accounts_order_from_factory()}}</span>
  @endif</p>
                    </a>
                  </li>

                  <li class="nav-item {{ Request::is('Completed-Factory-Order-Accounts') ? 'active' :'' }}">
                    <a href="{{URL::route('completed_factory_order_accounts')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Completed</p>
                    </a>
                  </li>
              

                </ul>
              </li>
</ul>
</li> 
