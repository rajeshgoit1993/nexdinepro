<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchiseTableHoldDetailsModifiers extends Model
{
    use HasFactory;
     protected $fillable = ['modifier_id','modifier_price','food_menu_id','holds_id','holds_details_id','menu_vat_percentage','menu_taxes','user_id','outlet_id','customer_id'];
}
