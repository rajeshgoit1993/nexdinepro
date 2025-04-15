<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchiseSale extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id','sale_no','total_items','sub_total','paid_amount','due_amount','disc','disc_actual','gst','total_payable','payment_method_id','close_time','table_id','total_item_discount_amount','sub_total_with_discount','sub_total_discount_amount','total_discount_amount','charge_type','delivery_charge','delivery_charge_actual_charge','sub_total_discount_value','sub_total_discount_type','sale_date','date_time','order_time','cooking_start_time','cooking_done_time','modified','user_id','waiter_id','outlet_id','company_id','order_status','order_type','del_status','given_amount','change_amount','sale_vat_objects','future_sale_status','is_kitchen_bell','invoice_number','token_number','cancel_remarks','discount_remarks'];
}
