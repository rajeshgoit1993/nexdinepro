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

class RecipeImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function __construct($food_menu_id)
    {

        $this->food_menu_id = $food_menu_id;
         
    }

    public function collection(Collection $collection)
    {
       $food_menu_id=$this->food_menu_id;
       $previous_data=AssignFoodMenuIngredient::where('food_menu_id','=',$food_menu_id)->delete();

       foreach($collection as $row){

        //     print_r($row);
           if(isset($row['item_code']) && CustomHelpers::get_master_table_data('master_products','item_code',$row['item_code'],'id')!='NA'):
            AssignFoodMenuIngredient::create([
                'ingredient_id'=>isset($row['item_code']) ? CustomHelpers::get_master_table_data('master_products','item_code',$row['item_code'],'id') : '',
                'consumption'=>isset($row['consumption']) ? $row['consumption'] : '',
                'food_menu_id'=>$food_menu_id,
                'create_by_id'=>Sentinel::getUser()->id,
                'ingredient_code'=>isset($row['item_code']) ? $row['item_code'] : '',
            ]);
          endif;
            
            

        }

    }
}
