<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchiseSaleDetailsModifier extends Model
{
    use HasFactory;
    protected $fillable = ['modifier_id','modifier_price','food_menu_id','sales_id','order_status','sales_details_id','menu_vat_percentage','menu_taxes','user_id','outlet_id','customer_id'];
}
