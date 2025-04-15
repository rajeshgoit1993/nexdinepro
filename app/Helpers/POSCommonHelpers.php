<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Crypt;
use DB;
use Sentinel;
use App\Models\FoodMenuCategory;
use App\Models\AssignFoodMenuCategoryToBrands;
use App\Models\FanchiseRegistration;
class POSCommonHelpers 
{

  public static function getAllByCompanyIdForDropdown($outlet_id, $table_name) {

  	$result=DB::table($table_name)->where([['outlet_id',$outlet_id],['del_status','Live']])->get();

    
        return $result;
    }
    public static function getDataById($id, $table_name) {
      

        $result=DB::table($table_name)->where('id',$id)->first();

        return $result;
    }
     public static function updateInformation($data, $id, $table_name) {
      
        DB::table($table_name)->where('id', $id)->update($data);
    }

}