<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchiseNotification extends Model
{
    use HasFactory;
    protected $fillable = ['notification','sale_id','waiter_id','push_status','outlet_id'];
}
