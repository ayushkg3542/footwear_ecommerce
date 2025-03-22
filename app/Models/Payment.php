<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'razorpay_payment_id', 'order_id', 'amount', 'currency', 'status', 'product_details'
    ];

    protected $casts = [
        'product_details' => 'array',
    ];
}
