<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Session;
use Sentinel;
use DB;
use App\Models\BirthdayNotification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FoodMenu;
use App\Helpers\CustomHelpers;
use App\Helpers\POS_SettingHelpers;
use App\Models\Waste;
use App\Models\WasteIngredient;
use App\Models\FranchiseStockSalePrice;
use App\Models\PhysicalEntry;
use App\Models\FranchiseSaleConsuptionsOfMenu;

class AutoTaskSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom_tast:auto_task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Auto Task';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

          

         $today_day_month = date('m-d');
       $today_all=User::whereIn('registration_level',[0,1,2,3])->birthdayBetween($today_day_month, $today_day_month)->orderBy('birthday', 'asc')->get();
          
       foreach($today_all as $today_birthday):
        $data_check=BirthdayNotification::where([['user_id','=',(int)$today_birthday->id],['notification','=',0]])->birthdayBetween($today_day_month,$today_day_month)->first();
        
         if($data_check==''):
          $data=new BirthdayNotification;
          $data->user_id=$today_birthday->id;
          $data->dob=date('Y-m-d');
          $data->notification=0;
          $data->save();
         endif;
       endforeach;
      //
     $food_menues = FoodMenu::latest()->get();
     foreach($food_menues as $row)
     {
     $cp_data=POS_SettingHelpers::get_food_menu_cp($row->id);
     $new_data=FoodMenu::find($row->id);
     $new_data->cp_data=serialize($cp_data);
     $new_data->save();
     }
    //daily entry purchase
     $outlet_id_by_stocks=DB::table('franchise_stock_sale_prices')->distinct()->pluck('outlet_id');
     foreach($outlet_id_by_stocks as $outlet_ids)
     {
      $outlets_products=DB::table('franchise_stock_sale_prices')->where('outlet_id',$outlet_ids)->get();
      foreach($outlets_products as $products)
      {
        $product_id=$products->product_id;

        $consuption_sum=DB::table('franchise_sale_consuptions_of_menus')
         ->where([['outlet_id',(int)$outlet_ids],['ingredient_id',(int)$product_id],['sync_status',0]])->sum('consumption');
          
       $waste_sum=DB::table('waste_ingredients')
         
           ->where([['outlet_id',(int)$outlet_ids],['ingredient_id',(int)$product_id],['sync_status',0]])->sum('waste_amount');
       $total_waste=(float)$consuption_sum+(float)$waste_sum;


       $outlet_stock = FranchiseStockSalePrice::where([['outlet_id','=',(int)$outlet_ids],['product_id',$product_id]])->first();
         if($outlet_stock!='')
         {
         if($outlet_stock->available_qty!='')
         {
          $available_qty=$outlet_stock->available_qty;
         }
         else
         {
           $available_qty=0;
         }
         
         $sum=(float)$available_qty-(float)$total_waste;
         $outlet_stock->available_qty=$sum;
         $outlet_stock->save();
         }
         
       FranchiseSaleConsuptionsOfMenu::where([['outlet_id',(int)$outlet_ids],['ingredient_id',(int)$product_id],['sync_status',0]])->update(['sync_status' => 1]);
       WasteIngredient::where([['outlet_id',(int)$outlet_ids],['ingredient_id',(int)$product_id],['sync_status',0]])->update(['sync_status' => 1]);

      }
      
     }


     // $waste_datas=Waste::where('sync_status',0)->get();
     // foreach($waste_datas as $waste_data)
     // {
     //    $outlet_id=$waste_data->outlet_id;
     //    $waste_id=$waste_data->id;

     //    $waste_ingredients=WasteIngredient::where('waste_id',$waste_id)->get();
     //    foreach($waste_ingredients as $waste_ingredient)
     //    {
     //     $waste_ingredient_id=$waste_ingredient->ingredient_id;
     //     $outlet_stock = FranchiseStockSalePrice::where([['outlet_id','=',(int)$outlet_id],['product_id',$waste_ingredient_id]])->first();
     //     if($outlet_stock!='')
     //     {
     //     if($outlet_stock->available_qty!='')
     //     {
     //      $available_qty=$outlet_stock->available_qty;
     //     }
     //     else
     //     {
     //       $available_qty=0;
     //     }
         
     //     $sum=(float)$available_qty-(float)$waste_ingredient->waste_amount;
     //     $outlet_stock->available_qty=$sum;
     //     $outlet_stock->save();
     //     }
     //    }
     //    $waste_find=Waste::find($waste_data->id);
     //    $waste_find->sync_status=1;
     //    $waste_find->save();
     
     // } 
     
    $physical_datas=PhysicalEntry::where([['sync_status',0],['area_manager_approval',1]])->get();
   
    foreach($physical_datas as $physical_data)
     {
     $outlet_id=$physical_data->outlet_id;
     $ingredient_id=$physical_data->ingredient_id;
     $outlet_stock = FranchiseStockSalePrice::where([['outlet_id','=',(int)$outlet_id],['product_id',$ingredient_id]])->first();
       if($outlet_stock!='')
         {
        
         $outlet_stock->available_qty=$physical_data->physical_data;
         $outlet_stock->save();
         }
        $physical_find=PhysicalEntry::find($physical_data->id);
        $physical_find->sync_status=1;
        $physical_find->save();
     }
     // 

    }
}
