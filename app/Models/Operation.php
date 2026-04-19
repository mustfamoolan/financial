<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $fillable = [
        'name',
        'status',
        'operation_date',
        'record_count',
        'total_dollar',
        'total_rmb',
    ];

    protected $casts = [
        'operation_date' => 'date',
    ];

    public function records()
    {
        return $this->hasMany(FinancialRecord::class);
    }
}
