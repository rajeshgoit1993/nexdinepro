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


class FranchiseAdminStockImport implements ToCollection, WithHeadingRow
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
     
    
       foreach($collection as $row){

          if(isset($row['date']) && isset($row['outlet_id']) && isset($row['item_code']) && CustomHelpers::get_master_table_data('master_products','item_code',$row['item_code'],'id')!='NA'):

            $date=$row['date'];
            $outlet_id=$row['outlet_id'];

            $product_id=CustomHelpers::get_master_table_data('master_products','item_code',$row['item_code'],'id');
            $previous_data=PhysicalEntry::where([['outlet_id',$outlet_id],['date',$date],['area_manager_approval',0]])->first();
             $id=$previous_data->id;
           
            $update_data['auto_data']=isset($row['auto_stock']) ? $row['physical_stock'] : '';
            $update_data['physical_data']=isset($row['physical_stock']) ? $row['physical_stock'] : '';
            $update_data['area_manager_approval']=1;

            PhysicalEntry::where('id',$id)->update($update_data);

          endif;
            
            

        }

    }
}

