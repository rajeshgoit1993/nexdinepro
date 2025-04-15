<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Crypt;
use DB;
use Sentinel;
use App\Models\FoodMenuCategory;
use App\Models\AssignFoodMenuCategoryToBrands;
use App\Models\FanchiseRegistration;
class KitchenHelpers 
{

  public static function getNewOrders($outlet_id){

  	 $result = DB::table('franchise_sales')
  	           ->leftJoin('franchise_table_settings','franchise_table_settings.id' , '=', 'franchise_sales.table_id')
               ->leftJoin('users','users.id' , '=', 'franchise_sales.waiter_id')
               
               ->leftJoin('franchise_customers','franchise_customers.id' , '=', 'franchise_sales.customer_id')
            ->where("franchise_sales.outlet_id", $outlet_id)
            ->whereIn('order_status',[1,3])
             ->select('*','franchise_sales.id as sale_id','franchise_customers.name as customer_name','franchise_sales.id as sales_id','users.name as waiter_name','franchise_table_settings.name as table_name')
             ->orderBy('franchise_sales.id', 'ASC')
             ->get();

      
        return $result;
    }
    public static function get_total_kitchen_type_items($sale_id)
    {
    	$result=DB::table('franchise_sales_details')->where([["sales_id", $sale_id],["item_type", "Kitchen Item"]])->get();
        
        return count($result);    
    }
    public static function get_total_kitchen_type_done_items($sale_id)
    {
    	$result=DB::table('franchise_sales_details')->where([["sales_id", $sale_id],["item_type", "Kitchen Item"],["cooking_status", "Done"]])->get();
        
        return count($result); 
  
    }
    public static function get_total_kitchen_type_started_cooking_items($sale_id)
    {
    	$result=DB::table('franchise_sales_details')->where([["sales_id", $sale_id],["item_type", "Kitchen Item"],["cooking_status", "Started Cooking"]])->get();
        
        return count($result); 

       
    }
    public static function get_all_tables_of_a_sale_items($sale_id)
    {
    	 $result = DB::table('pos_order_tables')
  	           ->leftJoin('franchise_table_settings','franchise_table_settings.id' , '=', 'pos_order_tables.table_id')
              
            ->where("sale_id", $sale_id)
           
             ->select('franchise_table_settings.name as table_name')
           
             ->get();

     
      return $result;
      
    }
    public static function getAllKitchenItemsFromSalesDetailBySalesId($sales_id){

    	$result = DB::table('franchise_sales_details')
  	           ->leftJoin('food_menus','food_menus.id' , '=', 'franchise_sales_details.food_menu_id')
              
            ->where([["sales_id", $sales_id],["item_type", "Kitchen Item"]])
           
             ->select('franchise_sales_details.*','franchise_sales_details.id as sales_details_id','food_menus.code as code','food_menus.name as menu_name')
            ->orderBy('franchise_sales_details.id', 'ASC')
             ->get();

     
      return $result;

       
    }
    public static function getModifiersBySaleAndSaleDetailsId($sales_id,$sale_details_id){
    	$result = DB::table('franchise_sale_details_modifiers')
  	           ->leftJoin('franchise_modifiers','franchise_modifiers.id' , '=', 'franchise_sale_details_modifiers.modifier_id')
              
            ->where([["franchise_sale_details_modifiers.sales_id", $sales_id],["franchise_sale_details_modifiers.sales_details_id", $sale_details_id]])
           
             ->select('franchise_sale_details_modifiers.*','franchise_modifiers.name')
            ->orderBy('franchise_sale_details_modifiers.id', 'ASC')
             ->get();

     
      return $result;

  
    }
    public static function getNotificationByOutletId($outlet_id)
    {
    	$result=DB::table('franchise_notification_bar_kitchen_panels')->where("outlet_id", $outlet_id)->orderBy('id', 'ASC')->get();

     
      return $result; 
    }
  public static function getItemInfoByPreviousId($previous_id)
    {
    	$result = DB::table('franchise_sales_details')
  	           ->leftJoin('food_menus','food_menus.id' , '=', 'franchise_sales_details.food_menu_id')
              
            ->where("previous_id", $previous_id)
           
             ->select('franchise_sales_details.*','food_menus.code as code','food_menus.name as menu_name')
            ->orderBy('franchise_sales_details.id', 'ASC')
             ->first();

        return $result;   
    }
    public static function getSaleBySaleId($sales_id){

       $result = DB::table('franchise_sales')
              ->leftJoin('franchise_customers','franchise_customers.id' , '=', 'franchise_sales.customer_id')
  	           
               ->leftJoin('users','users.id' , '=', 'franchise_sales.user_id')
               ->leftJoin('franchise_table_settings','franchise_table_settings.id' , '=', 'franchise_sales.table_id') 
               ->leftJoin('users as w','w.id' , '=', 'franchise_sales.waiter_id') 
            ->where("franchise_sales.id", $sales_id)
           
             ->select('franchise_sales.*','users.name as user_name','franchise_customers.name as customer_name','franchise_sales.id as sales_id','w.name as waiter_name','franchise_table_settings.name as table_name')
             ->orderBy('franchise_sales.id', 'ASC')
             ->get();

        
        return $result;
    }
}