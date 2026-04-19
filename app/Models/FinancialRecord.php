<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialRecord extends Model
{
    protected $fillable = [
        'operation_id',
        'dollar_amount',
        'transaction_date',
        'exchange_rate',
        'rmb_amount',
        'shop_payment',
        'shop_details',
        'purchase_amount',
        'status',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'dollar_amount' => 'decimal:2',
        'exchange_rate' => 'decimal:4',
        'rmb_amount' => 'decimal:2',
        'shop_payment' => 'decimal:2',
        'purchase_amount' => 'decimal:2',
    ];

    public function operation()
    {
        return $this->belongsTo(Operation::class);
    }
}
