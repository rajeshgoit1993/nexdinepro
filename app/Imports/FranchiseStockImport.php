<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\AssignFoodMenuIngredient;
use Sentinel;
use DB;
use App\Helpers\CustomHelpers;
use App\Helpers\POS_SettingHelpers;
use App\Models\FranchiseStockSalePrice;
use App\Models\PhysicalEntry;
use App\Models\MasterProduct;

class FranchiseStockImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function __construct($outlet_id)
    {

        $this->outlet_id = $outlet_id;
         
    }

    public function collection(Collection $collection)
    {
       $outlet_id=$this->outlet_id;
       $today=date('d-m-Y');
       $previous_data=PhysicalEntry::where('outlet_id',$outlet_id)->whereDate('date',date('Y-m-d'))->delete();
       
       foreach($collection as $row){

          if(isset($row['item_code']) && $row['item_code']!=''):


            $product_id=$row['item_code'];
            $stock_data=MasterProduct::where([['outlet_id',$outlet_id],['item_code',$product_id]])->first();

            $consuption_sum=DB::table('franchise_sale_consuptions_of_menus')
         ->where([['outlet_id',(int)$outlet_id],['ingredient_id',(int)$product_id],['sync_status',0]])->sum('consumption');
          
   $waste_sum=DB::table('waste_ingredients')
         
           ->where([['outlet_id',(int)$outlet_id],['ingredient_id',(int)$product_id],['sync_status',0]])->sum('waste_amount');
       $total_waste=(float)$consuption_sum+(float)$waste_sum;

            $available_qty=(float)$stock_data->available_qty-(float)$total_waste;
          
            PhysicalEntry::create([
                'date'=>date('Y-m-d'),
                'outlet_id'=>$outlet_id,
                'ingredient_id'=>isset($row['item_code']) ? $row['item_code'] : '',
                'auto_data'=>$available_qty,
                'entry_type'=>1,
                'physical_data'=>isset($row['physical_stock']) ? $row['physical_stock'] : '',
               
            ]);





          endif;
            
            

        }

    }
}
