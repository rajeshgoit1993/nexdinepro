<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeekoffController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\AttendenceController;
use App\Http\Controllers\HRMSShiftController;
use App\Http\Controllers\OfficeAddressController;

Route::group(['middleware'=>['login','SuperAdmin']],function(){ 

//Shift
Route::get("Office",[OfficeAddressController::class,'index'])->name('office');
Route::get('get_office', [OfficeAddressController::class, 'get_office'])->name('get_office');
Route::get("add_office",[OfficeAddressController::class,'create']);
Route::post("store_office",[OfficeAddressController::class,'store']);
Route::get("edit_office",[OfficeAddressController::class,'edit']);
Route::post("update_office",[OfficeAddressController::class,'update']);
Route::get("delete_office",[OfficeAddressController::class,'destroy']);
//Shift
Route::get("Shift",[HRMSShiftController::class,'index'])->name('shift');
Route::get('get_shift', [HRMSShiftController::class, 'get_shift'])->name('get_shift');
Route::get("add_shift",[HRMSShiftController::class,'create']);
Route::post("store_shift",[HRMSShiftController::class,'store']);
Route::get("edit_shift",[HRMSShiftController::class,'edit']);
Route::post("update_shift",[HRMSShiftController::class,'update']);
Route::get("delete_shift",[HRMSShiftController::class,'destroy']);

//weekoff
Route::get("Weekoff",[WeekoffController::class,'index'])->name('weekoff');
Route::get('get_weekoff', [WeekoffController::class, 'get_weekoff'])->name('get_weekoff');
Route::get("add_weekoff",[WeekoffController::class,'create']);
Route::post("store_weekoff",[WeekoffController::class,'store']);
Route::get("edit_weekoff",[WeekoffController::class,'edit']);
Route::post("update_weekoff",[WeekoffController::class,'update']);
Route::get("delete_weekoff",[WeekoffController::class,'destroy']);
//Holiday
Route::get("Holiday",[HolidayController::class,'index'])->name('holiday');
Route::get('get_holiday', [HolidayController::class, 'get_holiday'])->name('get_holiday');
Route::get("add_holiday",[HolidayController::class,'create']);
Route::post("store_holiday",[HolidayController::class,'store'])->name('store_holiday');
Route::get("edit_holiday",[HolidayController::class,'edit']);
Route::post("update_holiday",[HolidayController::class,'update']);
Route::get("delete_holiday",[HolidayController::class,'destroy']);
//attendence
Route::get("Attendence",[AttendenceController::class,'index'])->name('attendence');
Route::get("get_attendence_details",[AttendenceController::class,'get_attendence_details'])->name('get_attendence_details');
Route::post("store_admin_attendence",[AttendenceController::class,'store_admin_attendence']);
Route::get("get_filter_attendence",[AttendenceController::class,'get_filter_attendence'])->name('get_filter_attendence');


});

Route::get("Attendence-Picture",[AttendenceController::class,'attendence_picture'])->name('attendence_picture');
Route::post("save_attendence_picture",[AttendenceController::class,'save_attendence_picture'])->name('save_attendence_picture');
