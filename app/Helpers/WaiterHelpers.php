<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Crypt;
use DB;
use Sentinel;
use App\Models\FoodMenuCategory;
use App\Models\AssignFoodMenuCategoryToBrands;
use App\Models\FanchiseRegistration;
class WaiterHelpers 
{

   public static function getNotificationByOutletId($outlet_id)
    {
    	$result=DB::table('franchise_notifications')->where("outlet_id", $outlet_id)->orderBy('id', 'ASC')->get();
      
        if($result != false){
          return $result;
        }else{
          return false;
        }

    
    }
 
}