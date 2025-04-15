<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchiseSaleConsuptions extends Model
{
    use HasFactory;

    protected $fillable = ['sale_id','order_status','user_id','outlet_id','del_status'];
}
