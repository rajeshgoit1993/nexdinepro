<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchiseSalesDetails extends Model
{
    use HasFactory;
    protected $fillable = ['food_menu_id','menu_name','qty','tmp_qty','menu_price_without_discount','menu_price_with_discount','menu_unit_price','menu_vat_percentage','menu_taxes','menu_discount_value','discount_type','menu_note','discount_amount','item_type','cooking_status','cooking_start_time','cooking_done_time','previous_id','sales_id','order_status','user_id','outlet_id','del_status'];
}
