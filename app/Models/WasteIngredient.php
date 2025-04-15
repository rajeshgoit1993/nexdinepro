<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteIngredient extends Model
{
    use HasFactory;
    
    protected $fillable = ['outlet_id','ingredient_id','waste_id','waste_amount','last_purchase_price','last_purchase_price_avg','loss_amount','food_menu_id','food_menu_qty','sync_status'];
}
