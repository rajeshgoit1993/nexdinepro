<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchiseTempKot extends Model
{
    use HasFactory;
    protected $fillable = ['temp_kot_info','outlet_id'];
}
