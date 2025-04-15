<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodMenuCategoryController;
use App\Http\Controllers\FoodMenuController;
use App\Http\Controllers\FranchiseTableSettingController;
use App\Http\Controllers\FranchisePaymentOptionController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\FranchiseStockSalePriceController;
use App\Http\Controllers\WaiterController;
use App\Http\Controllers\POSReportController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\LocalSupplierController;
use App\Http\Controllers\WasteController;
//Admin 
Route::get("excel_uploads",[POSController::class,'excel_uploads']);

Route::group(['middleware'=>['login']],function(){ 
//Food Menu Category
Route::get("Food-Menu-Category",[FoodMenuCategoryController::class,'index'])->name('food_menues_category');
Route::get('get_food_category', [FoodMenuCategoryController::class, 'get_food_category'])->name('get_food_category');
Route::get("add_food_menu",[FoodMenuCategoryController::class,'create']);
Route::post("store_food_menu",[FoodMenuCategoryController::class,'store']);
Route::get("edit_food_menu",[FoodMenuCategoryController::class,'edit']);
Route::post("update_store_food_menu",[FoodMenuCategoryController::class,'update']);
Route::get("delete_food_menu",[FoodMenuCategoryController::class,'destroy']);
//Food Menu
Route::get("Food-Menu",[FoodMenuController::class,'index'])->name('food_menues');
Route::get('get_food_menu', [FoodMenuController::class, 'get_food_menu'])->name('get_food_menu');
Route::get("add_foodmenu",[FoodMenuController::class,'create']);
Route::post("store_foodmenu",[FoodMenuController::class,'store']);
Route::get("edit_foodmenu",[FoodMenuController::class,'edit']);
Route::post("update_foodmenu",[FoodMenuController::class,'update']);
Route::get("delete_foodmenu",[FoodMenuController::class,'destroy']);
Route::post("get_export_recipe",[FoodMenuController::class,'get_export_recipe']);
Route::post("store_recipes_by_excel",[FoodMenuController::class,'store_recipes_by_excel'])->name('store_recipes_by_excel ');
Route::get('get_ingredients_list_food_menu', [FoodMenuController::class, 'get_ingredients_list_food_menu'])->name('get_ingredients_list_food_menu');







});



Route::group(['middleware'=>['login','SuperAdmin']],function(){ 


//
Route::get('Outlet-Menu-Price', [POSReportController::class, 'outlet_menu_price'])->name('outlet_menu_price');
Route::get('getoutletmenuprice', [POSReportController::class, 'getoutletmenuprice'])->name('getoutletmenuprice');
//
Route::get("New-Physical-Request",[FranchiseStockSalePriceController::class,'new_physical_request'])->name('new_physical_request');
Route::get("Completed-Physical-Request",[FranchiseStockSalePriceController::class,'completed_physical_request'])->name('completed_physical_request');
Route::get('get_physical_request', [FranchiseStockSalePriceController::class, 'get_physical_request'])->name('get_physical_request');
Route::get("exportstock/{id1}/{id2}",[FranchiseStockSalePriceController::class,'exportstock']);
Route::post("store_admin_stock_by_excel",[FranchiseStockSalePriceController::class,'store_admin_stock_by_excel']);

Route::get("New-Purchase-Request",[PurchaseController::class,'new_purchase_request'])->name('new_purchase_request');
Route::get('get_purchase_list_admin', [PurchaseController::class, 'get_purchase_list_admin'])->name('get_purchase_list_admin');
Route::get("Ongoing-Purchase-Request",[PurchaseController::class,'ongoing_purchase_request'])->name('ongoing_purchase_request');
Route::get("Purchase-Pushbacked-Request",[PurchaseController::class,'new_pushbacked_request'])->name('new_pushbacked_request');
Route::get("Purchase-Replied-Request",[PurchaseController::class,'new_replied_request'])->name('new_replied_request');
Route::get("Completed-Purchase-Request",[PurchaseController::class,'completed_purchase_request'])->name('completed_purchase_request');
Route::get("accept_daily_purchase",[PurchaseController::class,'accept_daily_purchase']);
Route::post("pushback_daily_purchase",[PurchaseController::class,'pushback_daily_purchase']);

});
Route::group(['middleware'=>['login','XSS']],function(){


//POSReportController
Route::get('ConsumptionReport', [POSReportController::class, 'consumptionreport'])->name('consumptionreport');
Route::get('getconsumptionreport', [POSReportController::class, 'getconsumptionreport'])->name('getconsumptionreport');
Route::get('foodMenuSales', [POSReportController::class, 'foodmenusales'])->name('foodmenusales');
Route::get('getfoodmenusales', [POSReportController::class, 'getfoodmenusales'])->name('getfoodmenusales');
Route::get('get_sale_report', [POSReportController::class, 'get_sale_report']);

//DSR
// Route::get('DSR-MTD', [POSReportController::class, 'dsr_mtd'])->name('dsr_mtd');
Route::post('getdsr_mtd', [POSReportController::class, 'getdsr_mtd'])->name('getdsr_mtd');
// Route::get('DSR-RSC-MTD', [POSReportController::class, 'dsr_rsc_mtd'])->name('dsr_rsc_mtd');
Route::post('getdsr_rsc_mtd', [POSReportController::class, 'getdsr_rsc_mtd'])->name('getdsr_rsc_mtd');
Route::post('getall_restaurants_sales_summary', [POSReportController::class, 'getall_restaurants_sales_summary'])->name('getall_restaurants_sales_summary');
Route::post('getoutlet_customers', [POSReportController::class, 'getoutlet_customers'])->name('getoutlet_customers');
Route::post('get_bill_wise_report', [POSReportController::class, 'get_bill_wise_report'])->name('get_bill_wise_report');
Route::post('get_void_report', [POSReportController::class, 'get_void_report'])->name('get_void_report');
Route::post('get_inventory_valuation', [POSReportController::class, 'get_inventory_valuation'])->name('get_inventory_valuation');
Route::post('get_discount_summary', [POSReportController::class, 'get_discount_summary'])->name('get_discount_summary');
Route::post('get_detail_discount', [POSReportController::class, 'get_detail_discount'])->name('get_detail_discount');
Route::get('POS-Reports', [POSReportController::class, 'pos_reports'])->name('pos_reports');
Route::get('get_city_wise_outlet', [POSReportController::class, 'get_city_wise_outlet']);
Route::get('get_region_wise_data', [POSReportController::class, 'get_region_wise_data']);
Route::post('get_item_wise_transection', [POSReportController::class, 'get_item_wise_transection'])->name('get_item_wise_transection');
Route::post('get_item_wise_sale_details', [POSReportController::class, 'get_item_wise_sale_details'])->name('get_item_wise_sale_details');
Route::post('get_menu_mix', [POSReportController::class, 'get_menu_mix'])->name('get_menu_mix');

//Hourly report
Route::get('Hourly-Reports', [POSReportController::class, 'hourly_reports'])->name('hourly_reports');
Route::get('get_hourly_data', [POSReportController::class, 'get_hourly_data'])->name('get_hourly_data');
Route::post('download_hourly_report', [POSReportController::class, 'download_hourly_report'])->name('download_hourly_report');

Route::get("view_daily_purchase",[PurchaseController::class,'view_daily_purchase']);
});
//Franchise
Route::group(['middleware'=>['login','fanchise','XSS']],function(){
//Supplier
Route::get("Supplier",[LocalSupplierController::class,'index'])->name('supplier');
Route::get('get_supplier', [LocalSupplierController::class, 'get_supplier'])->name('get_supplier');
Route::get("add_supplier",[LocalSupplierController::class,'create']);
Route::post("store_supplier",[LocalSupplierController::class,'store'])->name('store_supplier');
Route::get("edit_supplier",[LocalSupplierController::class,'edit']);
Route::post("update_supplier",[LocalSupplierController::class,'update']);
Route::get("delete_supplier",[LocalSupplierController::class,'destroy']);
//Waste
Route::get("Waste",[WasteController::class,'index'])->name('waste');
Route::get("Add-Food-Menu-Waste",[WasteController::class,'add_food_menu_waste'])->name('add_food_menu_waste');
Route::post("Add-Food-Menu-Waste",[WasteController::class,'store_food_menu_waste'])->name('add_food_menu_waste');
Route::get("get_waste_list",[WasteController::class,'get_waste_list'])->name('get_waste_list');
Route::get('Edit-Food-Menu-Waste/{id}', [WasteController::class, 'edit_food_menu_waste']);
Route::post('Edit-Food-Menu-Waste/{id}', [WasteController::class, 'update_food_menu_waste']);
Route::get("Add-Ingredients-Waste",[WasteController::class,'add_ingredients_waste'])->name('add_ingredients_waste');
Route::post("Add-Ingredients-Waste",[WasteController::class,'store_ingredients_waste'])->name('add_ingredients_waste');
Route::get('Edit-Ingredient-Waste/{id}', [WasteController::class, 'edit_ingredients_waste']);
Route::post('Edit-Ingredient-Waste/{id}', [WasteController::class, 'update_ingredients_waste']);
Route::get('delete_waste_purchase', [WasteController::class, 'delete_waste_purchase']);
Route::get("view_waste_purchase",[WasteController::class,'view_waste_purchase']);

//Purchase	
Route::get("Purchase",[PurchaseController::class,'index'])->name('purchase');
Route::get("Purchase-Pushbacked",[PurchaseController::class,'purchase_pushbacked'])->name('purchase_pushbacked');
Route::get("Purchase-Replied",[PurchaseController::class,'purchase_replied'])->name('purchase_replied');
Route::get("Approved-Purchase",[PurchaseController::class,'approved_purchase'])->name('approved_purchase');
Route::get("Completed-Purchase",[PurchaseController::class,'completed_purchase'])->name('completed_purchase');
Route::get("Add-Purchase",[PurchaseController::class,'add_purchase'])->name('add_purchase');
Route::post("Add-Purchase",[PurchaseController::class,'store_purchase'])->name('add_purchase');
Route::get('get_purchase_list', [PurchaseController::class, 'get_purchase_list'])->name('get_purchase_list');
Route::get('Edit-Daily-Purchase/{id}', [PurchaseController::class, 'edit_daily_purchase']);
Route::post('Edit-Daily-Purchase/{id}', [PurchaseController::class, 'update_daily_purchase']);
Route::get('Edit-Pushbacked-Purchase/{id}', [PurchaseController::class, 'edit_daily_purchase']);
Route::post('Edit-Pushbacked-Purchase/{id}', [PurchaseController::class, 'update_pushbacked_purchase']);


Route::get('Reedit-Daily-Purchase/{id}', [PurchaseController::class, 'edit_daily_purchase']);
Route::post('Reedit-Daily-Purchase/{id}', [PurchaseController::class, 'update_daily_purchase_reedit']);
Route::get('Enter-Daily-Purchase/{id}', [PurchaseController::class, 'enter_daily_purchase']);
Route::post('Enter-Daily-Purchase/{id}', [PurchaseController::class, 'update_enter_daily_purchase']);
Route::get('delete_daily_purchase', [PurchaseController::class, 'delete_daily_purchase']);
//Table
Route::get("Franchise-Tables",[FranchiseTableSettingController::class,'index'])->name('franchise_tables');
Route::get('get_table', [FranchiseTableSettingController::class, 'get_table'])->name('get_table');
Route::get("add_table",[FranchiseTableSettingController::class,'create']);
Route::post("store_table",[FranchiseTableSettingController::class,'store']);
Route::get("edit_table",[FranchiseTableSettingController::class,'edit']);
Route::post("update_table",[FranchiseTableSettingController::class,'update']);
Route::get("delete_table",[FranchiseTableSettingController::class,'destroy']);
//FranchisePaymentOptionController
// Route::get("Payment-Method",[FranchisePaymentOptionController::class,'index'])->name('payment_method');
// Route::get('get_payment_method', [FranchisePaymentOptionController::class, 'get_payment_method'])->name('get_payment_method');
// Route::get("add_payment_method",[FranchisePaymentOptionController::class,'create']);
// Route::post("store_payment_method",[FranchisePaymentOptionController::class,'store']);
// Route::get("edit_payment_method",[FranchisePaymentOptionController::class,'edit']);
// Route::post("update_payment_method",[FranchisePaymentOptionController::class,'update']);
// Route::get("delete_payment_method",[FranchisePaymentOptionController::class,'destroy']);
//POS
Route::get("POS",[POSController::class,'index'])->name('pos');
Route::get("get_all_tables_with_new_status_ajax",[POSController::class,'get_all_tables_with_new_status_ajax']);
Route::post("add_customer_by_ajax",[POSController::class,'add_customer_by_ajax']);
Route::get("get_all_customers_for_this_user",[POSController::class,'get_all_customers_for_this_user']);
Route::post("get_customer_ajax",[POSController::class,'get_customer_ajax']);
Route::POST("add_sale_by_ajax",[POSController::class,'add_sale_by_ajax']);
Route::POST("remove_notication_ajax",[POSController::class,'remove_notication_ajax']);
Route::POST("get_all_information_of_a_sale_ajax",[POSController::class,'get_all_information_of_a_sale_ajax']);
Route::get("get_new_orders_ajax",[POSController::class,'get_new_orders_ajax']);
Route::get("get_new_notifications_ajax",[POSController::class,'get_new_notifications_ajax']);
Route::POST("add_temp_kot_ajax",[POSController::class,'add_temp_kot_ajax']);
Route::get("print_temp_kot/{id}",[POSController::class,'print_temp_kot']);
Route::get("print_kot/{id}",[POSController::class,'print_kot']);
Route::POST("remove_a_table_booking_ajax",[POSController::class,'remove_a_table_booking_ajax']);
Route::get("get_new_hold_number_ajax",[POSController::class,'get_new_hold_number_ajax']);
Route::POST("add_hold_by_ajax",[POSController::class,'add_hold_by_ajax']);
Route::get("get_all_holds_ajax",[POSController::class,'get_all_holds_ajax']);
Route::POST("get_single_hold_info_by_ajax",[POSController::class,'get_single_hold_info_by_ajax']);
Route::POST("delete_all_information_of_hold_by_ajax",[POSController::class,'delete_all_information_of_hold_by_ajax']);
Route::POST("delete_all_holds_with_information_by_ajax",[POSController::class,'delete_all_holds_with_information_by_ajax']);
Route::get("print_invoice/{id}",[POSController::class,'print_invoice']);
Route::get("get_last_10_sales_ajax",[POSController::class,'get_last_10_sales_ajax']);
Route::get("get_last_10_future_sales_ajax",[POSController::class,'get_last_10_future_sales_ajax']);
Route::POST("update_order_status_ajax",[POSController::class,'update_order_status_ajax']);
Route::get("printSaleBillByAjax",[POSController::class,'printSaleBillByAjax']);
Route::get("print_bill/{id}",[POSController::class,'print_bill']);
Route::POST("cancel_particular_order_ajax",[POSController::class,'cancel_particular_order_ajax']);
Route::POST("remove_multiple_notification_ajax",[POSController::class,'remove_multiple_notification_ajax']);
//KitchenController
Route::get("Kitchen",[KitchenController::class,'index'])->name('kitchen');
Route::POST("get_new_orders_ajax",[KitchenController::class,'get_new_orders_ajax']);
Route::POST("get_new_notifications_ajax",[KitchenController::class,'get_new_notifications_ajax']);
Route::POST("update_cooking_status_ajax",[KitchenController::class,'update_cooking_status_ajax']);
Route::post("update_cooking_status_delivery_take_away_ajax",[KitchenController::class,'update_cooking_status_delivery_take_away_ajax']);
Route::post("remove_notication_ajax",[KitchenController::class,'remove_notication_ajax']);
//waiter WaiterController
Route::get("Waiter",[WaiterController::class,'index'])->name('waiter');
Route::POST("get_new_notifications_ajax",[WaiterController::class,'get_new_notifications_ajax']);
Route::POST("remove_notication_ajax",[WaiterController::class,'remove_notication_ajax']);
Route::POST("remove_multiple_notification_ajax",[WaiterController::class,'remove_multiple_notification_ajax']);
//stock 
Route::get("Franchise-Stock",[FranchiseStockSalePriceController::class,'index'])->name('franchise_stock');
Route::get('get_stock_product', [FranchiseStockSalePriceController::class, 'get_stock_product'])->name('get_stock_product');

Route::get("Franchise-Food-Menu",[FoodMenuController::class,'franchise_food_menu'])->name('franchise_food_menu');
Route::get("export_stock",[FranchiseStockSalePriceController::class,'export_stock'])->name('export_stock');

//



//get_franchise_food_menu
Route::get('get_franchise_food_menu', [FoodMenuController::class, 'get_franchise_food_menu'])->name('get_franchise_food_menu');
Route::get("edit_foodmenu_price",[FoodMenuController::class,'edit_foodmenu_price']);
Route::post("update_franchise_foodmenuprice",[FoodMenuController::class,'update_franchise_foodmenuprice']);
Route::post("update_bulk_gst",[FoodMenuController::class,'update_bulk_gst']);



});