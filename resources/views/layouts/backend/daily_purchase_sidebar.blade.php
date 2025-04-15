 <?php
$id=Sentinel::getUser()->id;
$area_manager_work=CustomHelpers::get_page_access_data($id,'area_manager_work');
 ?>
 @if($area_manager_work==1)
 <li class="nav-item {{ Request::is('New-Physical-Request') || Request::is('Completed-Physical-Request') 

? 'menu-open' :'' }}">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-bars"></i>
              <p>
                Physical Request
                <i class="fas fa-angle-left right"></i>
                 <span class="badge badge-info right">
{{NotificationHelpers::get_outlet_physical_entry_notification_area_manager()}}
                </span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="{{URL::route('new_physical_request')}}" class="nav-link {{ Request::is('New-Physical-Request')

? 'active' :'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Request</p>
                  <span class="badge badge-info right">
               {{NotificationHelpers::get_outlet_physical_entry_notification_area_manager()}}
               </span>
                </a>
              </li>

              <li class="nav-item ">
                <a href="{{URL::route('completed_physical_request')}}" class="nav-link {{ Request::is('Completed-Physical-Request')

? 'active' :'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Completed Request</p>
                 <!--  <span class="badge badge-info right">
               
              </span> -->
                </a>
              </li>


         

            </ul>
          </li>



 
 <li class="nav-item {{ Request::is('New-Purchase-Request') || Request::is('Ongoing-Purchase-Request') || Request::is('Completed-Purchase-Request') || Request::is('Purchase-Pushbacked-Request') || Request::is('Purchase-Replied-Request')

? 'menu-open' :'' }}">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-truck"></i>
              <p>
                Purchase Request
                <i class="fas fa-angle-left right"></i>
                 <span class="badge badge-info right">
                {{NotificationHelpers::get_outlet_purchase_notification_area_manager(0)+NotificationHelpers::get_outlet_purchase_notification_area_manager(1)+NotificationHelpers::get_outlet_purchase_notification_area_manager(3)}}</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="{{URL::route('new_purchase_request')}}" class="nav-link {{ Request::is('New-Purchase-Request')

? 'active' :'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Newly Request</p>
                  <span class="badge badge-info right">
                {{NotificationHelpers::get_outlet_purchase_notification_area_manager(0)}}</span>
                </a>
              </li>

              <li class="nav-item ">
                <a href="{{URL::route('new_pushbacked_request')}}" class="nav-link {{ Request::is('Purchase-Pushbacked-Request')

? 'active' :'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pushbacked Request</p>
                  <span class="badge badge-info right">
                {{NotificationHelpers::get_outlet_purchase_notification_area_manager(3)}}</span>
                </a>
              </li>

 <li class="nav-item ">
                <a href="{{URL::route('new_replied_request')}}" class="nav-link {{ Request::is('Purchase-Replied-Request')

? 'active' :'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Replied Request</p>
                  <span class="badge badge-info right">
                {{NotificationHelpers::get_outlet_purchase_notification_area_manager(4)}}</span>
                </a>
              </li>


              <li class="nav-item">
                <a href="{{URL::route('ongoing_purchase_request')}}" class="nav-link {{ Request::is('Ongoing-Purchase-Request')

? 'active' :'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ongoing</p>
                  <span class="badge badge-info right">
                {{NotificationHelpers::get_outlet_purchase_notification_area_manager(1)}}</span>
                </a>
              </li>
            
              <li class="nav-item">
                <a href="{{URL::route('completed_purchase_request')}}" class="nav-link {{ Request::is('Completed-Purchase-Request')

? 'active' :'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Completed </p>
                </a>
              </li>

         

            </ul>
          </li>
           @endif

           @if(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise') || Sentinel::getUser()->inRole('waiter') || Sentinel::getUser()->inRole('kitchen') || Sentinel::getUser()->inRole('cashier')) 

            <li class="nav-item {{ Request::is('Purchase') || Request::is('Add-Purchase') || Request::is('Approved-Purchase') || Request::is('Completed-Purchase') || Request::is('Purchase-Pushbacked') || Request::is('Purchase-Replied') 

? 'menu-open' :'' }}   @if(Request::segment(1)=='Edit-Daily-Purchase' || Request::segment(1)=='Enter-Daily-Purchase' ||  Request::segment(1)=='Reedit-Daily-Purchase' || Request::segment(1)=='Edit-Pushbacked-Purchase') menu-open @endif">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-truck"></i>
              <p>
                Daily Purchase 
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">
                {{NotificationHelpers::get_outlet_purchase_notification(0)+NotificationHelpers::get_outlet_purchase_notification(1)+NotificationHelpers::get_outlet_purchase_notification(3)+NotificationHelpers::get_outlet_purchase_notification(4)}}</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="{{URL::route('purchase')}}" class="nav-link {{ Request::is('Purchase') || Request::is('Add-Purchase') 

? 'active' :'' }}  @if(Request::segment(1)=='Edit-Daily-Purchase') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Newly Submitted</p>

                  <span class="badge badge-info right">{{NotificationHelpers::get_outlet_purchase_notification(0)}}</span>
                </a>
              </li>

              <li class="nav-item ">
                <a href="{{URL::route('purchase_pushbacked')}}" class="nav-link {{ Request::is('Purchase-Pushbacked') || Request::is('Add-Purchase') 

? 'active' :'' }}  @if(Request::segment(1)=='Edit-Pushbacked-Purchase') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pushbacked</p>

                  <span class="badge badge-info right">{{NotificationHelpers::get_outlet_purchase_notification(3)}}</span>
                </a>
              </li>

 <li class="nav-item ">
                <a href="{{URL::route('purchase_replied')}}" class="nav-link {{ Request::is('Purchase-Replied')  

? 'active' :'' }} ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Replied</p>

                  <span class="badge badge-info right">{{NotificationHelpers::get_outlet_purchase_notification(4)}}</span>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{URL::route('approved_purchase')}}" class="nav-link {{ Request::is('Approved-Purchase')

? 'active' :'' }} @if(Request::segment(1)=='Enter-Daily-Purchase' || Request::segment(1)=='Reedit-Daily-Purchase') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Approved </p>
                  <span class="badge badge-info right">{{NotificationHelpers::get_outlet_purchase_notification(1)}}</span>
                </a>
              </li>
            
              <li class="nav-item">
                <a href="{{URL::route('completed_purchase')}}" class="nav-link {{ Request::is('Completed-Purchase')

? 'active' :'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Completed </p>
                </a>
              </li>

         

            </ul>
          </li>
           @endif