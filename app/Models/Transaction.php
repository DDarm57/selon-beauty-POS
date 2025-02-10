<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_code',
        'user_id',
        'customer_name',
        'total_qty',
        'total_price',
        'total_price_after_discount',
        'pay',
        'change',
        'payments',
        'transaction_type',
    ];
}
