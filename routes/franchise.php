<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FanchiseRegistrationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FanchisePaymentController;
use App\Http\Controllers\PageAccessController;
use App\Http\Controllers\SupplyItemListController;
use App\Http\Controllers\WharehouseCartController;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\FactoryCartController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\OutletSettingController;
use App\Http\Controllers\PaytmController;
use App\Http\Controllers\LoginController;

Route::group(['middleware'=>['login','SuperAdmin']],function(){ 
Route::get("New-Registration",[FanchiseRegistrationController::class,'new_registration'])->name('new_registration');
Route::post("fanchise_register",[FanchiseRegistrationController::class,'fanchise_register']);
Route::POST('/active_status',[FanchiseRegistrationController::class,'active_status']);
Route::get("Newly-Submitted",[FanchiseRegistrationController::class,'newly_submitted'])->name('newly_submitted');

Route::get("Temporary-Inactive-Newly-Submitted",[FanchiseRegistrationController::class,'temp_inactive_newly_submitted'])->name('temp_inactive_newly_submitted');
Route::get("get_newly_submitted",[FanchiseRegistrationController::class,'get_newly_submitted'])->name('get_newly_submitted');
Route::get("Temporary-Inactive",[FanchiseRegistrationController::class,'temporary_inactive'])->name('temporary_inactive');
Route::get("Inactive",[FanchiseRegistrationController::class,'inactive'])->name('inactive');
Route::post("Edit-Fanchise",[FanchiseRegistrationController::class,'edit']);
Route::post("fanchise_register_update",[FanchiseRegistrationController::class,'fanchise_register_update']);
Route::post("Edit-Ongoing-Pre-Launch",[FanchiseRegistrationController::class,'edit']);
Route::post("Edit-Ongoing-Kyc-Inactive",[FanchiseRegistrationController::class,'edit']);
Route::post("Edit-Launched-Franchise",[FanchiseRegistrationController::class,'edit_launched']);
Route::post("fanchise_launched_update",[FanchiseRegistrationController::class,'fanchise_launched_update']);
Route::get("add_fund_form",[FanchiseRegistrationController::class,'add_fund_form']);
Route::POST("fund_save",[FanchiseRegistrationController::class,'fund_save']);

Route::get("Pushback-Request",[FanchiseRegistrationController::class,'pushback_request'])->name('pushback_request');
Route::post("Reply-Fanchise",[FanchiseRegistrationController::class,'reply']);
Route::post("reply_without_change",[FanchiseRegistrationController::class,'reply_without_change']);
Route::get("Replied-Request",[FanchiseRegistrationController::class,'replied_request'])->name('replied_request');

Route::get("Running-Franchise",[FanchiseRegistrationController::class,'launch_fanchise'])->name('launch_fanchise');
Route::POST("change_password_outlet",[LoginController::class,'change_password_outlet'])->name('change_password_outlet');
Route::get("Expired-Subscription",[FanchiseRegistrationController::class,'expired_subscription'])->name('expired_subscription');
Route::POST("Interior-Work-Actions",[FanchiseRegistrationController::class,'architect_add']);
Route::POST("Interior-Work-Edit",[FanchiseRegistrationController::class,'architect_edit']);
Route::POST("Social-Media-Edit",[FanchiseRegistrationController::class,'architect_edit']);
Route::POST("Operations-Edit",[FanchiseRegistrationController::class,'architect_edit']);
Route::POST("Accounts-Edit",[FanchiseRegistrationController::class,'architect_edit']);
Route::POST("Social-Media-Actions",[FanchiseRegistrationController::class,'architect_add']);
Route::POST("Operations-Actions",[FanchiseRegistrationController::class,'architect_add']);
Route::POST("Accounts-Actions",[FanchiseRegistrationController::class,'architect_add']);
Route::POST("Procurement-Actions",[FanchiseRegistrationController::class,'architect_add']);
//
Route::get("Warehouse-Newly-Submitted-Order",[WharehouseCartController::class,'wharehouse_newly_submitted_order'])->name('wharehouse_newly_submitted_order');
Route::get("Warehouse-Ongoing-Order",[WharehouseCartController::class,'wharehouse_newly_submitted_order'])->name('wharehouse_ongoing_submitted_order');
Route::get("Warehouse-Delivered-Order",[WharehouseCartController::class,'wharehouse_newly_submitted_order'])->name('wharehouse_completed_submitted_order');

});

Route::group(['middleware'=>['login','fanchise','XSS']],function(){ 


});


Route::group(['middleware'=>['login']],function(){ 
Route::POST("Franchise-Pre-Launch",[FanchiseRegistrationController::class,'architect_add']);
Route::POST("store_pre_launch_data",[FanchiseRegistrationController::class,'store_pre_launch_data']);
Route::get("New-Worklist",[FanchiseRegistrationController::class,'new_work_list'])->name('new_work_list');

Route::post("push_back_request",[FanchiseRegistrationController::class,'push_back_request']);

Route::post("fanchise_register_reply",[FanchiseRegistrationController::class,'fanchise_register_reply']);


Route::get("get_lunched_franchise",[FanchiseRegistrationController::class,'get_lunched_franchise'])->name('get_lunched_franchise');


Route::get("Fanchise-Account",[FanchiseRegistrationController::class,'fanchise_account'])->name('fanchise_account');
Route::get("Supply-Order-Payment",[FanchiseRegistrationController::class,'supply_order_payment'])->name('supply_order_payment');
Route::get("Franchise-Credit-History",[FanchiseRegistrationController::class,'franchise_credit_history'])->name('franchise_credit_history');
Route::get("My-Account",[FanchiseRegistrationController::class,'my_account'])->name('my_account');
Route::get("accept_request",[FanchiseRegistrationController::class,'accept_request']);
Route::get("Kyc",[FanchiseRegistrationController::class,'kyc']);
Route::get("First-Time-Stock",[FanchiseRegistrationController::class,'first_time_stock']);
Route::get("first_time_stock_download",[FanchiseRegistrationController::class,'first_time_stock_download'])->name('first_time_stock_download');

Route::POST("kyc_update",[FanchiseRegistrationController::class,'kyc_update']);
Route::POST("store_kyc_update",[FanchiseRegistrationController::class,'store_kyc_update']);
Route::POST("get_fanchise_kyc_data",[FanchiseRegistrationController::class,'get_fanchise_kyc_data']);
Route::get("store-Kyc",[FanchiseRegistrationController::class,'store_kyc']);
Route::POST("approve_kyc_by_admin",[FanchiseRegistrationController::class,'approve_kyc_by_admin']);
Route::get("view-actions",[FanchiseRegistrationController::class,'view_actions']);

Route::POST("add_data_to_cart",[FanchiseRegistrationController::class,'add_data_to_cart']);
Route::get("get_cart_data",[FanchiseRegistrationController::class,'get_cart_data']);
Route::POST("submit_cart_by_company",[FanchiseRegistrationController::class,'submit_cart_by_company']);
Route::POST("change_supply_from",[FanchiseRegistrationController::class,'change_supply_from']);
Route::get("update_agreement_status",[FanchiseRegistrationController::class,'update_agreement_status']);
Route::post("store_agreement_status",[FanchiseRegistrationController::class,'store_agreement_status']);
Route::get("get_first_time_filter_data",[FanchiseRegistrationController::class,'get_first_time_filter_data']);
Route::get("update_local_purchase_status",[FanchiseRegistrationController::class,'update_local_purchase_status']);
Route::get("update_procurement_status",[FanchiseRegistrationController::class,'update_procurement_status']);
Route::get("get_chart_data",[FanchiseRegistrationController::class,'get_chart_data']);
Route::get("get_admin_dashboard",[AdminDashboardController::class,'get_admin_dashboard']);
Route::get("set_brand_session",[AdminDashboardController::class,'set_brand_session']);
Route::get("Loi",[ReportController::class,'loi']);
Route::get("AdminLoi/{id}",[ReportController::class,'adminloi']);
//outlet setting
Route::get("get_outlet_setting_data",[OutletSettingController::class,'get_outlet_setting_data']);
Route::POST("save_outlet_setting_form",[OutletSettingController::class,'save_outlet_setting_form']);
Route::get("outlet_menu_enable",[OutletSettingController::class,'outlet_menu_enable']);
Route::get("outlet_menu_disable",[OutletSettingController::class,'outlet_menu_disable']);
//RAZORPAY
Route::post("Fanchise-Payment",[FanchisePaymentController::class,'index']);
Route::POST("store_payment",[FanchisePaymentController::class,'store_payment']);
//Paytm
Route::post("store_paytm",[PaytmController::class,'store_paytm']);
Route::post("paytm-callback",[PaytmController::class,'paytmcallback']);

Route::POST("get_page_access_data",[PageAccessController::class,'get_page_access_data']);
Route::POST("save_page_access_data",[PageAccessController::class,'save_page_access_data']);
Route::POST("get_booking_amount_data",[FanchiseRegistrationController::class,'get_booking_amount_data']);
Route::POST("update_amount",[FanchiseRegistrationController::class,'update_amount']);
Route::get("get_fanchise_basic_data",[FanchiseRegistrationController::class,'get_fanchise_basic_data']);
Route::get("get_fanchise_launch_data",[FanchiseRegistrationController::class,'get_fanchise_launch_data']);
Route::post("date_changes",[FanchiseRegistrationController::class,'date_change']);
Route::post("survey_update",[FanchiseRegistrationController::class,'survey_update']);
Route::get("Invoice/{id}",[FanchisePaymentController::class,'invoice']);
Route::post("update_collection_admin",[FanchisePaymentController::class,'update_collection_admin']);
Route::post("update_collection_fanchise",[FanchisePaymentController::class,'update_collection_fanchise']);
Route::get("check_survey_condation",[FanchiseRegistrationController::class,'check_survey_condation']);
//Order
Route::get("get_supply_filter_data",[SupplyItemListController::class,'get_supply_filter_data']);
Route::get("Supply-List",[SupplyItemListController::class,'supply_list'])->name('supply_list')->middleware('fanchise');;
Route::post("add_to_cart",[SupplyItemListController::class,'add_to_cart']);
Route::post("add_supply_to_cart",[SupplyItemListController::class,'add_supply_to_cart']);
Route::post("Order-Placed",[SupplyItemListController::class,'order_placed']);
//rozerpay
Route::post("Order-Checkout",[SupplyItemListController::class,'order_checkout']);
Route::POST("store_payment_supplychain",[FanchisePaymentController::class,'store_payment_supplychain'])->middleware('fanchise');
//paytm
Route::post("Order_Payment",[PaytmController::class,'order_payment']);
Route::post("paytm-callback-supplychain",[PaytmController::class,'paytmcallback_supplychain']);


Route::get("Newly-Order",[SupplyItemListController::class,'newly_order'])->name('newly_order')->middleware('fanchise');
Route::get("Order-Invoice/{id}",[FanchisePaymentController::class,'order_invoice']);
Route::get("Product-Invoice/{id}",[FanchisePaymentController::class,'product_invoice']);
Route::get("New-Order-Payments",[SupplyItemListController::class,'new_order_payments'])->name('new_order_payments');
Route::post("get_update_order_payment_status",[SupplyItemListController::class,'get_update_order_payment_status']);
Route::post("get_outlet_order_status_update_by_factory",[SupplyItemListController::class,'get_outlet_order_status_update_by_factory']);
Route::get("wharehouse_order_status_update_by_factory",[StoresController::class,'wharehouse_order_status_update_by_factory']);
Route::get("factory_order_status_update_by_vendor",[StoresController::class,'factory_order_status_update_by_vendor']);
Route::post("update_order_status_factory",[SupplyItemListController::class,'update_order_status_factory']);
Route::post("update_order_status_vendor",[SupplyItemListController::class,'update_order_status_vendor']);
Route::post("update_wharehouse_order_status_factory",[StoresController::class,'update_wharehouse_order_status_factory']);
Route::post("update_factory_order_status_vendor",[StoresController::class,'update_factory_order_status_vendor']);
Route::post("change_order_status",[SupplyItemListController::class,'change_order_status']);
Route::post("order_payment_confirm_by_account",[SupplyItemListController::class,'order_payment_confirm_by_account']);
Route::get("Ongoing-Order",[SupplyItemListController::class,'ongoing_order'])->name('ongoing_order');
Route::post("track_order_status",[SupplyItemListController::class,'track_order_status']);
Route::post("order_details_with_status_change",[SupplyItemListController::class,'order_details_with_status_change']);
Route::post("dispatched_product",[SupplyItemListController::class,'dispatched_product']);


Route::post("change_order_status_dynamic_data",[SupplyItemListController::class,'change_order_status_dynamic_data']);
Route::post("change_order_status_store",[SupplyItemListController::class,'change_order_status_store']);
Route::post("save_collection_details",[SupplyItemListController::class,'save_collection_details']);

Route::get("Accepted-Order-Payments",[SupplyItemListController::class,'accepted_order_payments'])->name('accepted_order_payments');
Route::get("Order-Completed",[SupplyItemListController::class,'order_completed'])->name('order_completed')->middleware('fanchise');
//Store Order
Route::post("wharehouse_add_to_cart",[WharehouseCartController::class,'wharehouse_add_to_cart']);
Route::post("wharehouse_cart_count",[WharehouseCartController::class,'wharehouse_cart_count']);
Route::get("get_wharehouse_cart_data",[WharehouseCartController::class,'get_wharehouse_cart_data']);
Route::post("wharehouse_qty_change",[WharehouseCartController::class,'wharehouse_qty_change']);
Route::post("submit_cart_by_wharehouse",[WharehouseCartController::class,'submit_cart_by_wharehouse']);


Route::get("get_store_new_order",[WharehouseCartController::class,'get_store_new_order'])->name('get_store_new_order');
Route::get("Newly-Wharehouse-Order-Accounts",[WharehouseCartController::class,'newly_wharehouse_order_accounts'])->name('newly_wharehouse_order_accounts');
Route::get("Wharehouse-Order-Assign/{id}",[WharehouseCartController::class,'wharehouse_order_assign']);
Route::get("get_product_vendor_factory",[WharehouseCartController::class,'get_product_vendor_factory']);
Route::post("Wharehouse-Order-Assign/{id}",[WharehouseCartController::class,'wharehouse_order_assign_store']);
Route::get("Newly-Assigned-Wharehouse-Order",[WharehouseCartController::class,'ongoing_wharehouse_order_accounts'])->name('newly_assigned_wharehouse_order');
Route::get("Replied-to-Accounts-Wharehouse-Order",[WharehouseCartController::class,'ongoing_wharehouse_order_accounts'])->name('replied_to_accounts_wharehouse_order');
Route::get("Ongoing-Wharehouse-Order-Accounts",[WharehouseCartController::class,'ongoing_wharehouse_order_accounts'])->name('ongoing_wharehouse_order_accounts');
Route::get("Dispatched-Wharehouse-Order",[WharehouseCartController::class,'ongoing_wharehouse_order_accounts'])->name('dispatched_wharehouse_order_accounts');
Route::get("Completed-Wharehouse-Order-Accounts",[WharehouseCartController::class,'ongoing_wharehouse_order_accounts'])->name('completed_wharehouse_order_accounts');
Route::get("get_wharehouse_order_accounts",[WharehouseCartController::class,'get_wharehouse_order_accounts'])->name('get_wharehouse_order_accounts');

Route::get("wharehouse_order_status_update_by_account",[WharehouseCartController::class,'wharehouse_order_status_update_by_account']);
Route::post("update_wharehouse_order_status_account",[WharehouseCartController::class,'update_wharehouse_order_status_account']);


//
Route::post("factory_add_to_cart",[FactoryCartController::class,'factory_add_to_cart']);
Route::post("factory_qty_change",[FactoryCartController::class,'factory_qty_change']);
Route::post("factory_cart_count",[FactoryCartController::class,'factory_cart_count']);
Route::get("get_factory_cart_data",[FactoryCartController::class,'get_factory_cart_data']);
Route::post("submit_cart_by_factory",[FactoryCartController::class,'submit_cart_by_factory']);

Route::get("Newly-Factory-Order-Accounts",[FactoryCartController::class,'newly_factory_order_accounts'])->name('newly_factory_order_accounts');
Route::get("Factory-Order-Assign/{id}",[FactoryCartController::class,'factory_order_assign']);
Route::get("get_product_vendor",[FactoryCartController::class,'get_product_vendor']);
Route::post("Factory-Order-Assign/{id}",[FactoryCartController::class,'factory_order_assign_store']);
Route::get("Newly-Assigned-Factory-Order",[FactoryCartController::class,'ongoing_factory_order_accounts'])->name('newly_assigned_factory_order_accounts');
Route::get("Replied-to-Accounts-Factory-Order",[FactoryCartController::class,'ongoing_factory_order_accounts'])->name('replied_factory_order_accounts');
Route::get("Ongoing-Factory-Order-Accounts",[FactoryCartController::class,'ongoing_factory_order_accounts'])->name('ongoing_factory_order_accounts');
Route::get("Dispatched-Factory-Order",[FactoryCartController::class,'ongoing_factory_order_accounts'])->name('dispatch_factory_order_accounts');
Route::get("Completed-Factory-Order-Accounts",[FactoryCartController::class,'ongoing_factory_order_accounts'])->name('completed_factory_order_accounts');
Route::get("get_factory_order_accounts",[FactoryCartController::class,'get_factory_order_accounts'])->name('get_factory_order_accounts');
Route::get("factory_order_status_update_by_account",[FactoryCartController::class,'factory_order_status_update_by_account']);
Route::post("update_factory_order_status_account",[FactoryCartController::class,'update_factory_order_status_account']);



Route::get("Factory-Newly-Submitted-Order",[FactoryCartController::class,'factory_newly_submitted_order'])->name('factory_newly_submitted_order');
Route::get("Factory-Ongoing-Order",[FactoryCartController::class,'factory_newly_submitted_order'])->name('factory_ongoing_submitted_order');
Route::get("Factory-Delivered-Order",[FactoryCartController::class,'factory_newly_submitted_order'])->name('factory_completed_submitted_order');

Route::get("get_factory_new_order",[FactoryCartController::class,'get_factory_new_order'])->name('get_factory_new_order');

 	});