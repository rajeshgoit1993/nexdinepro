<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysicalEntry extends Model
{
    use HasFactory;
    protected $fillable = ['date','outlet_id','ingredient_id','auto_data','physical_data','sync_status','entry_type'];
}
