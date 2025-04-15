<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchiseSaleConsuptionsOfMenu extends Model
{
    use HasFactory;

    protected $fillable = ['ingredient_id','consumption','sale_consumption_id','sales_id','order_status','food_menu_id','user_id','outlet_id','del_status','sync_status'];
}
