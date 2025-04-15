<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignFoodMenuIngredient extends Model
{
    use HasFactory;
    protected $fillable = ['ingredient_id','consumption','food_menu_id','create_by_id','ingredient_code'];
}
