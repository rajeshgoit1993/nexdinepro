<li class="nav-item {{ Request::is('New-Registration') || Request::is('Newly-Submitted') || Request::is('Edit-Fanchise')  || Request::is('view-actions') || Request::is('Expired-Subscription') || Request::is('Running-Franchise') || Request::is('Accounts-Actions') || Request::is('Interior-Work-Actions') || Request::is('Social-Media-Actions') || Request::is('Procurement-Actions') || Request::is('Operations-Actions') || Request::is('Interior-Work-Edit') || Request::is('Social-Media-Edit') || Request::is('Operations-Edit') || Request::is('Edit-Ongoing-Franchise')  || Request::is('Accounts-Edit') || Request::is('Edit-Launched-Franchise') || Request::is('Temporary-Inactive') || Request::is('Inactive') || Request::is('Franchise-Pre-Launch') || Request::is('Active-Newly-Submitted') || Request::is('Temporary-Inactive-Newly-Submitted') || Request::is('Ongoing-KYC-Inactive') || Request::is('Ongoing-Pre-launch') || Request::is('Edit-Ongoing-Kyc-Inactive') || Request::is('Edit-Ongoing-Pre-Launch') ? 'menu-open' :'' }}">
<a href="#" class="nav-link">
<i class="nav-icon fas fa-briefcase"></i>           
<p>Franchise <i class="fas fa-angle-left right"></i></p>             
 </a>           
  

<ul class="nav nav-treeview">   
<?php  
$id=Sentinel::getUser()->id;
$role=DB::table('role_users')->where('user_id','=',$id)->first();
$role_id=$role->role_id;
$new_registration=CustomHelpers::get_page_access($role_id,'new_registration');

?>    
@if($new_registration==1 || Sentinel::getUser()->roles[0]->id==1)        
 <li class="nav-item {{ Request::is('New-Registration') ? 'active' :'' }}">               
<a href="{{URL::route('new_registration')}}" class="nav-link ">              
<i class="far fa-circle nav-icon"></i>            
 <p>New Registration</p>            
</a>              
</li> 
<!-- <li class="nav-item {{ Request::is('Newly-Submitted') || Request::is('Edit-Fanchise') ? 'active' :'' }}">  
  <a href="{{URL::route('newly_submitted')}}" class="nav-link">             
  <i class="far fa-circle nav-icon"></i> <p>Newly Submitted</p>               
 </a>                
 </li> -->  
 

<!-- <li class="nav-item {{ Request::is('Pushback-Request') || Request::is('Reply-Fanchise')  ? 'active' :'' }}"><a href="{{URL::route('pushback_request')}}" class="nav-link"><i class="far fa-circle nav-icon"></i>  
 <p>Pushbacked</p>             
</a>              
</li>  -->               
<!-- <li class="nav-item {{ Request::is('Replied-Request')  ? 'active' :'' }}"><a href="{{URL::route('replied_request')}}" class="nav-link"><i class="far fa-circle nav-icon"></i>
<p>Replied</p>                  
 </a>                 
 </li>  -->
 @endif





 <li class="nav-item {{ Request::is('Running-Franchise') || Request::is('Edit-Launched-Franchise') ? 'active' :'' }}"><a href="{{URL::route('launch_fanchise')}}" class="nav-link"><i class="far fa-circle nav-icon"></i>
<p>Running</p>                  
 </a>                 
 </li>

<?php  
$pending_fee=CustomHelpers::get_page_access($role_id,'balance');

?>
@if($pending_fee==1 || Sentinel::getUser()->roles[0]->id==1)  
  <li class="nav-item {{ Request::is('Expired-Subscription')  ? 'active' :'' }}"><a href="{{URL::route('expired_subscription')}}" class="nav-link"><i class="far fa-circle nav-icon"></i>
<p>Expired Subscription</p>                  
 </a>                 
 </li>
@endif

<!-- <li class="nav-item {{ Request::is('Temporary-Inactive') ? 'active' :'' }}">  
  <a href="{{URL::route('temporary_inactive')}}" class="nav-link">             
  <i class="far fa-circle nav-icon"></i> <p>Temporary inactive</p>               
 </a>                
 </li> --> 

 <li class="nav-item {{ Request::is('Inactive') ? 'active' :'' }}">  
  <a href="{{URL::route('inactive')}}" class="nav-link">             
  <i class="far fa-circle nav-icon"></i> <p>Inactive</p>               
 </a>                
 </li> 

</ul>             
</li> 