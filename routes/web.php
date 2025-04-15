<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\UtensilListController;
use App\Http\Controllers\EquipmentListController;
use App\Http\Controllers\CentralSupplyChainController;
use App\Http\Controllers\CrockeryListController;
use App\Http\Controllers\LocalPurchaseListController;
use App\Http\Controllers\FanchiseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MultiDepartmentController;
use App\Http\Controllers\MasterGstController;
use App\Http\Controllers\SupplyItemListController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\TransportChargeController;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\FactoryIngredientsController;
use App\Http\Controllers\StoreSettingController;
use App\Http\Controllers\MasterProductController;
use App\Http\Controllers\UserForgetPasswordController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\KeyContactsController;
use App\Http\Controllers\OutletPaymentMethodController;
use App\Http\Controllers\FranchiseExpenseController;

Route::get("/admin",[LoginController::class,'login_admin']);
Route::post("/admin",[LoginController::class,'login_post']);
Route::get("/login",[LoginController::class,'login_admin']);
Route::post("/login",[LoginController::class,'login_post']);
Route::get("/First-Reset-Password",[AdminController::class,'first_password_create'])->name('first_password_create');
Route::post("/First-Reset-Password",[AdminController::class,'first_password_store'])->name('first_password_create');
Route::get("/Forget-Password",[UserForgetPasswordController::class,'password_forget'])->name('password_forget');
Route::post("/User-Password-Notification",[UserForgetPasswordController::class,'user_password_forget'])->name('user_password_forget');
Route::get("/activate/{email}/{code}",[UserForgetPasswordController::class,'reset_password']);
Route::post("/activate/{email}/{code}",[UserForgetPasswordController::class,'user_password_reset']);


Route::group(['middleware'=>['login','SuperAdmin']],function(){ 
////franchise_expenses
Route::get("Franchise-Exp",[FranchiseExpenseController::class,'index'])->name('franchise_exp');
Route::get('get_franchise_exp', [FranchiseExpenseController::class, 'get_franchise_exp'])->name('get_franchise_exp');
Route::get("add_franchise_exp",[FranchiseExpenseController::class,'create']);
Route::post("store_franchise_exp",[FranchiseExpenseController::class,'store']);
Route::get("edit_franchise_exp",[FranchiseExpenseController::class,'edit']);
Route::post("update_franchise_exp",[FranchiseExpenseController::class,'update']);
Route::get("delete_franchise_exp",[FranchiseExpenseController::class,'destroy']);
//Department
Route::get("User-Department",[DepartmentController::class,'index'])->name('user_department');
Route::get('get_department', [DepartmentController::class, 'get_department'])->name('get_department');
Route::get("add_department",[DepartmentController::class,'create']);
Route::post("store_department",[DepartmentController::class,'store']);
Route::get("edit_department",[DepartmentController::class,'edit']);
Route::post("update_department",[DepartmentController::class,'update']);
Route::get("delete_department",[DepartmentController::class,'destroy']);
//Designation
Route::get("User-Designation",[DesignationController::class,'index'])->name('user_designation');
Route::get('get_designation', [DesignationController::class, 'get_designation'])->name('get_designation');
Route::get("add_designation",[DesignationController::class,'create']);
Route::post("store_designation",[DesignationController::class,'store']);
Route::get("edit_designation",[DesignationController::class,'edit']);
Route::post("update_designation",[DesignationController::class,'update']);
Route::get("delete_designation",[DesignationController::class,'destroy']);
//manage_roles
Route::get("Role",[RoleController::class,'index'])->name('role');
Route::get("Add-Role",[RoleController::class,'create'])->name('add_role');
Route::post("Add-Role",[RoleController::class,'store'])->name('add_role');
Route::get("/Role-edit/{id}",[RoleController::class,'edit']);
Route::post("/Role-edit/{id}",[RoleController::class,'updateRole']);
// Route::get("Role-Delete/{id}",[RoleController::class,'destroy']);
Route::get("Manage-Multi-Dept-Employee",[MultiDepartmentController::class,'index'])->name('manage_dept_employee');
Route::get("Add-Manage-Multi-Dept-Employee",[MultiDepartmentController::class,'create'])->name('add_user');
Route::post("Add-Manage-Multi-Dept-Employee",[MultiDepartmentController::class,'store'])->name('add_user');
Route::post("Edit-User",[MultiDepartmentController::class,'edit']);
Route::post("Manage-Multi-Dept-edit/{id}",[MultiDepartmentController::class,'update']);
Route::get("Manage-Multi-Dept-Delete/{id}",[MultiDepartmentController::class,'destroy']);

Route::get("Manage-Vendors",[MultiDepartmentController::class,'manage_vendor'])->name('manage_vendor');
Route::get("Add-Vendor",[MultiDepartmentController::class,'add_vendor'])->name('add_vendor');

Route::post("Edit-Vendor",[MultiDepartmentController::class,'edit_vendor']);
//Manage Contacts KeyContactsController
Route::get("Manage-contacts",[KeyContactsController::class,'index'])->name('key_contacts');
Route::get('get_key_contacts', [KeyContactsController::class, 'get_key_contacts'])->name('get_key_contacts');
Route::get("add_key_contacts",[KeyContactsController::class,'create']);
Route::post("store_key_contacts",[KeyContactsController::class,'store']);
Route::get("edit_key_contacts",[KeyContactsController::class,'edit']);
Route::post("update_key_contacts",[KeyContactsController::class,'update']);
Route::get("delete_key_contacts",[KeyContactsController::class,'destroy']);

//Manage_stores
Route::post("edit_wharehouse_stock",[StoresController::class,'edit_wharehouse_stock']);
Route::post("update_wharehouse_product_list",[StoresController::class,'update_wharehouse_product_list']);
Route::get("Manage-Warehouse",[StoresController::class,'manage_stores'])->name('manage_stores');
Route::get("Add-Warehouse",[StoresController::class,'add_store'])->name('add_store');
Route::post("Add-Warehouse",[StoresController::class,'save_store'])->name('add_store');
Route::post("Edit-Warehouse",[StoresController::class,'edit_store']);
Route::post("Update-Warehouse",[StoresController::class,'update_store'])->name('update_store');
Route::get("delete_store",[StoresController::class,'delete_store']);
Route::get("Manage-Warehouse-Products",[StoresController::class,'manage_store_product'])->name('manage_store_product');
Route::get("get_store_product",[StoresController::class,'get_store_product'])->name('get_store_product');
Route::post("disable_store_product",[StoresController::class,'disable_store_product']);
Route::post("enable_store_product",[StoresController::class,'enable_store_product']);
Route::get("Manage-Warehouse-Orders",[StoresController::class,'manage_store_order'])->name('manage_store_order');
Route::get("get_store_order",[StoresController::class,'get_store_order'])->name('get_store_order');

Route::get("Completed-Franchise-Orders",[StoresController::class,'completed_franchise_orders'])->name('completed_franchise_orders');
Route::get("Ongoing-Franchise-Orders",[StoresController::class,'completed_franchise_orders'])->name('ongoing_franchise_orders');
});

Route::group(['middleware'=>['login','fanchise','XSS']],function(){ 

Route::get("Manage-Staff",[MultiDepartmentController::class,'manage_staff'])->name('manage_staff');
Route::get("Add-Staff",[MultiDepartmentController::class,'add_staff'])->name('add_staff');

Route::post("Edit-Staff",[MultiDepartmentController::class,'edit_staff']);
Route::post("Edit-Franchise-Staff",[MultiDepartmentController::class,'edit_user']);
});

 Route::group(['middleware'=>['login']],function(){ 
Route::get("Dashboard",[AdminController::class,'dashboard'])->name('admin_dashboard');
Route::get("Fanchise-list",[FanchiseController::class,'fanchise_list'])->name('fanchise_list');
Route::get("Add-Fanchise",[FanchiseController::class,'add_fanchise'])->name('add_fanchise');

Route::get('fanchise_data', [FanchiseController::class, 'fanchise_data'])->name('fanchise_data');
Route::get("Fanchise-Edit/{id}",[FanchiseController::class,'edit']);

Route::get("my-notification/{type}",[FanchiseController::class,'myNotification']);

Route::post("/logout",[LoginController::class,'logout']);
Route::get("/Change-Password",[LoginController::class,'change_password'])->name('change_password');
Route::post("/Change-Password",[LoginController::class,'admin_psw_save']);
//multidepartment

Route::get("get_dist",[MultiDepartmentController::class,'get_dist']);
Route::get("get_city",[MultiDepartmentController::class,'get_city']);
Route::post("user_register",[MultiDepartmentController::class,'user_register']);
Route::post("user_register_update",[MultiDepartmentController::class,'user_register_update']);
Route::post("disable_user",[MultiDepartmentController::class,'disable_user']);
Route::post("enable_user",[MultiDepartmentController::class,'enable_user']);
Route::post("delete_user",[MultiDepartmentController::class,'delete_user']);


//Manage Factory
Route::get("Manage-Factory",[StoresController::class,'manage_factory'])->name('manage_factory');
Route::get("Add-Factory",[StoresController::class,'add_factory'])->name('add_factory');
Route::post("Add-Factory",[StoresController::class,'save_factory'])->name('add_factory');
Route::post("Edit-Factory",[StoresController::class,'edit_factory']);
Route::post("Update-Factory",[StoresController::class,'update_factory'])->name('update_factory');
Route::get("Manage-Factory-Products",[StoresController::class,'manage_factory_product'])->name('manage_factory_product');
Route::get("Manage-Vendor-Products",[StoresController::class,'manage_vendor_product'])->name('manage_vendor_product');
Route::get("get_factory_product",[StoresController::class,'get_factory_product'])->name('get_factory_product');
Route::get("get_vendor_product",[StoresController::class,'get_vendor_product'])->name('get_vendor_product');
Route::get("Manage-Factory-Orders",[StoresController::class,'manage_factory_orders'])->name('manage_factory_orders');
Route::get("Factory-Orders-Dispatched",[StoresController::class,'manage_factory_orders'])->name('manage_factory_dispatched');
Route::get("Factory-Orders-Delivered",[StoresController::class,'manage_factory_orders'])->name('manage_factory_delivered');
//
Route::get("Manage-Vendor-Orders",[StoresController::class,'manage_vendor_orders'])->name('manage_vendor_orders');
Route::get("Vendor-Orders-Dispatched",[StoresController::class,'manage_vendor_orders'])->name('manage_vendor_dispatched');
Route::get("Vendor-Orders-Delivered",[StoresController::class,'manage_vendor_orders'])->name('manage_vendor_delivered');

//
Route::get("get_factory_outlet_orders",[StoresController::class,'get_factory_outlet_orders'])->name('get_factory_outlet_orders');
Route::get("get_vendor_outlet_orders",[StoresController::class,'get_vendor_outlet_orders'])->name('get_vendor_outlet_orders');

Route::get("New-Factory-Orders-From-Wharehouse",[StoresController::class,'new_factory_order_from_wharehouse'])->name('new_factory_order_from_wharehouse');

Route::get("Ongoing-Factory-Orders-From-Wharehouse",[StoresController::class,'new_factory_order_from_wharehouse'])->name('ongoing_factory_order_from_wharehouse');
Route::get("Dispatched-Factory-Orders-From-Wharehouse",[StoresController::class,'new_factory_order_from_wharehouse'])->name('dispatched_factory_order_from_wharehouse');
Route::get("Delivered-Factory-Orders-From-Wharehouse",[StoresController::class,'new_factory_order_from_wharehouse'])->name('delivered_factory_order_from_wharehouse');
//
Route::get("New-Vendor-Orders-From-Wharehouse",[StoresController::class,'new_vendor_order_from_wharehouse'])->name('new_vendor_order_from_wharehouse');

Route::get("Ongoing-Vendor-Orders-From-Wharehouse",[StoresController::class,'new_vendor_order_from_wharehouse'])->name('ongoing_vendor_order_from_wharehouse');
Route::get("Dispatched-Vendor-Orders-From-Wharehouse",[StoresController::class,'new_vendor_order_from_wharehouse'])->name('dispatched_vendor_order_from_wharehouse');
Route::get("Delivered-Vendor-Orders-From-Wharehouse",[StoresController::class,'new_vendor_order_from_wharehouse'])->name('delivered_vendor_order_from_wharehouse');

//
Route::get("New-Vendor-Orders-From-Factory",[StoresController::class,'new_vendor_order_from_factory'])->name('new_vendor_order_from_factory');

Route::get("Ongoing-Vendor-Orders-From-Factory",[StoresController::class,'new_vendor_order_from_factory'])->name('ongoing_vendor_order_from_factory');
Route::get("Dispatched-Vendor-Orders-From-Factory",[StoresController::class,'new_vendor_order_from_factory'])->name('dispatched_vendor_order_from_factory');
Route::get("Delivered-Vendor-Orders-From-Factory",[StoresController::class,'new_vendor_order_from_factory'])->name('delivered_vendor_order_from_factory');
//

Route::get("get_factory_wharehouse_orders",[StoresController::class,'get_factory_wharehouse_orders'])->name('get_factory_wharehouse_orders');
Route::get("get_vendor_factory_orders",[StoresController::class,'get_vendor_factory_orders'])->name('get_vendor_factory_orders');

Route::post("send_quote_by_factory_to_accounts",[StoresController::class,'send_quote_by_factory_to_accounts']);
Route::post("send_quote_by_vendor_to_accounts",[StoresController::class,'send_quote_by_vendor_to_accounts']);

Route::post("update_cost_est_factory",[StoresController::class,'update_cost_est_factory']);
Route::post("update_cost_est_vendor",[StoresController::class,'update_cost_est_vendor']);

Route::post("accounts_view_and_accept_wharehouse_order",[StoresController::class,'accounts_view_and_accept_wharehouse_order']);

Route::post("accounts_view_and_accept_factory_order",[StoresController::class,'accounts_view_and_accept_factory_order']);


Route::post("whare_house_order_view",[StoresController::class,'whare_house_order_view']);

Route::post("factory_order_view",[StoresController::class,'factory_order_view']);

Route::post("update_accept_status_by_accounts",[StoresController::class,'update_accept_status_by_accounts']);
Route::post("update_factory_accept_status_by_accounts",[StoresController::class,'update_factory_accept_status_by_accounts']);
Route::post("final_accept_status_by_factory_vendor",[StoresController::class,'final_accept_status_by_factory_vendor']);
Route::post("final_accept_status_by_vendor",[StoresController::class,'final_accept_status_by_vendor']);

Route::post("accounts_view_and_verify_collection_details",[StoresController::class,'accounts_view_and_verify_collection_details']);
Route::post("update_delivered_status_by_accounts",[StoresController::class,'update_delivered_status_by_accounts']);
Route::post("update_factory_delivered_status_by_accounts",[StoresController::class,'update_factory_delivered_status_by_accounts']);
Route::post("accounts_view_and_verify_collection_details_factory",[StoresController::class,'accounts_view_and_verify_collection_details_factory']);
//

Route::get("Factory-Ingredients",[FactoryIngredientsController::class,'factory_ingredients'])->name('factory_ingredients');
Route::get("get_factory_ingredients_data",[FactoryIngredientsController::class,'get_factory_ingredients_data'])->name('get_factory_ingredients_data');
Route::post("create_factory_ingredients",[FactoryIngredientsController::class,'create_factory_ingredients']);
Route::post("add_factory_ingredients",[FactoryIngredientsController::class,'add_factory_ingredients']);
Route::post("edit_factory_ingredients",[FactoryIngredientsController::class,'edit_factory_ingredients']);
Route::post("update_factory_ingredients",[FactoryIngredientsController::class,'update_factory_ingredients']);
Route::get("get_ingredients_list",[FactoryIngredientsController::class,'get_ingredients_list']);
Route::get("add_edit_product_ingredients",[FactoryIngredientsController::class,'add_edit_product_ingredients']);
Route::post("add_product_ingredients",[FactoryIngredientsController::class,'add_product_ingredients']);

//Ingredients
Route::get("Ingredients",[IngredientController::class,'index'])->name('ingredients');
Route::get('ingredients_list', [IngredientController::class, 'ingredients_list'])->name('ingredients_list');
Route::get("Add-Ingredients",[IngredientController::class,'create'])->name('add_ingredients');
Route::post("Add-Ingredients",[IngredientController::class,'store']);
Route::get("Ingredient-Edit/{id}",[IngredientController::class,'edit']);
Route::post("Ingredient-Edit/{id}",[IngredientController::class,'update']);
Route::get("Ingredient-Delete/{id}",[IngredientController::class,'destroy']);
//UtensilList

Route::get('utensil', [UtensilListController::class, 'utensil'])->name('utensil');
Route::get("Add-Utensil-List",[UtensilListController::class,'create'])->name('add_utensil');
Route::post("Add-Utensil-List",[UtensilListController::class,'store']);
Route::get("UtensilList-Edit/{id}",[UtensilListController::class,'edit']);
Route::post("UtensilList-Edit/{id}",[UtensilListController::class,'update']);
Route::get("UtensilList-Delete/{id}",[UtensilListController::class,'destroy']);
Route::post("uploads_list_image",[UtensilListController::class,'uploads_list_image']);
Route::post("get_item_image",[UtensilListController::class,'get_item_image']);
Route::post("delete_item_image",[UtensilListController::class,'delete_item_image']);
Route::post("edit_first_stock",[UtensilListController::class,'edit_first_stock']);
Route::post("update_first_stock",[UtensilListController::class,'update_first_stock']);
//supply item list

Route::get("Add-supply-List",[SupplyItemListController::class,'create'])->name('add_supplylist');
Route::post("Add-supply-List",[SupplyItemListController::class,'store']);
Route::get("SupplyList-Edit/{id}",[SupplyItemListController::class,'edit']);
Route::post("SupplyList-Edit/{id}",[SupplyItemListController::class,'update']);
Route::get("SupplyList-Delete/{id}",[SupplyItemListController::class,'destroy']);
Route::post("edit_supply_list",[SupplyItemListController::class,'edit_supply_list']);
Route::post("update_supply_list",[SupplyItemListController::class,'update_supply_list']);
 
//EquipmentList
Route::get("Equipment-List",[EquipmentListController::class,'index'])->name('equipment_list');
Route::get('Equipment', [EquipmentListController::class, 'equipment'])->name('equipment');
Route::get("Add-Equipment-List",[EquipmentListController::class,'create'])->name('add_equipment');
Route::post("Add-Equipment-List",[EquipmentListController::class,'store']);
Route::get("EquipmentList-Edit/{id}",[EquipmentListController::class,'edit']);
Route::post("EquipmentList-Edit/{id}",[EquipmentListController::class,'update']);
Route::get("EquipmentList-Delete/{id}",[EquipmentListController::class,'destroy']);
//CrockeryList
Route::get("Crockery-List",[CrockeryListController::class,'index'])->name('crockery_list');
Route::get('Crockery', [CrockeryListController::class, 'crockery'])->name('crockery');
Route::get("Add-Crockery-List",[CrockeryListController::class,'create'])->name('add_crockery');
Route::post("Add-Crockery-List",[CrockeryListController::class,'store']);
Route::get("CrockeryList-Edit/{id}",[CrockeryListController::class,'edit']);
Route::post("CrockeryList-Edit/{id}",[CrockeryListController::class,'update']);
Route::get("CrockeryList-Delete/{id}",[CrockeryListController::class,'destroy']);
//central_supply_chain
Route::get("Central-Supply-Chain-List",[CentralSupplyChainController::class,'index'])->name('central_supply_chain_list');
Route::get('Central-Supply-Chain', [CentralSupplyChainController::class, 'central_supply_chain'])->name('central_supply_chain');
Route::get("Add-Central-Supply-Chain-List",[CentralSupplyChainController::class,'create'])->name('add_central_supply_chain');
Route::post("Add-Central-Supply-Chain-List",[CentralSupplyChainController::class,'store']);
Route::get("Central-Supply-Chain-Edit/{id}",[CentralSupplyChainController::class,'edit']);
Route::post("Central-Supply-Chain-Edit/{id}",[CentralSupplyChainController::class,'update']);
Route::get("Central-Supply-Chain-Delete/{id}",[CentralSupplyChainController::class,'destroy']);
//local_purchase_lists
Route::get("Local-Purchase-List",[LocalPurchaseListController::class,'index'])->name('local_purchase');
Route::get('Local-Purchase', [LocalPurchaseListController::class, 'local_purchase_list'])->name('local_purchase_list');
Route::get("Add-Local-Purchase-List",[LocalPurchaseListController::class,'create'])->name('add_local_purchase_list');
Route::post("Add-Local-Purchase-List",[LocalPurchaseListController::class,'store']);
Route::get("Local-Purchase-Edit/{id}",[LocalPurchaseListController::class,'edit']);
Route::post("Local-Purchase-Edit/{id}",[LocalPurchaseListController::class,'update']);
Route::get("Local-Purchase-Delete/{id}",[LocalPurchaseListController::class,'destroy']);
//
//
Route::get("User-Account",[MultiDepartmentController::class,'user_account'])->name('user_account');
Route::post("Edit-User-Account",[MultiDepartmentController::class,'edit_user']);
Route::post("Edit-Account",[MultiDepartmentController::class,'edit_user']);
Route::post("Edit-Vendor-Account",[MultiDepartmentController::class,'edit_user']);

Route::post("Store-User-Data",[MultiDepartmentController::class,'store_user_data'])->name('store_user_data');
Route::post("store_user_data_step",[MultiDepartmentController::class,'store_user_data_step']);
});

Route::get("/",[LoginController::class,'home']);
Route::get("/about-us",[LoginController::class,'about'])->name('about');
Route::get("/restaurant-billing-software",[LoginController::class,'pos_front'])->name('pos_front');
Route::get("/qsr-software",[LoginController::class,'qsr'])->name('qsr');
Route::get("/restaurant-inventory-software",[LoginController::class,'mms'])->name('mms');
Route::get("/contact-us",[LoginController::class,'contact'])->name('contact');