<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchiseTableHold extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id','hold_no','total_items','sub_total','paid_amount','due_amount','due_payment_date','disc','disc_actual','gst','total_payable','payment_method_id','table_id','total_item_discount_amount','sub_total_with_discount','sub_total_discount_amount','total_discount_amount','charge_type','delivery_charge','delivery_charge_actual_charge','sub_total_discount_value','sub_total_discount_type','token_no','sale_date','date_time','sale_time','user_id','waiter_id','outlet_id','company_id','order_status','sale_vat_objects','order_type','del_status'];

}
