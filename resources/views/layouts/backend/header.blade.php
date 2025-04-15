<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NexCen POS</title>
   <meta name="csrf-token" content="{{ csrf_token() }}">
 
   <input type="hidden" id="APP_URL" value="{{url('/')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/resources/assets/admin-lte/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('/resources/assets/admin-lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('/resources/assets/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('/resources/assets/admin-lte/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('/resources/assets/admin-lte/plugins/jsgrid/jsgrid.min.css')}}">
  <link rel="stylesheet" href="{{asset('/resources/assets/admin-lte/plugins/jsgrid/jsgrid-theme.min.css')}}">
  <link rel="stylesheet" href="{{asset('/resources/assets/admin-lte/dist/css/adminlte.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('/resources/assets/admin-lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('/resources/assets/admin-lte/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('/resources/assets/admin-lte/plugins/summernote/summernote-bs4.min.css')}}">
  <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="{{asset('/resources/assets/admin-lte/webcam.js')}}"></script>
@yield("custom_css")
</head>
  <style type="text/css">
    .flex-container {
  display: flex;
  flex-wrap: wrap;
 /* font-size: 30px;*/
  text-align: left;
  padding: 5px;
  line-height: 1;
}

.flex-item-left {
  
  flex: 50%;
}

.flex-item-right {

  flex: 50%;
  text-align: right;
}

/* Responsive layout - makes a one column-layout instead of a two-column layout */
/*@media (max-width: 800px) {
  .flex-item-right, .flex-item-left {
    flex: 100%;
  }
}*/

  .card
{
  padding: 5px !important;
  margin-top: 10px;
  margin-bottom: .1rem !important;
}
.connectedSortable
{
  min-height: 0px !important;
}
[class*=sidebar-dark-] {
    background-color: #3c2e7a!important;
}
[class*=sidebar-dark-] .sidebar a {
    color: white;
}
[class*=sidebar-dark-] .active
{
  background: #2d2163 !important;
  color: #ffde00 !important;
}
.content-wrapper {

    background: url({{url('/resources/img_bg.jpg')}}) no-repeat;
    background-position: left;
    background-size: 100% 100%;
    min-height: 500px

}
.dataTables_filter label
{
  font-weight: bold !important; 
}
table.dataTable.no-footer {
    border-bottom: 1px solid #ccc5c5
}
.form-card h4,h5
{

    text-shadow: 3px 3px #dcd0d0;
    font-weight: bold;
    transition: all .2s ease-in-out;
    font-size: 25px;

    z-index: 1

}
.form-card h4,h5:hover
{
color: #3c2f7d

}
 .box
  {
   width:800px;
   margin:0 auto;
  }
  .active_tab1
  {
   background-color:#fff;
   color:#333;
   font-weight: 600;
  }
  .inactive_tab1
  {
   background-color: #f5f5f5;
   color: #333;
   cursor: not-allowed;
  }
  .has-error
  {
   border-color:#cc0000;
   background-color:#ffff99;
  }
  /**/
  .flex-container_second {
  display: flex;
  flex-direction: row;

  
}

.flex-item-left {
 
  padding: 10px;
  flex: 50%;
  border-right: 1px solid lightgray;
}

.flex-item-right_second {

  padding: 10px;
  flex: 50%;
}

/* Responsive layout - makes a one column-layout instead of two-column layout */
@media (max-width: 800px) {
  .flex-container_second {
    flex-direction: column;
  }
  .flex-item-left {
 
  border-right: 0px solid lightgray;
}
}
/**/

    .accordion .fa{
        margin-right: 0.5rem;
    }
    /**/
    .status_remarks
    {
      display: none;
    }
</style>
<style>

#overlay{ 
  position: fixed;
  top: 0;
  z-index: 145455;
  width: 100%;
  height:100%;
  display: none;
  background: rgba(0,0,0,0.6);
}
.cv-spinner {
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;  
}
.spinner {
  width: 40px;
  height: 40px;
  border: 4px #ddd solid;
  border-top: 4px #2e93e6 solid;
  border-radius: 50%;
  animation: sp-anime 0.8s infinite linear;
}
@keyframes sp-anime {
  100% { 
    transform: rotate(360deg); 
  }
}
.is-hide{
  display:none;
}

</style>
<style>
  .required:after {
    content:" *";
    color: red;
  }
</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
 <!--  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('/resources/assets/admin-lte/dist/img/AdminLTELogo.png')}}" alt="" height="60" width="60">
  </div> -->

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      @if(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise'))  
      <li class="nav-item">
 <a class="nav-link" style="cursor: none;"  href="#" role="button">Hello, {{Sentinel::getUser()->name }} </a>
      </li>
      @endif
     <!--  <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
    <!--   <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li> -->
 
      <!-- Messages Dropdown Menu -->
       @if(Sentinel::check())
      @if(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise') || Sentinel::getUser()->inRole('vendor') || Sentinel::getUser()->inRole('store'))   

      @else

        <?php  

$upcoming_all=DB::table('users')->whereIn('registration_level',[1,2,3])->WhereRaw('DAYOFYEAR(curdate()) < DAYOFYEAR(birthday) AND DAYOFYEAR(curdate()) + 7 >=  dayofyear(birthday)' )->OrderBy(DB::raw("DAYOFYEAR(birthday)"),'ASC')->get();
$today_all=DB::table('users')->whereIn('registration_level',[1,2,3])->WhereRaw('DAYOFYEAR(curdate()) <= DAYOFYEAR(birthday) AND DAYOFYEAR(curdate()) + 0 >=  dayofyear(birthday)' )->OrderBy(DB::raw("DAYOFYEAR(birthday)"),'ASC')->get();

     ?>
    
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-birthday-cake"></i>
          <span class="badge badge-danger navbar-badge">{{ count($upcoming_all)+count($today_all) }} </span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
         <a href="{{route('admin_dashboard')}}" class="dropdown-item">
            <i class="far fa-calendar-check mr-2"></i> {{count($today_all)}} Today Birthday
            
          </a>
          <div class="dropdown-divider"></div>
           <a href="{{route('admin_dashboard')}}" class="dropdown-item">
            <i class="far fa-calendar-alt mr-2"></i> {{count($upcoming_all)}} Upcoming Birthday
           
          </a>
          <div class="dropdown-divider"></div>
          
         
         
        
        </div>
      </li>
        @endif
@endif
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
       <!--  <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a> -->
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
    <!--   <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
    </ul>
  </nav>
  <style>


.button_flex {
 display: flex;
 justify-content: space-between;
}

.button_left {

flex-grow: 1;
flex-shrink: 1;
margin-right: 5px;
margin-bottom: 5px;
}


</style>

  <!-- /.navbar -->