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
use App\Http\Controllers\RegionSettingController;
use App\Http\Controllers\FranchiseStockSalePriceController;

Route::group(['middleware'=>['login']],function(){ 
//Master Product List
Route::get("All-Products-List",[MasterProductController::class,'index'])->name('all_products');
Route::get('get_product', [MasterProductController::class, 'get_product'])->name('get_product');
Route::post('export_master_product', [MasterProductController::class, 'export_master_product'])->name('export_master_product');
Route::get("add_product",[MasterProductController::class,'create'])->name('add_product');


Route::post("store_product",[MasterProductController::class,'store'])->name('store_product');
Route::post("edit_product_list",[MasterProductController::class,'edit_product_list']);
Route::post("update_product_list",[MasterProductController::class,'update_product_list']);
Route::get("Product-Delete/{id}",[MasterProductController::class,'destroy']);
//

Route::post("edit_stock_list",[MasterProductController::class,'edit_stock_list']);
Route::post("update_stock_list",[MasterProductController::class,'update_stock_list']);
Route::get("get_import_stock_form",[MasterProductController::class,'get_import_stock_form'])->name('get_import_stock_form');
Route::post("store_stock_by_excel",[MasterProductController::class,'store_stock_by_excel'])->name('store_stock_by_excel');

});


Route::group(['middleware'=>['login','SuperAdmin']],function(){ 






Route::get("get_brand_list",[MasterProductController::class,'get_brand_list']);

Route::get("Firsttime-Stock-List",[MasterProductController::class,'first_time_stock'])->name('first_time_stock');
Route::get('first_stock', [MasterProductController::class, 'first_stock'])->name('first_stock');
Route::get("Supply-Item-List",[MasterProductController::class,'supplyitem_list'])->name('supplyitem_list');
Route::get('supplylist', [MasterProductController::class, 'supplylist'])->name('supplylist');
//Master Gst
Route::get("GST-List",[MasterGstController::class,'index'])->name('gst_list');
Route::get('GST', [MasterGstController::class, 'gst'])->name('gst');
Route::get("Add-GST-List",[MasterGstController::class,'create'])->name('add_gst');
Route::post("Add-GST-List",[MasterGstController::class,'store']);
Route::get("GSTList-Edit/{id}",[MasterGstController::class,'edit']);
Route::post("GSTList-Edit/{id}",[MasterGstController::class,'update']);
Route::get("GSTList-Delete/{id}",[MasterGstController::class,'destroy']);
//Brands
Route::get("Brand-List",[BrandsController::class,'index'])->name('brand_list');
Route::get('Brand', [BrandsController::class, 'brand'])->name('brand');
Route::get("Add-Brand-List",[BrandsController::class,'create'])->name('add_brand');
Route::post("Add-Brand-List",[BrandsController::class,'store']);
Route::get("Brand-Edit/{id}",[BrandsController::class,'edit']);
Route::post("Brand-Edit/{id}",[BrandsController::class,'update']);
Route::get("Brand-Delete/{id}",[BrandsController::class,'destroy']);
//Unit
Route::get("Unit-List",[UnitController::class,'index'])->name('unit_list');
Route::get('Unit', [UnitController::class, 'unit'])->name('unit');
Route::get("Add-Unit-List",[UnitController::class,'create'])->name('add_unit');
Route::post("Add-Unit-List",[UnitController::class,'store']);
Route::get("Unit-Edit/{id}",[UnitController::class,'edit']);
Route::post("Unit-Edit/{id}",[UnitController::class,'update']);
Route::get("Unit-Delete/{id}",[UnitController::class,'destroy']);
//POS-PaymentMethod
Route::get("POS-PaymentMethod",[OutletPaymentMethodController::class,'index'])->name('pos_payment_menthod');
Route::get('get_pos_payment_menthod', [OutletPaymentMethodController::class, 'get_pos_payment_menthod'])->name('get_pos_payment_menthod');
Route::get("Add-POS-PaymentMethod",[OutletPaymentMethodController::class,'create'])->name('add_payment_method');
Route::post("Add-POS-PaymentMethod",[OutletPaymentMethodController::class,'store']);
Route::get("POSPaymentMethod-Edit/{id}",[OutletPaymentMethodController::class,'edit']);
Route::post("POSPaymentMethod-Edit/{id}",[OutletPaymentMethodController::class,'update']);
Route::get("POSPaymentMethod-Delete/{id}",[OutletPaymentMethodController::class,'destroy']);
//Region
Route::get("Region",[RegionSettingController::class,'index'])->name('region');
Route::get('get_region', [RegionSettingController::class, 'get_region'])->name('get_region');
Route::get("Add-Region",[RegionSettingController::class,'create'])->name('add_region');
Route::post("Add-Region",[RegionSettingController::class,'store']);
Route::get("Region-Edit/{id}",[RegionSettingController::class,'edit']);
Route::post("Region-Edit/{id}",[RegionSettingController::class,'update']);
Route::get("Region-Delete/{id}",[RegionSettingController::class,'destroy']);
//TransportChargeController
Route::get("TransportCharge-List",[TransportChargeController::class,'index'])->name('transport_list');
Route::get('TransportCharge', [TransportChargeController::class, 'transport'])->name('transport');
Route::get("Add-TransportCharge-List",[TransportChargeController::class,'create'])->name('add_transport');
Route::post("Add-TransportCharge-List",[TransportChargeController::class,'store']);
Route::get("TransportCharge-Edit/{id}",[TransportChargeController::class,'edit']);
Route::post("TransportCharge-Edit/{id}",[TransportChargeController::class,'update']);
Route::get("TransportCharge-Delete/{id}",[TransportChargeController::class,'destroy']);
//City Manage
Route::get("Manage-City",[CityController::class,'index'])->name('add_city');
Route::get('get_city_data', [CityController::class, 'get_city'])->name('get_city');
Route::post('city_save', [CityController::class, 'city_save']);
Route::get('edit-city', [CityController::class, 'edit_city']);
Route::post('update_city', [CityController::class, 'update_city']);
Route::get('delete-city', [CityController::class, 'delete_city']);
//store setting
Route::get("Warehouse-Setting",[StoreSettingController::class,'index'])->name('warehouse_setting');
Route::get("store_setting_status",[StoreSettingController::class,'store_setting_status']);

});