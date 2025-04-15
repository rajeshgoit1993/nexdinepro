<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchiseHoldTable extends Model
{
    use HasFactory;

    protected $fillable = ['persons','booking_time','hold_id','hold_no','outlet_id','table_id','del_status'];
}
