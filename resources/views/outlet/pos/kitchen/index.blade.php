<?php
 $notification_number = 0;
    if(count($data['notifications'])>0){
        $notification_number = count($data['notifications']);
    }
$notification_list_show = '';

foreach ($data['notifications'] as $single_notification){
    $notification_list_show .= '<div class="single_row_notification fix" id="single_notification_row_'.$single_notification->id.'">';
    $notification_list_show .= '<div class="fix single_notification_check_box">';
    $notification_list_show .= '<input class="single_notification_checkbox" type="checkbox" id="single_notification_'.$single_notification->id.'" value="'.$single_notification->id.'">';
    $notification_list_show .= '</div>';
    $notification_list_show .= '<div class="fix single_notification">'.$single_notification->notification.'</div>';
    $notification_list_show .= '<div class="single_serve_button">';
    $notification_list_show .= '<button class="btn bg-blue-btn single_serve_b" id="notification_serve_button_'.$single_notification->id.'">Delete</button>';
    $notification_list_show .= '</div>';
    $notification_list_show .= '</div>';

}
?>
<!DOCTYPE html>
<html class="gr__localhost">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Skyland POS-Kitchen panel</title>
    <link rel="stylesheet" type="text/css" href="{{url('/resources/assets/pos')}}/frequent_changing/bar_panel/css/style.css">

    <link rel="stylesheet" type="text/css" href="{{url('/resources/assets/pos')}}/frequent_changing/bar_panel/css/sweetalert2.min.css">
    <link rel="stylesheet"
          href="{{url('/resources/assets/pos')}}/assets/bower_components/font-awesome/v5/all.min.css">
    <link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="{{url('/resources/assets/pos')}}/asset/plugins/iCheck/minimal/color-scheme.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/dist/css/common.css">
    <link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/dist/css/custom/login.css">

    <script src="{{url('/resources/assets/pos')}}/frequent_changing/bar_panel/js/jquery-3.3.1.min.js"></script>
    <script src="{{url('/resources/assets/pos')}}/frequent_changing/js/jquery-ui.js"></script>
    <script type="text/javascript" src="{{url('/resources/assets/pos')}}/frequent_changing/bar_panel/js/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="{{url('/resources/assets/pos')}}/frequent_changing/bar_panel/js/sweetalert2.all.min.js"></script>
    <script type="text/javascript"
            src="{{url('/resources/assets/pos')}}/assets/bower_components/select2/dist/js/select2.full.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base data-base="{{url('/')}}">
    </base>
    <base data-collect-vat="">
    </base>
    <base data-currency="">
    </base>
    <base data-role="Admin">
    </base>

    <!-- Favicon -->
    <!-- <link rel="shortcut icon" href="http://localhost/pos/images/favicon.ico" type="image/x-icon"> -->
    <!-- Favicon -->
    <!-- <link rel="icon" href="http://localhost/pos/images/favicon.ico" type="image/x-icon"> -->
    <link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/css-framework/bootstrap-new/bootstrap.min.css">
    <link rel="stylesheet" href="{{url('/resources/assets/pos')}}/frequent_changing/newDesign/style.css">
</head>

<body>
    <input type="hidden" id="csrf_name_" value="ci_csrf_token">
    <input type="hidden" id="csrf_value_" value="">

    <span class="ir_display_none" id="selected_order_for_refreshing_help"></span>
    <span class="ir_display_none" id="refresh_it_or_not">Yes</span>
    <div class="wrapper fix">
        <div class="fix main_top">
            <div class="row">
                <div class="top_header col-sm-12 col-md-4">
                       <a href="#" class="brand-link" style="background:white;color:white;padding: 10px 0px;">
      <img src="{{url('public/uploads/logo/sklogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="padding:10px">
      <span class="brand-text font-weight-light">
 
 <?php  

$logo_path=CustomHelpers::logo_path(Sentinel::getUser()->parent_id);

 ?>

    <img src="{{$logo_path}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="float: none;
  
   
   
">

    </span>
    </a>

                   
                </div>
                   <div class="top_header col-sm-12 col-md-2">
                    

                    <h1>Kitchen Panel</h1>
                </div>
                <div class="top_menu col-sm-12 col-md-6 d-flex align-items-center justify-content-end">

                                        <!-- <form action="http://localhost/pos/Authentication/setlanguage" id="language" method="post" accept-charset="utf-8">
                    <select tabindex="2" class="form-control select2 ir_w_100" name="language"
                            onchange='this.form.submit()'>
                            <option value="english" selected>English</option>
                            <option value="spanish" >Spanish</option>
                            <option value="french" >French</option>
                            <option value="arabic" >Arabic</option>
                    </select>
                    </form> -->

                 <!--    <a class="btn bg-blue-btn me-2"href="http://localhost/pos/Authentication/userProfile" id="logout_button"><i
                                class="fas me-2 fas-caret-square-left"></i>Back</a> -->

                    <div class="top_menu_right" id="group_by_order_item_holder ir_h_float_m"></div>
                    
                    <div class="top_menu_right me-2 btn bg-blue-btn">
                        <p class="m-0">
                            <i class="fas fa-sync-alt ir_mouse_pointer" id="refresh_orders_button"></i>
                        </p>
                    </div>

                    <button id="notification_button" data-bs-toggle="modal" data-bs-target="#notification_list_modal" class="btn me-2 bg-blue-btn">
                        <i class="fa me-2 fa-bell"></i>
                        Notification (<span
                            id="notification_counter"></span>)
                    </button>

                    <button id="help_button"  data-bs-toggle="modal" data-bs-target="#help_modal" class="btn me-2 bg-blue-btn">
                        <i class="fa me-2 fa-question-circle"></i>
                        Help</button>
                  <form action="{{URL::to('/logout')}}" id="logout-form" method="POST">
                                        {{ csrf_field() }}
                </form> 
                    <a href="#" onclick="document.getElementById('logout-form').submit()" class="btn bg-blue-btn" id="logout_button">
                        <i class="fas me-2 fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </div>

        <div class="fix main_bottom">
            <div class="fix order_holder mt-2" id="order_holder">

            </div>

        </div>

    </div>

  

    <div class="modal fade" id="help_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Help</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p class="help_content">
                You should click on one/multiple item to mark it as Started Cooking or Done. 
                </p>
                <p class="help_content">
                 You can not select any item for Take Away or Delivery type orders, as you need to deliver these type of orders as a pack Blue color indicates Started Cooking, where green color indicates that the item is Done cooking.                </p>
                <p class="help_content">
                    Until an order is closed from POS Panel, that order will remain here                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="notification_list_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Notification List</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="notification_list_header_holder">
                    <div class="single_row_notification_header fix ir_h_bm">
                        <div class="fix single_notification_check_box">
                            <input type="checkbox" id="select_all_notification">
                        </div>
                        <div class="fix single_notification"><strong>Select All</strong></div>
                        <div class="fix single_serve_button">
                        </div>
                    </div>
                </div>

                <div id="notification_list_holder" class="fix">
                    <!--This variable could not be escaped because this is html content-->
                                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn bg-blue-btn" id="notification_remove_all">Remove</button>
                <button class="btn bg-blue-btn" data-bs-dismiss="modal" id="notification_close">Close</button>
                
            </div>
            </div>
        </div>
    </div>


    <script src="{{url('/resources/assets/pos')}}/assets/css-framework/bootstrap-new/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="{{url('/resources/assets/pos')}}/frequent_changing/kitchen_panel/js/marquee.js"></script>
    <script type="text/javascript" src="{{url('/resources/assets/pos')}}/frequent_changing/kitchen_panel/js/datable.js"></script>
    <script type="text/javascript" src="{{url('/resources/assets/pos')}}/frequent_changing/kitchen_panel/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="{{url('/resources/assets/pos')}}/assets/POS/js/howler.min.js"></script>
    <script type="text/javascript" src="{{url('/resources/assets/pos')}}/frequent_changing/kitchen_panel/js/custom.js"></script>
    <!-- material icon -->

</body>

</html>