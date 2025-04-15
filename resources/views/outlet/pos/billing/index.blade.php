<style type="text/css">
.vg_Yes,.vg_VEG 
  {
    background: #39a539  !important;
    color: white !important;
  }
.vg_No,.nvg_NONVEG 
  {
    background: #ff6242  !important;
    color: white !important;
  }
  .beverage_BEV
  {
    background: #607d8b !important;
    color: white !important;
  }
.main_right .category_items .single_item .item_name {
   
    font-weight: bold !important;
}
#delete_order_by_admin {
  max-width: 500px;
}
</style>
<?php  

$notification_number = 0;

if(count($data['notifications'])>0){
    $notification_number = count($data['notifications']);
}
/*******************************************************************************************************************
 * This secion is to construct menu list****************************************************************************
 *******************************************************************************************************************
 */
$previous_category = 0;

$i = 0;
$menu_to_show = "";
$javascript_obects = "";

function cmp($a, $b)
{
    return strcmp($a->category_id, $b->category_id);
}

if(isset($data['food_menus']) && $data['food_menus']):
    $total_menus = count($data['food_menus']);
    // usort($data['food_menus'], "cmp");
   
    
    // $previous_price = (array)json_decode($outlet_information->food_menu_prices);
    // $language_manifesto = $getCompanyInfo->language_manifesto;

foreach($data['food_menus'] as $single_menus){
    // if(str_rot13($language_manifesto)=="eriutoeri"){
    //     $sale_price = isset($previous_price["tmp".$single_menus->id]) && $previous_price["tmp".$single_menus->id]?$previous_price["tmp".$single_menus->id]:$single_menus->sale_price;
    // }else{
    //  $sale_price = $single_menus->sale_price;   
    // }
    $sale_price = $single_menus->sale_price;
    //checks that whether its new category or not    
    $is_new_category = false;
    //get current food category
    $current_category = $single_menus->category_id;
    $veg_status1 = "no";
    if($single_menus->veg_item=="Yes"){
        $veg_status1 = "yes";
    }
    $non_veg_status1 = "no";
    if($single_menus->non_veg_item=="Yes"){
        $non_veg_status1 = "yes";
    }
    $beverage_status = "no";
    if($single_menus->beverage_item=="Yes"){
        $beverage_status = "yes";
    }
    
    //if it the first time of loop then default previous category is 0
    //if it's 0 then set current category id to $previous category and set first category div
    if($previous_category == 0){
        $previous_category = $current_category;    
        $menu_to_show .= '<div id="category_'.$single_menus->category_id.'" class="specific_category_items_holder">';
    }
    //if previous category and current category is not equal. it means it's a new category 
    if($previous_category!=$current_category){
        
        $previous_category = $current_category;
        $is_new_category = true;
    }

    //if category is new and total menus are not finish yet then set exit to previous category and create new category
    //div
    if($is_new_category==true && $total_menus!=$i){
        $menu_to_show .= '</div>';
        $menu_to_show .= '<div id="category_'.$single_menus->category_id.'" class="specific_category_items_holder">';
    }

    if($single_menus->photo!=""){
        $image_path = url('public/uploads/').'/food_menu/'.$single_menus->photo;
    }else{
        $image_path =url('public/uploads/').'/food_menu/no_image.jpg';
    }

    //construct new single item content
    $menu_to_show .= '<div class="single_item animate__animated animate__flipInX vg_'.$single_menus->veg_item.' "  id="item_'.$single_menus->id.'">';
    // $menu_to_show .= '<img src="'.$image_path.'" alt="" width="142">';
   
    $menu_to_show .= '<p class="item_name" data-tippy-content="'.$single_menus->name.' ('.$single_menus->code.'">'.$single_menus->name.' ('.$single_menus->code.')</p>';
     $menu_to_show .= '<p class="item_price">Price: <span id="price_'.$single_menus->id.'">'.POS_SettingHelpers::getAmtP($sale_price).'</span></p>';

    $menu_to_show .= '</div>';
    //if its the last content and there is no more category then set exit to last category
    if($is_new_category==false && $total_menus==$i){
        $menu_to_show .= '</div>';
    }

    //checks and hold the status of veg item
    if($single_menus->veg_item=='Yes'){
        $veg_status = "VEG";
    }else{
        $veg_status = "";
    }
   //checks and hold the status of Non-Veg item
    if($single_menus->non_veg_item=='Yes'){
        $non_veg_status = "NONVEG";
    }else{
        $non_veg_status = "";
    }
    //checks and hold the status of beverage item
    if($single_menus->beverage_item=='Yes'){
        $soft_status = "BEV";
    }else{
        $soft_status = "";
    }

    //get modifiers if menu id match with menu modifiers table
    $modifiers = '';
    $j=1;
    foreach($data['menu_modifiers'] as $single_menu_modifier){
        if($single_menu_modifier->food_menu_id==$single_menus->id){
            if($j==count($menu_modifiers)){
                $modifiers .="{menu_modifier_id:'".$single_menu_modifier->modifier_id."',menu_modifier_name:'".$single_menu_modifier->name."',tax_information:'".$single_menus->tax_information."',menu_modifier_price:'".POS_SettingHelpers::getAmtP($single_menu_modifier->price)."'}";
            }else{
                $modifiers .="{menu_modifier_id:'".$single_menu_modifier->modifier_id."',menu_modifier_name:'".$single_menu_modifier->name."',tax_information:'".$single_menus->tax_information."',menu_modifier_price:'".POS_SettingHelpers::getAmtP($single_menu_modifier->price)."'},";
            }
            
        }
        $j++;
    }
    //this portion construct javascript objects, it is used to search item from search input
    if($total_menus==$i){
        $javascript_obects .= "{item_id:'".$single_menus->id."',item_code:'".(str_replace("'", ' ', str_replace('"', ' ', $single_menus->code)))."',category_name:'".(str_replace("'", ' ', str_replace('"', ' ', $single_menus->category_name)))."',item_name:'".(str_replace("'", ' ', str_replace('"', ' ',preg_replace('/\s\s+/', ' ',$single_menus->name))))."',price:'".POS_SettingHelpers::getAmtP($sale_price)."',image:'".$image_path."',tax_information:'".$single_menus->tax_information."',vat_percentage:'0',veg_item:'".$veg_status."',beverage_item:'".$soft_status."',non_veg_item:'".$non_veg_status."',sold_for:'122',veg_item_status:'".$veg_status1."',beverage_item_status:'".$beverage_status."',non_veg_item_status:'".$non_veg_status1."',modifiers:[".$modifiers."]}";
    }else{
        $javascript_obects .= "{item_id:'".$single_menus->id."',item_code:'".(str_replace("'", ' ', str_replace('"', ' ', $single_menus->code)))."',category_name:'".(str_replace("'", ' ', str_replace('"', ' ', $single_menus->category_name)))."',item_name:'".(str_replace("'", ' ', str_replace('"', ' ',preg_replace('/\s\s+/', ' ',$single_menus->name))))."',price:'".POS_SettingHelpers::getAmtP($sale_price)."',image:'".$image_path."',tax_information:'".$single_menus->tax_information."',vat_percentage:'0',veg_item:'".$veg_status."',beverage_item:'".$soft_status."',non_veg_item:'".$non_veg_status."',sold_for:'122',veg_item_status:'".$veg_status1."',beverage_item_status:'".$beverage_status."',non_veg_item_status:'".$non_veg_status1."',modifiers:[".$modifiers."]},";
    }

    //increasing always with the number of loop to check the number of menus
    $i++;    

    
    
}
endif;

$j = 1;
$javascript_obects_modifier = "";
foreach($data['menu_modifiers'] as $single_menu_modifier){
    if($j==count($menu_modifiers)){
        $javascript_obects_modifier .="{menu_modifier_id:'".$single_menu_modifier->modifier_id."',menu_modifier_name:'".$single_menu_modifier->name."',tax_information:'".$single_menus->tax_information."',menu_modifier_price:'".POS_SettingHelpers::getAmtP($single_menu_modifier->price)."'}";
    }else{
        $javascript_obects_modifier .="{menu_modifier_id:'".$single_menu_modifier->modifier_id."',menu_modifier_name:'".$single_menu_modifier->name."',tax_information:'".$single_menus->tax_information."',menu_modifier_price:'".POS_SettingHelpers::getAmtP($single_menu_modifier->price)."'},";
    }
    $j++;
}

/*******************************************************************************************************************
 * End of This secion is to construct menu list*********************************************************************
 *******************************************************************************************************************
 */

/*******************************************************************************************************************
 * This secion is to construct category ****************************************************************************
 *******************************************************************************************************************
 */
$i = 1;
$cateogry_slide_to_show = '';
foreach($data['menu_categories'] as $single_category){
    
    if($i = 1){
        $cateogry_slide_to_show .= '<li><a href="#" class="category_button" id="button_category_'.$single_category->id.'">'.$single_category->category_name.'</a></li>';
                               
    }else{
        $cateogry_slide_to_show .= '<li><a href="#" class="category_button" id="button_category_'.$single_category->id.'">'.$single_category->category_name.'</a></li>';
    }
    
}

/*******************************************************************************************************************
 * End of This secion is to construct category ****************************************************************************
 *******************************************************************************************************************
 */

/********************************************************************************************************************
 * This section is to construct options of customer select input*****************************************************
 * ******************************************************************************************************************
 */
 $customers_option = '';
$total_customers = count($data['customers']);
$i = 1;
$customer_objects = '';
$check_walk_in_customer = 1;
foreach ($data['customers'] as $customer){
    $selected = "";
    // $default_customer = $getCompanyInfo->default_customer;
    // if($customer->id==$default_customer){
    //     $selected = "selected";
    // }

    if($customer->id==1){
        $check_walk_in_customer++;
    }
    if($customer->name=='Walk-in Customer'){
        $customers_option = '<option '.$selected.' value="'.$customer->id.'" selected>'.$customer->name.' '.$customer->phone.'</option>'.$customers_option;
    }else{
        $customers_option .= '<option '.$selected.' value="'.$customer->id.'" '.$selected.'>'.$customer->name.' '.$customer->phone.'</option>';
    }

    if($total_customers==$i){
        $customer_objects .= "{customer_id:'".$customer->id."',customer_name:'".(str_replace("'", ' ', str_replace('"', ' ', $customer->name)))."',customer_address:'".(str_replace("'", ' ', str_replace('"', ' ', $customer->address)))."',gst_number:'".$customer->gst_number."'}";
    }else{
        $customer_objects .= "{customer_id:'".$customer->id."',customer_name:'".(str_replace("'", ' ', str_replace('"', ' ', $customer->name)))."',customer_address:'".(str_replace("'", ' ', str_replace('"', ' ', $customer->address)))."',gst_number:'".$customer->gst_number."'},";
    }

    $i++;
}

if($check_walk_in_customer==1 && $customers_option==""){
    // $customers_option = '<option selected value="1">Walk-in Customer</option>';
    $customer_objects .= "{customer_id:'1',customer_name:'".(str_replace("'", ' ', str_replace('"', ' ', 'Walk-in Customer')))."',customer_address:'".(str_replace("'", ' ', str_replace('"', ' ', '')))."',gst_number:''}";
}else if($check_walk_in_customer==1 && $customers_option){
    // $customers_option = '<option selected value="1">Walk-in Customer</option>';
    $customer_objects .= ",{customer_id:'1',customer_name:'".(str_replace("'", ' ', str_replace('"', ' ', 'Walk-in Customer')))."',customer_address:'".(str_replace("'", ' ', str_replace('"', ' ', '')))."',gst_number:''}";
}
/********************************************************************************************************************
 * This section is to construct options of customer select input*****************************************************
 * ******************************************************************************************************************
 */

/********************************************************************************************************************
 * This section is to construct options of customer select input*****************************************************
 * ******************************************************************************************************************
 */
$waiters_option = '';
$default_waiter_id = 0;
foreach ($data['waiters'] as $waiter){
    $selected = "";
    // $role = $this->session->userdata('role');
    // $user_id = $this->session->userdata('user_id');
    // $default_waiter = $getCompanyInfo->default_waiter;
    // if($waiter->id==$default_waiter){
    //     $selected = "selected";
    //     $default_waiter_id = $waiter->id;
    // }else{
    //     if(isset($role) && $role!="Admin"){
    //         if($waiter->id==$user_id){
    //             $selected = "selected";
    //             $default_waiter_id = $user_id;
    //         }
    //     }
    // }
    if($waiter->full_name=='Default Waiter'){
        $waiters_option = '<option '.$selected.' value="'.$waiter->id.'">'.$waiter->name.'</option>'.$waiters_option;
    }else{
        $waiters_option .= '<option '.$selected.' value="'.$waiter->id.'">'.$waiter->name.'</option>';
    }
    
}
/********************************************************************************************************************
 * This section is to construct options of customer select input*****************************************************
 * ******************************************************************************************************************
 */

/********************************************************************************************************************
 * This section is to construct table modal's content****************************************************************
 ********************************************************************************************************************
 */

$tables_modal = '';
foreach($data['tables'] as $table){
    $tables_modal .= '<div class="floatleft fix single_order_table" id="single_table_info_holder_'.$table->id.'">';
    $tables_modal .= '<p class="table_name" class="ir_font_bold"><span id="sit_name_'.$table->id.'">'.$table->name.'<span></p>';
    $tables_modal .= '<p class="table_sit_capacity">Sit Capacity: <span id="sit_capacity_number_'.$table->id.'">'.$table->sit_capacity.'<span></p>';
    $tables_modal .= '<p class="table_available">Available: <span id="sit_available_number_'.$table->id.'">'.$table->sit_capacity.'</span></p>';
    $tables_modal .= '<img class="table_image" src="'.url('/public').'/uploads/table_icon2.png" alt="">'; 
    $tables_modal .= '<p class="running_order_in_table">Running orders in table</p>';
    $tables_modal .= '<div class="single_table_order_details_holder fix" id="single_table_order_details_holder_'.$table->id.'">';
    $tables_modal .= '<div class="top fix" id="single_table_order_details_top_'.$table->id.'">';
    $tables_modal .= '<div class="single_row header">';
    $tables_modal .= '<div class="floatleft fix column first_column">Order</div>';
    $tables_modal .= '<div class="floatleft fix column second_column">Time</div>';
    $tables_modal .= '<div class="floatleft fix column third_column">Person</div>';
    $tables_modal .= '<div class="floatleft fix column forth_column">Del</div>';
    $tables_modal .= '</div>';
    if(count($table->orders_table)>0){
        foreach($table->orders_table as $single_order_table){
            $tables_modal .= '<div class="single_row fix">';
            $tables_modal .= '<div class="floatleft fix column first_column">'.$single_order_table->sale_id.'</div>';
            $tables_modal .= '<div class="floatleft fix column second_column">'.$single_order_table->booking_time.'</div>';
            $tables_modal .= '<div class="floatleft fix column third_column">'.$single_order_table->persons.'</div>';
            $tables_modal .= '<div class="floatleft fix column forth_column"><i class="fas fa-trash-alt remove_table_order" id="remove_table_order_'.$single_order_table->id.'"></i></div>';
            $tables_modal .= '</div>';
        }

    }

    $tables_modal .= '</div>';
    $tables_modal .= '<div class="bottom fix" id="single_table_order_details_bottom_'.$table->id.'">';
    $tables_modal .= '<input type="text" name="" placeholder="Order" class="floatleft bottom_order"  id="single_table_order_details_bottom_order_'.$table->id.'" readonly>';
    $tables_modal .= '<input type="text" name="" placeholder="Person" class="floatleft bottom_person" id="single_table_order_details_bottom_person_'.$table->id.'">';
    $tables_modal .= '<button class="floatleft bottom_add" id="single_table_order_details_bottom_add_'.$table->id.'">Add</button>';
    $tables_modal .= '</div>';
    $tables_modal .= '</div>';
    $tables_modal .= '</div>';
}
/********************************************************************************************************************
 * End This section is to construct table modal's content****************************************************************
 ********************************************************************************************************************
 **/
$order_list_left = '';
$i = 1;

foreach($data['new_orders'] as $single_new_order){
    $width = 100;
    $total_kitchen_type_items = $single_new_order->total_kitchen_type_items;
    $total_kitchen_type_started_cooking_items = $single_new_order->total_kitchen_type_started_cooking_items;
    $total_kitchen_type_done_items = $single_new_order->total_kitchen_type_done_items;
    if($total_kitchen_type_items==0){
        $total_kitchen_type_items = 1;  
    }
    $splitted_width = round($width/$total_kitchen_type_items,2);
    $percentage_for_started_cooking = round($splitted_width*$total_kitchen_type_started_cooking_items,2);
    $percentage_for_done_cooking = round($splitted_width*$total_kitchen_type_done_items,2);
    if($i==1){
        $order_list_left .= '<div data-started-cooking="'.$total_kitchen_type_started_cooking_items.'" data-done-cooking="'.$total_kitchen_type_done_items.'" class="txt_14 single_order fix new_order_'.$single_new_order->sale_id.'" data-selected="unselected" id="order_'.$single_new_order->sale_id.'">';
    }else{
        $order_list_left .= '<div data-started-cooking="'.$total_kitchen_type_started_cooking_items.'" data-done-cooking="'.$total_kitchen_type_done_items.'" class="single_order fix new_order_'.$single_new_order->sale_id.'" data-selected="unselected" id="order_'.$single_new_order->sale_id.'">';
    }
    $order_list_left .='<div class="inside_single_order_container">';
    $order_list_left .='<div class="single_order_content_holder_inside fix">';
    $order_name = '';
    if($single_new_order->order_type=='1'){
        $order_name = 'A '.$single_new_order->sale_no;
    }else if($single_new_order->order_type=='2'){
        $order_name = 'B '.$single_new_order->sale_no;
    }else if($single_new_order->order_type=='3'){
        $order_name = 'C '.$single_new_order->sale_no;
    }
    
    $minutes = $single_new_order->minute_difference;
    $seconds = $single_new_order->second_difference;
    $tables_booked = '';
    if(count($single_new_order->tables_booked)>0){
        $w = 1;
        foreach($single_new_order->tables_booked as $single_table_booked){
            if($w == count($single_new_order->tables_booked)){
                $tables_booked .= $single_table_booked->table_name;
            }else{
                $tables_booked .= $single_table_booked->table_name.', ';
            }
            $w++;
        }    
    }else{
        $tables_booked = 'None';
    }
     if($single_new_order->order_type=='1'){
       
    }else if($single_new_order->order_type=='2'){
         $tables_booked = 'Take Away';
    }else if($single_new_order->order_type=='3'){
         $tables_booked = 'Delivery';
    }
    $order_list_left .= '<span id="open_orders_order_status_'.$single_new_order->sale_id.'" class="ir_display_none">'.$single_new_order->order_status.'</span><p><span class="running_order_customer_name">Cust: '.$single_new_order->customer_name.'</span> <span class="running_order_customer_phone ir_display_none">'.$single_new_order->phone.'</span> </p>  <i class="far fa-chevron-right running_order_right_arrow" id="running_order_right_arrow_'.$single_new_order->sale_id.'"></i>';
    $order_list_left .= '<p>table : <span class="running_order_table_name">'.$tables_booked.'</span></p>';
    $order_list_left .= '<p>waiter: <span class="running_order_waiter_name">'.$single_new_order->waiter_name.'</span></p>';
    $order_list_left .= '<p>Order: <span class="running_order_order_number">'.$order_name.'</span></p>';
    $order_list_left .= '</div>';
    $order_list_left .= '<div class="order_condition">';
    $order_list_left .= '<p class="order_on_processing">Started Cooking: '.$total_kitchen_type_started_cooking_items.'/'.$total_kitchen_type_items.'</p>';
    $order_list_left .= '<p class="order_done">Done: '.$total_kitchen_type_done_items.'/'.$total_kitchen_type_items.'</p>';
    $order_list_left .= '</div>';
    $order_list_left .= '<div class="order_condition">';
    $order_list_left .= '<p class="txt_16">Time Count: <span id="order_minute_count_'.$single_new_order->sale_id.'">'.str_pad(round($minutes), 2, "0", STR_PAD_LEFT).'</span>:<span id="order_second_count_'.$single_new_order->sale_id.'">'.str_pad(round($seconds), 2, "0", STR_PAD_LEFT).'</span> M</p>';
    $order_list_left .= '</div>';
    $order_list_left .= '</div>';
    $order_list_left .= '</div>';
    $i++;
}
/************************************************************************************************************************
 * Construct new orders those are still on processing *******************************************************************
 * **********************************************************************************************************************
 */


/************************************************************************************************************************
 * Construct payment method drop down ***********************************************************************************
 * **********************************************************************************************************************
 */
$payment_method_options = '';

foreach ($data['payment_methods'] as $payment_method){
    $selected = "";
    // $default_payment = $getCompanyInfo->default_payment;
    // if($payment_method->id==$default_payment){
    //     $selected = "selected";
    // }
    $payment_method_options .= '<option '.$selected.' value="'.$payment_method->id.'">'.$payment_method->name.'</option>';
}
/************************************************************************************************************************
 * End of Construct payment method drop down ***********************************************************************************
 * **********************************************************************************************************************
 */


/************************************************************************************************************************
 * Construct notification list ***********************************************************************************
 * **********************************************************************************************************************
 */
$notification_list_show = '';

foreach ($data['notifications'] as $single_notification){
    $notification_list_show .= '<div class="single_row_notification fix" id="single_notification_row_'.$single_notification->id.'">';
    $notification_list_show .= '<div class="fix single_notification_check_box">';
    $notification_list_show .= '<input class="single_notification_checkbox" type="checkbox" id="single_notification_'.$single_notification->id.'" value="'.$single_notification->id.'">';
    $notification_list_show .= '</div>';
    $notification_list_show .= '<div class="fix single_notification">'.$single_notification->notification.'</div>';
    $notification_list_show .= '<div class="fix single_serve_button">';
    $notification_list_show .= '<button class="single_serve_b" id="notification_serve_button_'.$single_notification->id.'">Serve/Take/Delivery</button>';
    $notification_list_show .= '</div>';
    $notification_list_show .= '</div>';
    
}

/************************************************************************************************************************
 * End of Construct notification list ***********************************************************************************
 * **********************************************************************************************************************
 */



?>

<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NexCen POS</title>
<link rel="stylesheet" type="text/css" href="{{url('/resources/assets/pos')}}/assets/POS/css/style.css">
<link rel="stylesheet" type="text/css" href="{{url('/resources/assets/pos')}}/assets/POS/css/style2.css">
<link rel="stylesheet" type="text/css" href="{{url('/resources/assets/pos')}}/assets/POS/css/customModal.css">
<!-- font awesome -->
<link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/POS/css/lib/font_awesomeV5P/css/pro.min.css">
<link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/bower_components/font_awesomeV5P/css/pro.min.css">
<link rel="stylesheet" href="{{url('/resources/assets/pos')}}/asset/plugins/iCheck/minimal/color-scheme.css">
<link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/POS/css/jquery-ui.css">
<!-- For Tooltips -->
<link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/POS/css/lib/tippy/tippy.css">
<link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/POS/css/lib/tippy/scale.css">
<link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/POS/css/lib/tippy/theme_light.css">
<!-- Customer Scrollbar js -->
<link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/POS/css/lib/scrollbar/jquery.scrollbar.css">
<link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/dist/css/common.css">

<link rel="stylesheet" href="{{url('/resources/assets/pos')}}/frequent_changing/css/custom_css.css">

<script src="{{url('/resources/assets/pos')}}/assets/POS/js/jquery-3.3.1.min.js"></script>
<script src="{{url('/resources/assets/pos')}}/assets/POS/js/jquery-ui.js"></script>
<script type="text/javascript" src="{{url('/resources/assets/pos')}}/assets/POS/js/lib/scrollbar/slimScrollbar.js"></script>
<!-- Sweet alert -->
<script src="{{url('/resources/assets/pos')}}/assets/POS/sweetalert2/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/POS/sweetalert2/dist/sweetalert.min.css">
<link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/POS/css/custom_pos.css">
<!--notification for waiter panel-->
<link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/plugins/notify/jquery.notifyBar.css">
<script type="text/javascript"
src="{{url('/resources/assets/pos')}}/assets/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript" src="{{url('/resources/assets/pos')}}/assets/POS/js/calculator.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<base data-base="{{url('/')}}">
</base>
<base data-collect-tax="Yes">
</base>
<base data-currency="">
</base>
@if(Sentinel::getUser()->inRole('fanchise'))
<base data-role="Admin">
</base>
@else
<base data-role="Not-Admin">
</base>
@endif
<base data-collect-gst="Yes">
</base>
<base data-gst-state-code="">
</base>
<!-- Favicon -->
<!--  <link rel="shortcut icon" href="http://localhost/pos/images/favicon.ico" type="image/x-icon"> -->
<link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/POS/css/datepicker.css">
<link rel="stylesheet" href="{{url('/resources/assets/pos')}}/assets/POS/css/animate.min.css">
   <style>
    <?php
       if(Sentinel::getUser()->inRole('waiter')):
 $waiter_app_status = 'Yes';
        else: 
 $waiter_app_status = 'No';
        endif;
    
    $waiter_app_status=isset($waiter_app_status) && $waiter_app_status?$waiter_app_status:'';

    if($waiter_app_status=="Yes"): ?>

    .full-width-for-waiter {
        width: 100% !important;
    }
    .no-need-for-waiter {
        display: none !important;
    }
    <?php endif;
    ?>
    </style>
</head>

<body>
<!--hidden fields for js usages-->
<input type="hidden" id="waiter_app_status" value="<?php echo POS_SettingHelpers::escape_output($waiter_app_status)?>">
<input type="hidden" id="has_kitchen" value="Yes">
<input type="hidden" id="ur_role" value="Admin">
<input type="hidden" id="ir_precision" value="2">
<input type="hidden" id="register_close" value="Register closed successfully">
<input type="hidden" id="warning" value="Alert">
<input type="hidden" id="a_error" value="">
<input type="hidden" id="ok" value="OK">
<input type="hidden" id="cancel" value="Cancel">
<input type="hidden" id="please_select_order_to_proceed"
value="Please select an order to proceed">
<input type="hidden" id="exceeciding_seat" value="Exceeding available sit!!">
<input type="hidden" id="seat_greater_than_zero" value="Seat number must be greater than zero!!!">
<input type="hidden" id="are_you_sure_cancel_booking" value="Are you sure to cancel this booking?">
<input type="hidden" id="are_you_delete_notification" value="Are you sure to delete all notifications?">
<input type="hidden" id="stock_not_available" value="Stock not available!">
<input type="hidden" id="no_notification_select" value="No notification is selected">
<input type="hidden" id="are_you_delete_all_hold_sale" value="Are you sure to delete all draft sales?">
<input type="hidden" id="no_hold" value="There is no draft!">
<input type="hidden" id="sure_delete_this_hold" value="Are you sure to delete this draft?">
<input type="hidden" id="please_select_hold_sale" value="Please select a Draft Sale to proceed!">
<input type="hidden" id="delete_only_for_admin" value="Delete is not allowed for waiter">
<input type="hidden" id="this_item_is_under_cooking_please_contact_with_admin" value="This item is under cooking, Please contact with admin">
<input type="hidden" id="this_item_already_cooked_please_contact_with_admin" value="This item already cooked, Please contact with admin">
<input type="hidden" id="sure_delete_this_order" value="Are you sure to delete this order?">
<input type="hidden" id="sure_remove_this_order" value="Are you sure to remove this order?">
<input type="hidden" id="sure_cancel_this_order" value="Are you sure to cancel this order?">
<input type="hidden" id="please_select_an_order" value="Please select an order to proceed!">
<input type="hidden" id="cart_not_empty" value="Cart is not empty, want to proceed?">
<input type="hidden" id="cart_not_empty_want_to_clear" value="Cart is not empty, want to clear the cart?">
<input type="hidden" id="progress_or_done_kitchen" value="You can not remove or modify any item that is In Progress or Done in Kitchen">
<input type="hidden" id="order_in_progress_or_done" value="Order is In Progress or Done, you can not cancel it!">
<input type="hidden" id="close_order_without" value="You can not close an order without invoicing!">
<input type="hidden" id="want_to_close_order" value="Do you want to close this order?">
<input type="hidden" id="please_select_open_order" value="Please select an Open Order to proceed!">
<input type="hidden" id="cart_empty" value="Cart is empty!">
<input type="hidden" id="select_a_customer" value="Please select A Customer!">
<input type="hidden" id="select_a_waiter" value="Please select A Waiter!">
<input type="hidden" id="delivery_not_possible_walk_in"
value="Delivery is not possible for Walk-in Customer, please choose another!">
<input type="hidden" id="delivery_for_customer_must_address"
value="For Delivery order, customer must has a Delivery Address!">
<input type="hidden" id="select_dine_take_delivery" value="You must select Dine In or Take Away or Delivery!">
<input type="hidden" id="added_running_order" value="Order has been added to Running Orders and went to Kitchen Panel as well. Select any order from Running Orders to modify it or create invoice">
<input type="hidden" id="txt_err_pos_1" value="Edit is not applicable for Walk-in Customer">
<input type="hidden" id="txt_err_pos_2" value="Are you sure to close register?">
<input type="hidden" id="txt_err_pos_3" value="Please open from POS screen">
<input type="hidden" id="txt_err_pos_4" value="There is no invoice">
<input type="hidden" id="txt_err_pos_5" value="Cart is not empty, want to proceed?">
<input type="hidden" id="fullscreen_1" value="Full Screen">
<input type="hidden" id="fullscreen_2" value="Exit Full Screen">
<input type="hidden" id="place_order" value="Place Order">
<input type="hidden" id="update_order" value="Update Order">
<input type="hidden" id="price_txt" value="Price">
<input type="hidden" id="note_txt" value="Note">
<input type="hidden" id="modifiers_txt" value="Modifiers">
<input type="hidden" id="item_add_success" value="Product added successfully in cart!">
<!--Noted-->
<input type="hidden" id="default_customer_hidden" value="1">
<input type="hidden" id="default_waiter_hidden" value="22">
<input type="hidden" id="default_payment_hidden"
value="2">
<!--Noted-->
<input type="hidden" id="selected_invoice_sale_customer" value="">
<input type="hidden" id="saas_m_ch" value="">
<input type="hidden" id="not_closed_yet" value="Not Closed Yet">
<input type="hidden" id="opening_balance" value="Opening Balance">
<input type="hidden" id="paid_amount" value="Paid Amount">
<input type="hidden" id="customer_due_receive" value="Customer Due Receive">
<input type="hidden" id="in_" value="in">
<input type="hidden" id="cash" value="Cash">
<input type="hidden" id="paypal" value="Paypal">
<input type="hidden" id="sale" value="Sale">
<input type="hidden" id="card" value="Card">
<!--   <div class="modalOverlay"></div> -->

<input type="hidden" id="csrf_name_" value="ci_csrf_token">
<input type="hidden" id="csrf_value_" value="{{ csrf_token() }}">
<input type="hidden" name="print_status" id="" value="">
<input type="hidden" name="last_invoice_id" class="last_invoice_id" id="last_invoice_id"
value="">
<input type="hidden" name="last_sale_id" class="last_sale_id" id="last_sale_id" value="">
<input type="hidden" name="last_future_sale_id" class="last_future_sale_id" id="last_future_sale_id" value="">
<input type="hidden" name="print_type" class="print_type" id="print_type" value="">
<input type="hidden" name="print_type_invoice" class="print_type_invoice" id="print_type_invoice" value="web_browser">
<input type="hidden" name="print_type_bill" class="print_type_bill" id="print_type_bill" value="web_browser">
<input type="hidden" name="print_type_kot" class="print_type_kot" id="print_type_kot" value="web_browser">
<input type="hidden" name="print_type_bot" class="print_type_bot" id="print_type_bot" value="web_browser">
<input type="hidden" name="service_type" class="service_type" id="service_type" value="service">
<input type="hidden" name="service_amount" class="service_amount" id="service_amount" value="0%">
<div class="preloader">
<div class="loader">Loading...</div>
</div>

<span id="stop_refresh_for_search" class="ir_display_none">Yes</span>

<div class="wrapper">

<!-- Main Header Part -->
<div class="top_header_part">
<div class="left_item">
<div class="header_part_middle">
    <ul class="icon__menu">
    <li>
   <a href="#" class="brand-link" style="background:white;color: white;">
      <img src="{{url('public/uploads/logo/sklogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" >
      <span class="brand-text font-weight-light">
 
 <?php  

$logo_path=CustomHelpers::logo_path(Sentinel::getUser()->parent_id);

 ?>

    <img src="{{$logo_path}}" alt="Logo" class="brand-image img-circle elevation-3" style="float: none;
    border-radius: 2px;
    max-height: 40px;
    width:70%;
   
   
">

    </span>
    </a>
</li>    
    </ul>
<ul class="icon__menu">
<li class="has__children">
<!-- <a href="#" class="header_menu_icon" data-tippy-content="Main Menu">
<i class="fal fa-user"></i>
</a> -->
<ul class="sub__menu" role="menu">
<li><a
href="http://localhost/pos/Authentication/userProfile">My Profile</a>
</li>
<li><a
href="http://localhost/pos/Authentication/changePassword">Change Password</a>
</li>
<li>
<a
href="http://localhost/pos/Authentication/logOut">Logout</a>
</li>
</ul>
</li>


<li>
<a href="#" id="open_hold_sales" class="header_menu_icon"
data-tippy-content="Open Draft Sales">
<i class="fal fa-folder-open"></i>
</a>
</li>
<li><a href="javascript:void(0)" class="header_menu_icon" id="print_last_invoice"
data-tippy-content="Print Last Invoice"><i
class="fal fa-print"></i></a></li>
<li>
<a href="#" id="last_ten_sales_button" class="header_menu_icon"
data-tippy-content="Recent Sales"><i
class="fal fa-history"></i></a>
</li>
<!-- <li>
<a href="#" id="last_ten_feature_button" class="header_menu_icon"
data-tippy-content="Future Sales"><i
class="fa fa-history"></i></a>
</li> -->
<li>
<a href="#" id="help_button" class="header_menu_icon"
data-tippy-content="Read Before Begin"><i
class="fal fa-question-circle"></i>
</a>
</li>
<li>
<a href="#" id="calculator_button" class="header_menu_icon"
data-tippy-content="Calculator"> <i
class="fal fa-calculator"></i>
</a>
</li>

<li>
<a href="#" id="notification_button" class="header_menu_icon"
data-tippy-content="Kitchen Notification">
<i class="fal fa-bell"></i>
<span id="notification_counter"
                        class="c_badge <?php echo POS_SettingHelpers::escape_output($notification_number)?'':'txt_11'?>"><?php echo POS_SettingHelpers::escape_output($notification_number); ?></span>
</a>
</li>
<!-- <li>
<a href="#" id="register_details" class="header_menu_icon"
data-tippy-content="Register">
<i class="fal fa-registered"></i>
</a>
</li> -->
<li>
<a href="{{url('/Dashboard')}}" class="header_menu_icon"  data-tippy-content="Dashboard">
<i class="fal fa-tachometer-alt-fast"></i>
</a>
</li>




<li><a href="javascript:void(0)" class="time__date"><i class="fal fa-stopwatch"></i></a></li>
<li><a href="javascript:void(0)" id="fullscreen" class="header_menu_icon"
data-tippy-content="Full Screen"><i
class="fal fa-expand-arrows-alt"></i></a></li>
<li>
<!-- <a href="#" data-tippy-content="Main Menu" id="open__menu"
class="header_menu_icon">
<i class="fal fa-align-justify"></i>
</a> -->
</li>
</ul>
</div>
</div>

<!-- Right Header Menu List -->
<div class="header_part_right">
<ul class="btn__menu">
<li>
<a href="#" id="button_category_show_all1" class="bg__blue">All</a>
</li>
<li class="has__children">
<a href="#" class="show__cat__list bg__purple">Category</a>
 <ul class="sub__menu">
                            <!--This variable could not be escaped because this is html content-->
                            <?php echo $cateogry_slide_to_show?>
                        </ul>
</li>

<li><a href="#" data-status="veg"
class="veg_bev_item bg__green">Veg Items</a></li>
 <li><a href="#" data-status="nonveg"
class="veg_bev_item bg__khoyre">Non-Veg Items</a></li>
<li><a href="#" data-status="bev"
class="veg_bev_item bg__grey">Beverage Items</a></li>

</ul>
</div>
</div>
<div class="top_header_for_mobile">
<button type="button" data-isActive="false" id="show_running_order" class="bg__red">
<i class="far fa-bags-shopping"></i> <span>Running Order</span></button>
<button type="button" id="show_cart_list" class="bg__purple">
<i class="far fa-list-alt"></i> <span>Cart</span></button>
<button type="button" id="show_product" class="bg__grey">
<i class="far fa-th"></i> <span>Products</span></button>
<button type="button" id="show_all_menu" class="bg__green">
<i class="fal fa-bars"></i> <span>Others</span></button>
</div>
 <div class="top_scroller" style="height:0px;">   </div>
<div id="main_part">
<div class="left_item">
<div class="main_left">
<div class="holder">
<div id="running_order_header">
<h3>Running Orders</h3>
<span id="refresh_order"><i class="fas fa-sync-alt"></i></span>
<input type="text" name="search_running_orders" id="search_running_orders"
autocomplete='off' class="ir_h15_m_w90"
placeholder="Table, Order Number, Waiter, Customer" />
</div>

<div class="order_details scrollbar-macosx" id="order_details_holder">
<!--This variable could not be escaped because this is html content-->
  <?php echo $order_list_left; ?>                      


 </div>
<div class="ir_pa_b_w100" id="left_side_button_holder_absolute">
<button class="operation_button" id="modify_order"><i
class="fas fa-edit"></i>Modify Order</button>
<button class="operation_button fix" id="single_order_details"><i
class="fas fa-info-circle"></i> Order Details</button>

<button class="operation_button fix" id="print_kot" data-tippy-content="Print KOT"><i class="fas fa-print"></i> KOT</button>

<!-- <div class="ir_flex_jc_pw94">
<button class="ir_calc_w98 no-need-for-waiter operation_button fix btn_tip"
id="print_kot"
data-tippy-content="Print KOT">
<i class="fas fa-print"></i> KOT                                </button>

<button class="operation_button no-need-for-waiter ir_calc_w98_m5 btn_tip"
id="print_bot"
data-tippy-content="Print BOT">
<i class="fas fa-print"></i> BOT                                </button>

</div> -->


<div class="ir_flex_jc_w94_pr">
<button class="ir_calc_w98 operation_button no-need-for-waiter fix"
id="create_invoice_and_close">
Invoice                                </button>
<button
class="operation_button fix ir_calc_w98_m5 no-need-for-waiter btn_tip full-width-for-waiter"
id="create_bill_and_close"
data-tippy-content="Print Bill for Customer Before Invoicing">
Bill                                </button>

</div>





<button class="operation_button no-need-for-waiter fix" id="cancel_order_button"><i
class="fas fa-ban"></i>
Cancel Order</button>

<button class="operation_button fix" id="kitchen_status_button"><i
class="fas fa-spinner"></i>
Kitchen Status</button>
</div>

</div>
</div>
<div class="main_middle">
<div class="main_top fix">
<!-- Top Btns -->
<div class="button_holder no-need-for-waiter">

<button class="selected__btn_c"
data-selected=""
id="dine_in_button">
<i class="fal fa-table"></i> Dine In                            </button>

<button class="selected__btn_c" id="take_away_button"><i class="fal fa-shopping-bag"></i>
Take Away</button>

<button class="selected__btn_c" id="delivery_button"><i class="fal fa-truck"></i>
Delivery</button>

<button id="table_button"><i class="fal fa-table"></i> Table</button>

</div>

<div class="waiter_customer">
<div class="left_item">
<select id="select_waiter" class="select2 select_waiter ir_w92_ml">
<option value="">Waiter</option>
<!--This variable could not be escaped because this is html content-->
 <?php echo $waiters_option; ?>                              
  </select>
<select id="walk_in_customer" id="select_walk_in_customer" class="select2">
<option value="">Customer</option>
<!--This variable could not be escaped because this is html content-->

  <?php echo $customers_option; ?>                                
</select>
</div>
<div class="separator">
<a href="#" data-tippy-content="Edit Customer"
class="header_menu_icon" id="edit_customer">
<i class="far fa-pencil-alt"></i>
</a>

<a href="#" id="plus_button" class="header_menu_icon"
data-tippy-content="Add Customer">
<i class="fal fa-plus"></i>
</a>
</div>
</div>
</div>

<div class="main_center fix">
<div class="order_table_holder">
<div class="order_table_header_row">
<div class="single_header_column" id="single_order_item">Item                                </div>
<div class="single_header_column" id="single_order_price">Price                                </div>
<div class="single_header_column" id="single_order_qty">Qty</div>
<div class="single_header_column" id="single_order_discount">
Discount</div>
<div class="single_header_column" id="single_order_total">Total                                </div>
</div>
<div class="order_holder fix cardIsEmpty">

</div>
</div>

</div>
<div id="bottom_absolute">
<div class="bottom__info">
<div class="footer__content">
<div class="item">
<input type="hidden" id="open_invoice_date_hidden"
value="<?php echo date("Y-m-d",strtotime('today')) ?>">
<div>Total Item: <span
id="total_items_in_cart_with_quantity">0</span>
<!-- <i data-tippy-content="Invoice Date"
class="no-need-for-waiter fal fa-calendar-alt input-group date datepicker_custom calendar_irp"
id="open_date_picker"></i> -->
</div>
<span id="total_items_in_cart" class="ir_display_none">0</span>
</div>
<div class="item">
<span>Sub Total:</span>
<span id="sub_total_show"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
<span id="sub_total" class="ir_display_none"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
<span id="total_item_discount" class="ir_display_none">0</span>
<span id="discounted_sub_total_amount"
class="ir_display_none"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</div>
<div class="item no-need-for-waiter">
<span>
Discount: <i class="fal fa-edit"
id="open_discount_modal"></i> <span
id="show_discount_amount"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</span>
</div>
<div class="item">
<span>Discount:</span>
<span id="all_items_discount"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</div>
<div class="item">
<span>Tax:</span>
<i class="fal fa-eye no-need-for-waiter" id="open_tax_modal"></i>
<span id="show_vat_modal"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</div>
<div class="item">
<span>Charge: <i
class="fal fa-edit no-need-for-waiter" id="open_charge_modal"></i> <span
id="show_charge_amount"><?php echo POS_SettingHelpers::getAmtP(0)?></span></span>

</div>

</div>
<div class="payable">
<h1>Total Payable: <span
id="total_payable"><?php echo POS_SettingHelpers::getAmtP(0)?></span></h1>
</div>
<div class="main_bottom">
<div class="button_group">

<button id="cancel_button"><i class="fas fa-times"></i>
Cancel</button>


<button id="hold_sale"><i class="fas fa-hand-rock"></i>
Draft</button>


<button id="direct_invoice" class="no-need-for-waiter"><i
class="fas fa-file-invoice"></i>
<span
id="place_edit_order_direct_invoice">Quick Invoice</span></button>


<button class="placeOrderSound" id="place_order_operation"><i
class="fas fa-utensils"></i> <span
id="place_edit_order">Place Order</span></button>

</div>
</div>
</div>

</div>
</div>
</div>
<div class="main_right">
<form autocomplete="off">
<input type="text" name="search" id="search"
placeholder="Name or Code or Category or VEG or BEV or BAR" />
</form>

<div class="ir_pos_relative" id="main_item_holder">
<div class="category-list scrollbar-macosx">
<ul class="list-of-item">
<li>
<a href="#" id="button_category_show_all1">All</a>
</li>
<!--This variable could not be escaped because this is html content-->
 <?php echo $cateogry_slide_to_show?>

                        
</ul>
</div>

<div class="scrollbar-macosx" id="secondary_item_holder">
<div class="category_items">
<!--This variable could not be escaped because this is html content-->
 <?php


  echo $menu_to_show; ?>
</div>
</div>


</div>
</div>
</div>
<!-- Responsive mobile menu -->
<div class="all__menus">
<ul class="menu__list">
<div>
<li>
<a href="#" id="notification_button">
<i class="fal fa-bell"></i> Kitchen Notification   <span id="notification_counter"
                            class="c_badge <?php echo POS_SettingHelpers::escape_output($notification_number)?'':'txt_11'?>"><?php echo POS_SettingHelpers::escape_output($notification_number);?></span>
</a>
</li>
<li>
<a href="#" id="button_category_show_all1">
<i class="fal fa-border-all"></i> All </a>
</li>
<li class="it_has_children">
<a href="#" class="show__cat__list">Category</a>
<ul class="sub_menu category__list">
<!--This variable could not be escaped because this is html content-->
 <?php echo $cateogry_slide_to_show?>                  

 </ul>
</li>
<li><a href="#" data-status="veg" class="veg_bev_item">Veg Items</a></li>
<li><a href="#" data-status="nonveg" class="veg_bev_item">Non-Veg Items</a></li>
<li><a href="#" data-status="bev" class="veg_bev_item">Beverage Items</a></li>

<!-- <li><a href="#" data-status="bar" class="veg_bev_item">Bar Items</a></li> -->
<li>
<a href="#" id="open_hold_sales">
<i class="fal fa-folder-open"></i> Open Draft Sales    </a>
</li>
<li>
<a href="#" id="last_ten_sales_button">
<i class="fal fa-history"></i> Recent Sales                    </a>
</li>
<!-- <li class="it_has_children">
<a href="#">
<i class="fal fa-globe"></i> Language                    </a>
<ul class="sub_menu" role="menu">
<li class=""><a
href="http://localhost/pos/Authentication/setlanguagePOS/arabic">Arabic</a>
</li>                         <li class="active_lng"><a
href="http://localhost/pos/Authentication/setlanguagePOS/english">English</a>
</li>                         <li class=""><a
href="http://localhost/pos/Authentication/setlanguagePOS/french">French</a>
</li>                         <li class=""><a
href="http://localhost/pos/Authentication/setlanguagePOS/spanish">Spanish</a>
</li>                     </ul>
</li> -->

</div>
<!-- End Single Menu Column -->
<div>
<li class="it_has_children no-need-for-waiter">
<a href="#">
<i class="fal fa-user"></i> Main Menu                    </a>
<ul class="sub_menu" role="menu">
<li>
<a href="http://localhost/pos/Authentication/userProfile">
My Profile</a>
</li>
<li>
<a href="http://localhost/pos/Authentication/changePassword">
Change Password</a>
</li>
<li>
<a href="http://localhost/pos/Authentication/logOut">Logout</a>
</li>
</ul>
</li>
<li class="no-need-for-waiter">
<a href="javascript:void(0)" id="print_last_invoice">
<i class="fal fa-print"></i> Print Last Invoice</a>
</li>

<!-- <li class="no-need-for-waiter">
<a href="#" id="last_ten_feature_button">
<i class="fal fa-history"></i> Future Sales                    </a>
</li> -->
<li class="no-need-for-waiter">
<a href="#" id="help_button">
<i class="fal fa-question-circle"></i> Read Before Begin                    </a>
</li>
<li class="no-need-for-waiter">
<a href="#" id="calculator_button">
<i class="fal fa-calculator"></i> Calculator                    </a>
</li>

<!-- <li class="no-need-for-waiter">
<a href="#" id="register_close">
<i class="fal fa-registered"></i> Register                    </a>
</li> -->
<li class="no-need-for-waiter">
<a href="{{url('/Dashboard')}}">
<i class="fal fa-tachometer-alt-fast"></i> Dashboard                    </a>
</li>
</div>
</ul>
</div>

<div class="overlayForCalculator"></div>
<!-- The Modal -->
<div class="pos__modal__overlay"></div>

<!-- Open Discount Modal -->
<div id="discount_modal" class="modal">
<!-- Modal content -->
<div class="modal-content">

<h1 id="modal_item_name">Discount                <a href="javascript:void(0)" class="alertCloseIcon">
<i class="fal fa-times"></i>
</a>
</h1>
<div class="main-content-wrapper">
<div>
<label for="discount_val">Value</label>

<input type="hidden" class="special_textbox" placeholder="Value"
id="sub_total_discount" />

<input type="text" class="special_textbox integerchk" placeholder="Value"
id="sub_total_discount1" />

<span class="ir_display_none" id="sub_total_discount_amount"></span>
</div>
<div>
<label for="discount_type">Type</label>
<select class="select2" id="discount_type" name="discount_type">
<!-- <option value="fixed">Fixed</option> -->
<option value="percentage">Percentage</option>
</select>
</div>
</div>
<div class="btn__box">
<button type="button" id="submit_discount_custom" class="submit">Submit</button>
<button type="button" id="cancel_discount_modal" class="cancel">Cancel</button>
</div>
</div>
</div>

<!-- Open Service Charge Modal -->
<div id="charge_modal" class="modal">
<!-- Modal content -->
<div class="modal-content">

<h1 id="modal_item_name">Charge    <a href="javascript:void(0)" class="alertCloseIcon">
<i class="fal fa-times"></i>
</a>
</h1>
<div class="main-content-wrapper">
<div>
<label for="charge_type">Type</label>
<select id="charge_type" class="select2">
<option  value="delivery">Delivery</option>
<option selected value="service">Service</option>
</select>
</div>
<div>
<label for="charge_amount">Amount</label>
<input type="text" name="" autocomplete="off" class="special_textbox " onfocus="select();"
placeholder="Amount" value="0%" id="delivery_charge" />
</div>
</div>
<div class="btn__box">
<button type="button" class="submit">Submit</button>
<button type="button" class="cancel" id="cancel_charge_value">Cancel</button>
</div>
</div>
</div>


<!-- Open Service Charge Modal -->
<div id="tax_modal" class="modal">
<!-- Modal content -->
<div class="modal-content">

<h1 id="modal_item_name">Tax Details  <a href="javascript:void(0)" class="alertCloseIcon">
<i class="fal fa-times"></i>
</a>
</h1>
<div class="main-content-wrapper">
<div class="content">
<table class="tax-modal-table">
<thead>
<tr>
<th>Tax Name</th>
<th>Value</th>
</tr>
</thead>
<tbody id="tax_row_show">

</tbody>
</table>
</div>
</div>
<div class="btn__box">
<button type="button" class="cancel">Cancel</button>
</div>
</div>
</div>


<div id="item_modal" class="modal">

<!-- Modal content -->
<div class="modal-content">
<span id="modal_item_row" class="ir_display_none">0</span>
<span id="modal_item_id" class="ir_display_none"></span>
<span id="modal_item_price" class="ir_display_none"></span>
<span id="modal_item_vat_percentage" class="ir_display_none"></span>
<h1> <span id="item_name_modal_custom">Item Name</span>
<a href="javascript:void(0)" class="alertCloseIcon">
<i class="fal fa-times"></i>
</a>
</h1>
<div class="ir_mrx5">
<div class="section1 fix">
<div class="sec1_inside" id="sec1_1">Quantity</div>
<div class="sec1_inside" id="sec1_2"><i class="fal fa-minus" id="decrease_item_modal"></i>
<span id="item_quantity_modal">1</span> <i class="fal fa-plus" id="increase_item_modal"></i>
</div>
<div class="sec1_inside" id="sec1_3"> <span id="modal_item_price_variable"
class="ir_display_none">0</span><span
id="modal_item_price_variable_without_discount">0</span><span id="modal_discount_amount"
class="ir_display_none">0</span></div>
</div>
<div class="section2 fix">
<div class="sec2_inside" id="sec2_1">Modifiers</div>
<div class="sec2_inside" id="sec2_2"> <span id="modal_modifier_price_variable">0</span>
<span id="modal_modifiers_unit_price_variable" class="ir_display_none">0</span>
</div>
</div>

<div class="section3 fix">
<div class="modal_modifiers">
<p>Cool Haus 2</p>
</div>
<div class="modal_modifiers">
<p>First Scoo</p>
</div>
<div class="modal_modifiers">
<p>Mg</p>
</div>
<div class="modal_modifiers">
<p>Modifier</p>
</div>
<div class="modal_modifiers">
<p>Cool Haus 2</p>
</div>
<div class="modal_modifiers">
<p>First Scoo 2</p>
</div>
<div class="modal_modifiers">
<p></p>
</div>
<div class="modal_modifiers">
<p>Modifier</p>
</div>
</div>

<div id="modal_discount_section">
<p class="ir_fl_m_font_16" id="discount_txt_focus">Discount <i
data-tippy-content="1. Enter number for fixed discount eg: 10 <br> 2. Enter a percentage sign after the number in case of percentage discount eg: 10%"
class="fal fa-question-circle tooltip_modifier"></i></p><input type="text" name=""
onfocus="select();"
id="modal_discount" placeholder="Amt or %" />
</div>
<div class="section4 fix">Total&nbsp;&nbsp;&nbsp;
<span id="modal_total_price">0</span>
</div>
</div>
<div class="section6 fix">
<div class="section5">Note:</div>
<textarea name="item_note" id="modal_item_note" maxlength="50"></textarea>
</div>
<div class="section7">
<div class="sec7_inside" id="sec7_2"><button
id="add_to_cart">Update in Cart</button></div>
<div class="sec7_inside" id="sec7_1"><button
id="close_item_modal">Cancel</button></div>
</div>

<!-- <span class="btn-close">&times;</span> -->
<!-- <p>Some text in the Modal..</p> -->
</div>

</div>

<!-- The Modal -->
<div id="add_customer_modal" class="modal">

<!-- Modal content -->
<div class="modal-content" id="editCustomer1">
<h1>
Add Customer                <a href="javascript:void(0)" class="alertCloseIcon">
<i class="fal fa-times"></i>
</a>
</h1>

<div class="customer_add_modal_info_holder">
<div class="content">

<div class="left-item b">
<input type="hidden" id="customer_id_modal" value="">
<div class="customer_section">
<p class="input_level">Name <span class="ir_color_red">*</span></p>
<input type="text" class="add_customer_modal_input" id="customer_name_modal" required>
</div>
<div class="customer_section">
<p class="input_level">
Phone                                <span class="ir_color_red">*</span>
<small>Should have country code</small>
</p>

<input type="text" class="add_customer_modal_input" id="customer_phone_modal" required>
</div>
<div class="customer_section">
<p class="input_level">Email</p>
<input type="email" class="add_customer_modal_input" id="customer_email_modal">
</div>
</div>

<div class="right-item b">
<div class="customer_section">
<p class="input_level">Date Of Birth</p>
<input type="datable" class="add_customer_modal_input" autocomplete="off"
id="customer_dob_modal" data-datable="yyyymmdd" data-datable-divider=" - ">
</div>
<div class="customer_section">
<p class="input_level">Date Of Anniversary</p>
<input type="datable" class="add_customer_modal_input" autocomplete="off"
id="customer_doa_modal" data-datable="yyyymmdd" data-datable-divider=" - ">
</div>

<div class="customer_section">
<p class="input_level">GST Number</p>
<input type="text" class="add_customer_modal_input" id="customer_gst_number_modal">

</div>
</div>
</div>

<div class="customer_section">
<p class="input_level">Delivery Address</p>
<textarea id="customer_delivery_address_modal"></textarea>
</div>
</div>

<div class="section7">
<div class="sec7_inside" id="sec7_2"><button id="add_customer">Submit</button>
</div>
<div class="sec7_inside" id="sec7_1"><button
id="close_add_customer_modal">Cancel</button></div>
</div>
<!-- <span class="btn-close">&times;</span> -->
<!-- <p>Some text in the Modal..</p> -->
</div>

</div>
<!-- The Modal -->
<div id="show_tables_modal2" class="modal display_none">

<!-- Modal content -->
<div class="modal-content" id="modal_content_show_tables2">
<h1 class="ir_pos_relative">
Tables                <a href="javascript:void(0)" class="alertCloseIcon" id="table_modal_cancel_button2">
<i class="fal fa-times"></i>
</a>
</h1>
<p id="new_or_order_number_table">Order Number: <span
id="order_number_or_new_text">New</span></p>
    <div class="select_table_modal_info_holder2 scrollbar-macosx">
                <!--This variable could not be escaped because this is html content-->
                <?php echo $tables_modal;?>
            </div>


<div class="bottom_button_holder_table_modal">
<div class="left half">
<button id="please_read_table_modal_button"><i class="fas fa-question-circle"></i>
Please Read</button>
</div>
<div class="right half">
<button class="floatright" id="submit_table_modal">Submit</button>
<button class="floatright"
id="proceed_without_table_button">Proceed without Table</button>
<button class="floatright" id="table_modal_cancel_button">Cancel</button>
</div>
</div>
<!-- <span class="btn-close">&times;</span> -->
<!-- <p>Some text in the Modal..</p> -->
</div>

</div>
<!-- end add customer modal -->

<!-- The sale hold modal -->
<div id="show_sale_hold_modal" class="modal">
<div class="modal-content" id="modal_content_hold_sales">
<h1 class="main_header fix">Draft Sale <a href="javascript:void(0)"
class="alertCloseIcon">
<i class="fal fa-times"></i>
</a></h1>
<div class="hold_sale_modal_info_holder">
<div class="btn__box">
<button type="button" class="bg__red" data-selectedBtn="unselected"
id="sale_hold_modal_order_details">Order Details</button>
<button type="button" class="bg__green" data-selectedBtn="selected"
id="sale_hold_modal_order_list">Order List</button>
</div>
<div class="detail_hold_sale_holder">
<div id="sale_hold_modal_order_info_list" class="hold_sale_left">
<label>
<input type="text" id="search_hold_sale"
placeholder="Search Customer Name or Mobile Number">
<button><i class="far fa-search"></i></button>
</label>
<div class="hold_list_holder">
<div class="header_row">
<div class="first_column column">Number</div>
<div class="second_column column">Customer                                    (Phone)</div>
<div class="third_column column">Table</div>
</div>
<div class="scrollbar-macosx">
<div class="detail_holder draft-sale">

</div>
</div>
<div class="delete_all_hold_sales_container">
<button
id="delete_all_hold_sales_button">Delete all Draft Sales</button>
</div>
</div>
</div>
<div id="sale_hold_modal_order_details_list" class="hold_sale_right">
<div class="top fix">
<div class="top_middle fix">
<h1>Order Details</h1>
<div class="waiter_customer_table fix">
<div class="fix order_type"><span
class="ir_font_bold">Order Type: </span><span
id="hold_order_type"></span><span id="hold_order_type_id"
class="ir_display_none"></span></div>
</div>
<div class="waiter_customer_table fix">
<div class="waiter fix"><span class="ir_font_bold">Waiter:
</span><span class="ir_display_none" id="hold_waiter_id"></span><span
id="hold_waiter_name"></span></div>
<div class="customer fix"><span
class="ir_font_bold">Customer: </span><span
class="ir_display_none" id="hold_customer_id"></span><span
id="hold_customer_name"></span></div>
<div class="table fix"><span class="ir_font_bold">Table:
</span><span class="ir_display_none" id="hold_table_id"></span><span
id="hold_table_name"></span></div>
</div>
<div class="item_modifier_details">
<div class="modifier_item_header fix">
<div class="first_column_header column_hold fix">Item </div>
<div class="second_column_header column_hold fix">Price</div>
<div class="third_column_header column_hold fix">Qty    </div>
<div class="forth_column_header column_hold fix">Disc    </div>
<div class="fifth_column_header column_hold fix">Total    </div>
</div>
<div class="scrollbar-macosx">
<div class="modifier_item_details_holder">
</div>
</div>
<div class="bottom_total_calculation_hold">
<div class="single_row first">
<div class="item">
<span>Total Item: </span>
<span id="total_items_in_cart_hold">0</span>
</div>
<div class="item">
<span>Sub Total: </span>
<span id="sub_total_show_hold"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
<span id="sub_total_hold"
class="ir_display_none"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
<span id="total_item_discount_hold"
class="ir_display_none"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
<span id="discounted_sub_total_amount_hold"
class="ir_display_none"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</div>
<div class="item">
<span>Discount: </span>
<span>
<span id="sub_total_discount_hold"><?php echo POS_SettingHelpers::getAmtP(0)?></span><span
id="sub_total_discount_amount_hold"
class="ir_display_none"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</span>
</div>
</div>
<div class="single_row third">

</div>
<div class="single_row forth">
<div class="item">
<span>Total Discount: </span>
<span id="all_items_discount_hold"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</div>
<div class="item">
<span>Tax: </span>
<span id="all_items_vat_hold"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</div>
<div class="item">
<span>Charge: </span>
<span id="delivery_charge_hold"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</div>
</div>
</div>
<h1 class="modal_payable">
<span>Total Payable: </span>
<span id="total_payable_hold"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</h1>
</div>
</div>
</div>
<div class="bottom">
<div class="button_holder">
<div class="single_button_holder">
<button id="hold_edit_in_cart_button">Edit in Cart</button>
</div>
<div class="single_button_holder">
<button id="hold_delete_button">Delete</button>
</div>
<div class="single_button_holder">
<button id="hold_sales_close_button">Cancel</button>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

</div>
<!-- end sale hold modal -->

<!-- The sale hold modal -->
<div id="show_last_ten_sales_modal" class="modal">

<!-- Modal content -->
<div class="modal-content" id="modal_content_last_ten_sales">
<h1 class="main_header fix">Recent Sales  <a href="javascript:void(0)" class="alertCloseIcon">
<i class="fal fa-times"></i>
</a>
</h1>
<div class="last_ten_sales_modal_info_holder fix">
<div class="btn_box">
<button type="button" id="recent_sales_order_details" data-selectedBtn="unselected"
class="bg__red">Order Details</button>
<button type="button" id="recent_sales_order_list" data-selectedBtn="selected"
class="bg__green">Order List</button>
</div>
<div class="last_ten_sales_holder">

<div id="recent_sales_order_info_list" class="hold_sale_left">
<label>
<input type="text" id="search_sales_custom_modal"
placeholder="Search Customer Name or Mobile Number">
<button><i class="far fa-search"></i></button>
</label>
<div class="hold_list_holder">
<div class="header_row">
<div class="first_column column">Sale No</div>
<div class="second_column column">Customer (Phone)</div>
<div class="third_column column">Table</div>
</div>
<div class="scrollbar-macosx">
<div class="detail_holder recent-sales">

</div>
</div>
</div>
</div>
<div id="recent_sales_order_details_list" class="hold_sale_right">
<div class="top fix">
<div class="top_middle fix">
<h1>Order Details</h1>
<div class="waiter_customer_table fix">
<div class="fix order_type">
<span class="ir_font_bold">Order Type: </span>
<span id="last_10_order_type" class="ir_w_d_ib">&nbsp;</span>
<span id="last_10_order_type_id" class="ir_display_none"></span>
<span class="ir_font_bold">Invoice No: </span>
<span id="last_10_order_invoice_no"></span>
</div>
</div>
<div class="waiter_customer_table fix">
<div class="waiter fix"><span class="ir_font_bold">Waiter:
</span><span class="ir_display_none" id="last_10_waiter_id"></span><span
id="last_10_waiter_name"></span></div>
<div class="customer fix"><span
class="ir_font_bold">Customer: </span><span
class="ir_display_none" id="last_10_customer_id"></span><span
id="last_10_customer_name"></span></div>
<div class="table fix"><span class="ir_font_bold">Table:
</span><span class="ir_display_none" id="last_10_table_id"></span><span
id="last_10_table_name"></span></div>
</div>
<div class="item_modifier_details fix">
<div class="modifier_item_header fix">
<div class="first_column_header column_hold fix">Item   </div>
<div class="second_column_header column_hold fix">Price  </div>
<div class="third_column_header column_hold fix">Qty      </div>
<div class="forth_column_header column_hold fix">Disc     </div>
<div class="fifth_column_header column_hold fix">Total    </div>
</div>
<div class="scrollbar-macosx">
<div class="modifier_item_details_holder">
</div>
</div>
<div class="bottom_total_calculation_hold">
<div class="single_row first">
<div class="item">
Total Item:
<span id="total_items_in_cart_last_10">0</span>
</div>
<div class="item">
<span>Sub Total: </span>
<span id="sub_total_show_last_10"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
<span id="sub_total_last_10"
class="ir_display_none"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
<span id="total_item_discount_last_10"
class="ir_display_none"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
<span id="discounted_sub_total_amount_last_10"
class="ir_display_none"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</div>
<div class="item">
<span>Discount :</span>
<span id="sub_total_discount_last_10"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
<span id="sub_total_discount_amount_last_10"
class="ir_display_none"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</div>
</div>

<div class="single_row third">

</div>
<div class="single_row forth">
<div class="item">
Total Discount : <span
id="all_items_discount_last_10"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</div>
<div class="item">
Tax:
<span id="recent_sale_modal_details_vat"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</div>
<div class="item">
Charge:
<span id="delivery_charge_last_10"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</div>
</div>

</div>
<h1 class="modal_payable">
Total Payable: <span
id="total_payable_last_10"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</h1>
</div>
</div>
</div>
<div class="bottom">
<div class="button_holder">
<div class="single_button_holder">
<button class="no-need-for-waiter"
id="last_ten_print_invoice_button">Print Invoice</button>
</div>
<div class="single_button_holder">
<button id="last_ten_delete_button"
class="ir_font_capitalize no-need-for-waiter">Delete</button>
</div>
<div class="single_button_holder">
<button id="last_ten_sales_close_button">Cancel</button>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

</div>
<!-- end sale hold modal -->

<!-- The sale hold modal -->
<div id="generate_sale_hold_modal" class="modal">

<!-- Modal content -->
<div class="modal-content" id="modal_content_generate_hold_sales">
<h1>Draft</h1>
<div class="generate_hold_sale_modal_info_holder fix">
<p class="ir_m_zero_b">Number <span class="ir_color_red">*</span>
</p>
<input type="text" name="" id="hold_generate_input">
</div>
<div class="section7 fix">
<div class="sec7_inside" id="sec7_1"><button id="hold_cart_info">Submit</button>
</div>
<div class="sec7_inside" id="sec7_2"><button
id="close_hold_modal">Cancel</button></div>
</div>
</div>

</div>


<div id="bill_modal" class="modal">
<!-- Modal content -->
<div class="modal-content" id="editCustomer1">
<h1>
Bill Details <a href="javascript:void(0)" class="alertCloseIcon">
<i class="fal fa-times"></i>
</a>
</h1>

<div class="main-content show_bill_modal_content">
<header>
<?php  

$logo_path=CustomHelpers::logo_path(Sentinel::getUser()->parent_id);

 ?>
<img src="{{ $logo_path }}" />
<h3 class="title">Skyland</h3>

<p>Bill No: <span id="b_bill_no"></span></p>
</header>
<ul class="simple-content">
<li>Date: <span id="b_bill_date"></span></li>
<li>Sales Associate: <span id="b_bill_creator"></span></li>
<li>Customer: <b><span id="b_bill_customer"></span></b></li>
</ul>
<ul class="main-content-list">
<li>
<span># 1: Better Chocolate Chip Cookies (09) 1 X 330.000</span>
<span>330.000$</span>
</li>
<li>
<span><b>Total Item(s): <span id="b_bill_total_item"></span></b></span>
<span></span>
</li>
<li>
<span>Sub Total</span>
<span><b><span id="b_bill_subtotal"></span></b></span>
</li>
<li>
<span>Grand Total</span>
<span><b><span id="b_bill_gtotal"></span></b></span>
</li>
<li>
<span>Total Payable</span>
<span><span id="b_bill_total_payable"></span></span>
</li>
</ul>
</div>
</div>

</div>

<div class="cus_pos_modal" id="register_modal">
<header class="pos__modal__header">
<h3 class="pos__modal__title">Register Details <span
id="opening_closing_register_time">(<span id="opening_register_time"></span>
to <span id="closing_register_time"></span>)</span></h3>

<a href="javascript:void(0)" class="pos__modal__close"><i class="fal fa-times"></i></a>
</header>

<div class="pos__modal__body">
<div class="default_inner_body" id="register_details_content">

</div>
</div>
<footer class="pos__modal__footer">
<div class="right_box">
<button type="button" id="register_close">Close Register</button>
<button type="button" class="modal_hide">Cancel</button>
</div>
</footer>
</div>

<div class="cus_pos_modal cus_pos_modal_feature_sale_modal" id="customModal">
<header class="pos__modal__header">
<h3 class="pos__modal__title">Future Sales</h3>
<a href="javascript:void(0)" class="pos__modal__close"><i class="fal fa-times"></i></a>
</header>
<div class="pos__modal__body">
<div class="default_inner_body">
<div class="hold_sale">
<div class="left_item">
<label class="search__item">
<input type="text" id="search_future_custom_modal"
placeholder="Search Customer Name or Mobile Number">
<button><i class="far fa-search"></i></button>
</label>
<div class="scrollbar-macosx position_future_sale_irp">
<div class="left_item_list_wrapper">
<div class="itemList">
<div class="itemHeader">
<div class="item">Sale No</div>
<div class="item">
Customer (Phone)
</div>
<div class="item">Date</div>
</div>
<div class="detail_holder">

</div>
</div>
</div>
</div>
</div>

<div class="right_item">
<h3 class="title">Order Details</h3>
<div class="waiter_customer_table">
<div class="fix order_type"><span class="ir_font_bold">Order Type:
</span><span id="last_10_order_type_"></span>
</div>
</div>
<div class="waiter_customer_table multiItem">
<div class="waiter"><span class="ir_font_bold">Waiter: </span><span
id="last_10_waiter_name_"></span></div>
<div class="customer"><span class="ir_font_bold">Customer:
</span><span id="last_10_customer_name_"></span></div>
<div class="table">
<span class="ir_font_bold">Table:</span><span
id="last_10_table_name_"></span>
</div>
</div>
<div class="item_order_details">
<header>
<div>Item</div>
<div>Price</div>
<div>Qty</div>
<div>Discount</div>
<div>Total</div>
</header>

<div class="scrollbar-macosx">
<div class="modifier_item_details_holder">

</div>
</div>

</div>


<div class="footer__details">

<div class="txt__subtotal">
<span class="total__item">Total Item: <span
class="total_items_in_cart_last_10_">0</span></span>
<p class="txt"> Total Discount: <span
class="all_items_discount_last_10_"><?php echo POS_SettingHelpers::getAmtP(0)?></span></p>
</div>
<div class="txt__subtotal">
<span>Sub Total: <span
class="sub_total_show_last_10_"><?php echo POS_SettingHelpers::getAmtP(0)?></span></span>

<p class="txt">Tax: <span
class="recent_sale_modal_details_vat_"><?php echo POS_SettingHelpers::getAmtP(0)?></span></p>
</div>
<div class="txt__subtotal">
<span class="discount">Discount: <span
class="sub_total_discount_last_10_"><?php echo POS_SettingHelpers::getAmtP(0)?></span></span>
<p class="txt">Charge: <span
class="delivery_charge_last_10_"><?php echo POS_SettingHelpers::getAmtP(0)?></span></p>
</div>
</div>
<h3 class="payable">
<span class="c-flex">Total Payable:</span>
<span class="total_payable_last_10_"><?php echo POS_SettingHelpers::getAmtP(0)?></span></h3>
</div>
</div>
</div>
</div>
<footer class="pos__modal__footer">
<div class="left_box">
&nbsp;
</div>
<div class="right_box">
<button type="button" id="draft_edit_modal">Modify Order</button>
<button type="button" id="draft_edit_modal_invoice">Set as Running Order</button>
<button type="button" class="modal_hide">Cancel</button>
</div>
</footer>
</div>

<!-- end add customer modal -->
<!-- The order details modal -->
<div id="order_detail_modal" class="modal">

<!-- Modal content -->
<div class="modal-content" id="modal_content_sale_details">
<h1 class="order_detail_title">
Order Details                <a href="javascript:void(0)" class="alertCloseIcon" id="order_details_close_button2"><i
class="fal fa-times"></i></a>
</h1>
<div class="order_detail_modal_info_holder fix">
<div class="top fix">
<div class="top_middle fix">
<div class="waiter_customer_table fix">
<div class="fix order_type">
<span class="ir_font_bold">Order Type: </span>
<span id="order_details_type" class="ir_d_block_w229"></span>
<span id="order_details_type_id" class="ir_display_none"></span>
<span class="ir_font_bold">Order Number: </span>
<span id="order_details_order_number"></span>
</div>
</div>
<div class="waiter_customer_table fix">
<div class="waiter fix"><span class="ir_font_bold">Waiter:
</span><span class="ir_display_none" id="order_details_waiter_id"></span><span
id="order_details_waiter_name"></span></div>
<div class="customer fix"><span class="ir_font_bold">Customer:
</span><span class="ir_display_none" id="order_details_customer_id"></span><span
id="order_details_customer_name"></span></div>
<div class="table fix"><span class="ir_font_bold">Table:
</span><span class="ir_display_none" id="order_details_table_id"></span><span
id="order_details_table_name"></span></div>
</div>
<div class="item_modifier_details fix">
<div class="modifier_item_header fix">
<div class="first_column_header column_hold">Item</div>
<div class="second_column_header column_hold">Price</div>
<div class="third_column_header column_hold">Qty</div>
<div class="forth_column_header column_hold">Discount</div>
<div class="fifth_column_header column_hold">Total</div>
</div>
<div class="scrollbar-macosx">
<div class="modifier_item_details_holder">
</div>
</div>
<div class="bottom_total_calculation_hold">

<div class="item">
<div>Total Item: <span
id="total_items_in_cart_order_details">0</span></div>
<div>Sub Total:
<span id="sub_total_show_order_details"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
<span id="sub_total_order_details"
class="ir_display_none"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
<span id="total_item_discount_order_details"
class="ir_display_none"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
<span id="discounted_sub_total_amount_order_details"
class="ir_display_none"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</div>
<div>
Discount:
<span id="sub_total_discount_order_details"></span><span
id="sub_total_discount_amount_order_details"
class="ir_display_none"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</div>
</div>
<div class="item">
<div>
Total Discount:
<span id="all_items_discount_order_details"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</div>
<div>
Tax:
<span id="all_items_vat_order_details"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</div>
<div>
Charge:
<span id="delivery_charge_order_details"><?php echo POS_SettingHelpers::getAmtP(0)?></span>
</div>
</div>
</div>
<h1 class="modal_payable">Total Payable <span
id="total_payable_order_details"><?php echo POS_SettingHelpers::getAmtP(0)?></span></h1>
</div>
</div>
</div>
<div class="create_invoice_close_order_in_order_details" id="order_details_post_invoice_buttons">
<button class="no-need-for-waiter" id="order_details_create_invoice_close_order_button"><i
class="fas fa-file-invoice"></i>
Create Invoice & Close</button>
</div>
<div class="create_invoice_close_order_in_order_details">
<button class="no-need-for-waiter" id="order_details_print_kot_button"><i
class="fas fa-file-invoice"></i>
Print KOT</button>
</div>
<button id="order_details_close_button">Close</button>
</div>
</div>
</div>
<!-- end add customer modal -->

<!-- The kitchen status modal -->
<div id="kitchen_status_modal" class="modal">

<!-- Modal content -->
<div class="modal-content" id="modal_kitchen_status_details">
<h1 id="kitchen_status_main_header">
Kitchen Status                <a href="javascript:void(0)" class="ir_top22_right0 alertCloseIcon" id="kitchen_status_close_button2"><i
class="fal fa-times"></i></a>
</h1>
<div class="kitchen_status_modal_info_holder fix">
<p><span class="ir_font_bold">Order Number:</span> <span
id="kitchen_status_order_number"></span> <span
class="ir_font_bold">Order Type:</span> <span
id="kitchen_status_order_type"></span></p>
<p class="">
<span class="ir_font_bold">Waiter: </span><span
id="kitchen_status_waiter_name"></span>
<span class="ir_font_bold">Customer: </span><span
id="kitchen_status_customer_name"></span>
<span class="ir_font_bold">Order Table: </span><span
id="kitchen_status_table"></span>
</p>
<div id="kitchen_status_detail_holder" class="fix">
<div id="kitchen_status_detail_header" class="fix">
<div class="fix first">Item</div>
<div class="fix second">Quantity</div>
<div class="fix third">Status</div>
</div>

<div id="kitchen_status_item_details">

</div>

</div>
<h1 id="kitchen_status_order_placed">Order Placed at: 14:22</h1>
<h1 id="kitchen_status_time_count">Time Count: <span
id="kitchen_status_ordered_minute">23</span>:<span id="kitchen_status_ordered_second">55</span>
M</h1>
<button id="kitchen_status_close_button">Close</button>
</div>
</div>
</div>
<!-- end kitchen status modal -->

<!-- The table modal please read -->
<div id="please_read_modal" class="modal">

<!-- Modal content -->
<div class="modal-content" id="modal_please_read_details">
<h1 id="please_read_modal_header" class="ir_color_red">
Please Read
</h1>
<div class="help_modal_info_holder scrollbar-macosx">

<!-- <p class="para_type_1">How order process works</p> -->
<p class="para_type_1">Modify Order:</p>
<p class="para_type_2">If you need to add some new item to an order, please select a running order from left and click on Modify Order. We have a perfect mechanism for modifying an order, please do that from there and please don't be confused to do that here, this is only table management section of an order.</p>
<p class="para_type_1">What you can do here:</p>
<p class="para_type_2">An order may contain many person sitting in multiple tables.<br> a) You can select multiple tables for an order. <br>b) You can not set person more than available sit for in a table. <br>c) You can proceed without selecting table because some people may can gather, take tea and go out. <br>d) As a table can have availability of several chairs and sometime those are sharable, so you can select multiple order in a table</p>

</div>
<button id="please_read_close_button">Close</button>
</div>
</div>
<!-- end table modal please read modal -->

<!-- The kitchen status modal -->
<div id="help_modal" class="modal">

<!-- Modal content -->
<div class="modal-content" id="modal_help_details">
<h1 id="help_modal_header" class="ir_color_red">Read Before Begin                <a href="javascript:void(0)" class="alertCloseIcon">
<i class="fal fa-times"></i>
</a>
</h1>
<div class="help_modal_info_holder scrollbar-macosx">
<p class="para_type_1">What is Running Order </p>
<p class="para_type_2">Placed order goes to Running Orders, to modify/invoice that order just select that order and click on bellow button </p>
<p class="para_type_1">What is Modify Order </p>
<p class="para_type_2">Modify order is not limited to only add new item, means modification of anything of that order, remove item, change item qty, change type, change waiter etc </p>

<p class="para_type_1">Allow Popup </p>
<p class="para_type_2">Please allow popup of your browser to print Invoice and KOT </p>
<p class="para_type_1">Print KOT </p>
<p class="para_type_2">Use Print KOT button if you intend to not to use Kitchen Panel </p>
<p class="para_type_2">When customer asks for new item or he wants an item more, just modify an order then go to print KOT, and just check that new item/quantity increased item, then reduce quantity and print the KOT, so that you can now only send the new item to kitchen </p>
<p class="para_type_2">But for Kitchen Panel, no need to worry, kithcen panel will be notified when an order is modified </p>
<p class="para_type_1">Searching </p>
<p class="para_type_2">Press Ctrl+Shift+F to focus on Search field </p>
<p class="para_type_2">Just type VEG, all veg items will be appeared </p>
<p class="para_type_2">Just type BEV, all beverage items will be appeared </p>
<p class="para_type_2">Just type Bar, all bar items will be appeared </p>
<p class="para_type_1">Refresh Button </p>
<p class="para_type_2">When you see that there refresh button right beside of running orders is red. You need to click on that button to refresh running orders to get update from kitchen. </p>
<p class="para_type_1">Stock</p>
<p class="para_type_2">System will only deduct ingredient from inventory when you close an order by clicking on Create Invoice & Close OR Close Order button. </p>
<p class="para_type_1">Order Details </p>
<p class="para_type_2">You can also see an order's details by double clicking on it</p>
<p class="para_type_1">Discount </p>
<p class="para_type_2">Mention that discount does not applies on Modifier. </p>
<p class="para_type_1">Clear Cache </p>
<p class="para_type_2">We are using JS cache to speed up operation, so please clear your cache by Ctrl+F5 after adding a new Food Item. </p>
</div>
<button id="help_close_button">Close</button>

</div>
</div>
<!-- end kitchen status modal -->

<!-- The Modal -->
<div id="finalize_order_modal" class="modal">

<!-- Modal content -->
<div class="modal-content" id="modal_finalize_order_details">
<h1 id="modal_finalize_header">Finalize Order</h1>
<div class="fo_1 fix">
<span class="ir_display_none" id="finalize_update_type"></span>
<div class="half fix floatleft">Total Payable</div>
<div class="half fix floatleft textright"><span
id="finalize_total_payable"><?php echo POS_SettingHelpers::getAmtP(0)?></span></div>
</div>
<div class="fo_2 fix">
<div class="half fix floatleft">Payment Method</div>
<div class="half fix floatleft textright">
<select name="finalie_order_payment_method" class="select2" id="finalie_order_payment_method">
<option value="">Payment Method</option>
<!--This variable could not be escaped because this is html content-->
 <?php echo $payment_method_options; ?>                    
</select>
</div>

</div>
<div class="fo_3 fix">
<div class="half fix floatleft textleft">Paid Amount</div>
<div class="half fix floatleft textright">Due Amount</div>
<div class="half fix floatleft textleft"><input type="text" name="pay_amount_invoice_modal_input"
id="pay_amount_invoice_input"></div>
<div class="half fix floatleft textright"><input type="text" name="due_amount_invoice_modal_input"
id="due_amount_invoice_input" disabled></div>
</div>
<div class="fo_3  fix">
<div class="half fix floatleft textleft">Given Amount <i
data-tippy-content="Use this field only to calculate the change amount of the customer"
class="fal fa-question-circle given_amount_tooltip"></i></div>
<div class="half fix floatleft textright">Change Amount</div>
<div class="half fix floatleft textleft"><input type="text" name="given_amount_modal_input"
id="given_amount_input"></div>
<div class="half fix floatleft textright"><input type="text" name="change_amount_modal_input"
id="change_amount_input" disabled></div>
</div>
<div class="bottom_buttons fix">
<div class="bottom_single_button fix">
<button id="finalize_order_button">Submit</button>
</div>
<div class="bottom_single_button fix">
<button id="finalize_order_cancel_button">Cancel</button>
</div>
</div>
<!-- <span class="btn-close">&times;</span> -->
<!-- <p>Some text in the Modal..</p> -->
</div>

</div>
<!-- end of item modal -->
<!-- The Modal -->
<div id="delete_order_by_admin" class="modal">

<!-- Modal content -->
<div class="modal-content" id="modal_finalize_order_details">
<h1 id="modal_finalize_header">Delete Sale</h1>
<input type="hidden" name="" id="delete_sale_id">


<div class="fo_3  fix">
<label> Remarks</label>
<textarea name="delete_remarks" id="delete_remarks" maxlength="50" class="form-control" style="display: block;width: 100%;"></textarea>
</div>
<div class="bottom_buttons fix">
<div class="bottom_single_button fix">
<button id="delete_order_button">Submit</button>
</div>
<div class="bottom_single_button fix">
<button id="delete_order_cancel_button">Cancel</button>
</div>
</div>
<!-- <span class="btn-close">&times;</span> -->
<!-- <p>Some text in the Modal..</p> -->
</div>

</div>

<!-- The Modal -->
<div id="cancel_order_by_admin" class="modal">

<!-- Modal content -->
<div class="modal-content" id="modal_finalize_order_details">
<h1 id="modal_finalize_header">Cancel Order</h1>
<input type="hidden" name="" id="cancel_sale_id">


<div class="fo_3  fix">
<label> Remarks</label>
<textarea name="cancel_remarks" id="cancel_remarks" maxlength="50" class="form-control" style="display: block;width: 100%;"></textarea>
</div>
<div class="bottom_buttons fix">
<div class="bottom_single_button fix">
<button id="cancels_order_button">Submit</button>
</div>
<div class="bottom_single_button fix">
<button id="cancel_order_cancel_button">Cancel</button>
</div>
</div>
<!-- <span class="btn-close">&times;</span> -->
<!-- <p>Some text in the Modal..</p> -->
</div>

</div>


<!-- end of item modal -->
<!-- The Notification List Modal -->
<div id="notification_list_modal" class="modal">

<!-- Modal content -->
<div class="modal-content" id="modal_notification_list_details">
<h1 id="modal_notification_header">
Notification List <a href="javascript:void(0)" class="alertCloseIcon" id="notification_close2"><i
class="fal fa-times"></i></a>
</h1>
<div id="notification_list_header_holder">
<div class="single_row_notification_header fix ir_h25_bb1">
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
<button id="notification_remove_all">Remove</button>
<button id="notification_close">Cancel</button>
</div>
</div>

</div>
<!-- end of notification list modal -->


<!-- The Notification List Modal -->
<div id="kitchen_bar_waiter_panel_button_modal" class="modal">

<!-- Modal content -->
<div class="modal-content ir_pos_relative" id="modal_kitchen_bar_waiter_details">
<p class="cross_button_to_close cCloseIcon" id="kitchen_bar_waiter_modal_close_button_cross">X</p>
<h1 id="switch_panel_modal_header">Kitchen, Waiter & Bar</h1>
<div class="ir_p30">

<a href="http://localhost/pos/Demo_panel/switchTo/kitchen" target="_blank" class="ir_w32_d_ta">
<button class="ir_w_100">Kitchen Panel</button>
</a>
<a href="http://localhost/pos/Demo_panel/switchTo/waiter" target="_blank" class="ir_w32_d_ta">
<button class="ir_w_100">Waiter Panel</button>
</a>
<a href="http://localhost/pos/Demo_panel/switchTo/bar" target="_blank" class="ir_w32_d_ta">
<button class="ir_w_100">Bar Panel</button>
</a>
</div>

</div>

</div>
<!-- end of notification list modal -->

<!-- The KOT Modal -->
<div id="kot_list_modal" class="modal">

<!-- Modal content -->
<div class="modal-content" id="modal_kot_list_details">
<h1 id="modal_kot_header">
KOT                <a href="javascript:void(0)" class="ir_top5_right_10 alertCloseIcon" id="cancel_kot_modal2"><i
class="fal fa-times"></i></a>
</h1>
<h2 id="kot_modal_modified_or_not"></h2>
<div id="kot_header_info" class="fix">
<p>Order No: <span id="kot_modal_order_number"></span></p>
<p>Date: <span id="kot_modal_order_date"></span></p>
<p>Customer: <span id="kot_modal_customer_id"
class="ir_display_none"></span><span id="kot_modal_customer_name"></span></p>
<p>Table: <span id="kot_modal_table_name"></span></p>
<p>Waiter: <span id="kot_modal_waiter_name"></span>,
Order Type: <span id="kot_modal_order_type"></span></p>
</div>
<div id="kot_table_content" class="fix">
<div class="kot_modal_table_content_header fix">
<div class="kot_header_row fix floatleft kot_check_column"><input type="checkbox"
id="kot_check_all"></div>
<div class="ir_w_405x kot_header_row fix floatleft kot_item_name_column">
Item</div>
<div class="kot_header_row fix floatleft kot_qty_column">Qty</div>
</div>
<div class="scrollbar-macosx">
<div id="kot_list_holder"></div>
</div>
</div>
<div id="kot_bottom_buttons" class="fix">
<button id="cancel_kot_modal">Cancel</button><button
id="print_kot_modal">Print KOT</button>
</div>

</div>

</div>

<div id="bot_list_modal" class="modal">

<!-- Modal Content -->
<div class="modal-content" id="modal_bot_list_details">
<h1 id="modal_bot_header">
BOT                <a href="javascript:void(0)" class="ir_top5_right_10 alertCloseIcon" id="cancel_bot_modal2"><i
class="fal fa-times"></i></a>
</h1>
<h2 id="bot_modal_modified_or_not"></h2>
<div id="bot_header_info" class="fix">
<p>Order No: <span id="bot_modal_order_number"></span></p>
<p>Date: <span id="bot_modal_order_date"></span></p>
<p>Customer: <span id="bot_modal_customer_id"
class="ir_display_none"></span><span id="bot_modal_customer_name"></span></p>
<p>Table: <span id="bot_modal_table_name"></span></p>
<p>Waiter: <span id="bot_modal_waiter_name"></span>,
Order Type: <span id="bot_modal_order_type"></span></p>
</div>
<div id="bot_table_content" class="fix">
<div class="bot_modal_table_content_header fix">
<div class="bot_header_row fix floatleft bot_check_column"><input type="checkbox"
id="bot_check_all"></div>

<div class="ir_w_405x bot_header_row floatleft bot_item_name_column">
Item                    </div>


<div class="bot_header_row fix floatleft bot_qty_column">Qty</div>
</div>

<div class="scrollbar-macosx">
<div id="bot_list_holder"></div>
</div>

</div>
<div id="bot_bottom_buttons" class="fix">
<button id="cancel_bot_modal">Cancel</button>
<!-- <button
id="print_bot_modal">Print BOT</button> -->
</div>

</div>

</div>
<!-- end of KOT modal -->
<div id="calculator_main">
<div class="calculator">
<input type="text" readonly>
<div class="row">
<div class="key">1</div>
<div class="key">2</div>
<div class="key">3</div>
<div class="key last">0</div>
</div>
<div class="row">
<div class="key">4</div>
<div class="key">5</div>
<div class="key">6</div>
<div class="key last action instant">cl</div>
</div>
<div class="row">
<div class="key">7</div>
<div class="key">8</div>
<div class="key">9</div>
<div class="key last action instant">=</div>
</div>
<div class="row">
<div class="key action">+</div>
<div class="key action">-</div>
<div class="key action">x</div>
<div class="key last action">/</div>
</div>
</div>
</div>
<div id="direct_invoice_button_tool_tip" class="ir_d_none_p_m_bg_br_bs">
<h1 class="title ir_m_fs14_lh25">For Fast Food Restaurants</h1>
</div>


<script type="text/javascript" src="{{url('/resources/assets/pos')}}/assets/POS/js/marquee.js"></script>
<script type="text/javascript" src="{{url('/resources/assets/pos')}}/assets/POS/js/items.js"></script>
<script type="text/javascript" src="{{url('/resources/assets/pos')}}/assets/POS/js/datable.js"></script>
<script type="text/javascript" src="{{url('/resources/assets/pos')}}/assets/POS/js/jquery.cookie.js"></script>
<!-- For Tooltip -->
<script type="text/javascript" src="{{url('/resources/assets/pos')}}/assets/POS/js/lib/tippy/popper.min.js"></script>
<script type="text/javascript" src="{{url('/resources/assets/pos')}}/assets/POS/js/lib/tippy/tippy-bundle.umd.min.js">
</script>
<script src="http://localhost/pos/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="{{url('/resources/assets/pos')}}/assets/POS/js/lib/datepicker.js"></script>
<!-- Custom Scrollbar -->
<script type="text/javascript" src="{{url('/resources/assets/pos')}}/assets/POS/js/lib/scrollbar/jquery.scrollbar.min.js">
</script>

<script type="text/javascript" src="{{url('/resources/assets/pos')}}/assets/POS/js/howler.min.js"></script>
<script src="{{url('/resources/assets/pos')}}/assets/dist/js/feather.min.js"></script>
<script type="text/javascript" src="{{url('/resources/assets/pos')}}/frequent_changing/js/pos_script.js"></script>
<script src="http://localhost/pos/assets/POS/js/media.js"></script>
<script type="text/javascript" src="{{url('/resources/assets/pos')}}/assets/plugins/notify/jquery.notifyBar.js"></script>

 <script type="text/javascript">
    /*This variable could not be escaped because this is building object*/
    window.customers = [<?php echo $customer_objects;?>];
    /*This variable could not be escaped because this is building object*/
    window.items = [<?php echo $javascript_obects;?>];
    /*This variable could not be escaped because this is building object*/
    window.item_modifiers = [<?php echo $javascript_obects_modifier;?>];
    </script>
</body>

</html>