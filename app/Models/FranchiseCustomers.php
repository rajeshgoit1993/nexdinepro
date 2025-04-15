<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchiseCustomers extends Model
{
    use HasFactory;
    protected $fillable = ['name','phone','email','address','password','gst_number','pre_or_post_payment','area_id','user_id','outlet_id','del_status','date_of_birth','date_of_anniversary'];
}
