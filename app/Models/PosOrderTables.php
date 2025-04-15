<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosOrderTables extends Model
{
    use HasFactory;
    protected $fillable = ['persons','booking_time','sale_id','sale_no','outlet_id','table_id','del_status'];
}
