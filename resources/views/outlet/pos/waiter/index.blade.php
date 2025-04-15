@extends("layouts.backend.master")

@section('maincontent')
   <link rel="stylesheet" type="text/css" href="{{url('/resources/assets/pos')}}/frequent_changing/waiter_panel/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Yantramanav" rel="stylesheet">
    <link rel="stylesheet"
          href="{{url('/resources/assets/pos')}}/assets/bower_components/font-awesome/v5/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{url('/resources/assets/pos')}}/frequent_changing/waiter_panel/css/sweetalert2.min.css">
<link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="{{url('/resources/assets/pos')}}/asset/plugins/iCheck/minimal/color-scheme.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/dist/css/common.css">
    <link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/dist/css/custom/waiterPanel.css">

    <script src="{{url('/resources/assets/pos')}}/frequent_changing/waiter_panel/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="{{url('/resources/assets/pos')}}/frequent_changing/waiter_panel/js/jquery.slimscroll.min.js">
    </script>
    <script type="text/javascript" src="{{url('/resources/assets/pos')}}/frequent_changing/waiter_panel/js/sweetalert2.all.min.js">
    </script>
    <script type="text/javascript"
        src="{{url('/resources/assets/pos')}}/assets/bower_components/select2/dist/js/select2.full.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base data-base="{{url('/')}}">
    </base>
    <base data-collect-vat="">
    </base>
    <base data-currency="Rs">
    </base>
    <base data-role="Admin">
    </base>

    <style>
        body{
            overlay-x: hidden;
        }
    </style>

    <!-- Favicon -->
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
    $notification_list_show .= '<button class="bg-blue-btn btn single_serve_b" id="notification_serve_button_'.$single_notification->id.'">Collect</button>';
    $notification_list_show .= '</div>';
    $notification_list_show .= '</div>';
    
}
?>
    <!-- Favicon -->

    <link rel="stylesheet" href="http://localhost/pos/frequent_changing/newDesign/style.css">


    <input type="hidden" id="csrf_name_" value="ci_csrf_token">
    <input type="hidden" id="csrf_value_" value="">

    <span class="ir_display_none" id="selected_order_for_refreshing_help"></span>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
  <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    <div class="flex-container">
  <div class="flex-item-left"><h5>Newly-Submitted</h5></div>

 <button class="btn bg-blue-btn me-2" data-bs-toggle="modal" data-bs-target="#notification_list_modal" id="notification_button"><i class="fas fa-bell"></i> Notification (<span
                        id="notification_counter"><?php echo POS_SettingHelpers::escape_output($notification_number); ?></span>)</button>

</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
</div>
</section>
<!---->



<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">

   <div class="bottom">
            <div class="notification_wrapper">
                <h1 id="modal_notification_header">Notification List</h1>
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
                    <?php echo $notification_list_show;?>
                                    </div>
                <!-- <span class="btn-close">&times;</span> -->
                <!-- <p>Some text in the Modal..</p> -->
                <div id="notification_close_delete_button_holder">
                    <button class="btn bg-red-btn"id="notification_remove_all">Remove</button>
                    <!-- <button id="notification_close">Close</button> -->
                </div>
            </div>
        </div>



</div>
</section>

  <!-- The Modal -->
   <div class="modal" id="notification_list_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn bg-blue-btn" id="notification_remove_all">Remove</button>
                        <button class="btn bg-blue-btn" data-bs-dismiss="modal" id="notification_close">Close</button>

                    </div>
                </div>
            </div>
    </div>

    <!-- The Modal -->
    <div id="help_modal" class="modal">

        <!-- Modal content -->
        <div class="modal-content" id="modal_help_content">
            <p class="cross_button_to_close">&times;</p>
        
            <h1 class="main_header">Help</h1>
            <p class="help_content">
                You should click on one/multiple item to mark it as Started Preparing or Done. 
            </br>
                You can not select any item for Take Away or Delivery type orders, as you need to deliver these type of orders as a pack Blue color indicates Started Preparing, where green color indicates that the item is Done cooking. 
                <br />
                Until an order is closed from POS Panel, that order will remain here
            </p>
        </div>

    </div>
  <!-- The Modal -->
</div>
</div>
</section>
</div>
@endsection
@section('custom_js')
    <script src="{{url('/resources/assets/pos')}}/assets/css-framework/bootstrap-new/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="{{url('/resources/assets/pos')}}/frequent_changing/waiter_panel/js/marquee.js"></script>
    <script type="text/javascript" src="{{url('/resources/assets/pos')}}/frequent_changing/waiter_panel/js/custom.js"></script>
    <script type="text/javascript" src="{{url('/resources/assets/pos')}}/frequent_changing/waiter_panel/js/datable.js"></script>
    <script type="text/javascript" src="{{url('/resources/assets/pos')}}/frequent_changing/waiter_panel/js/jquery.cookie.js"></script>

@endsection