<?php

namespace App\Http\Controllers;

use App\Models\FinancialRecord;
use App\Models\Operation;
use Illuminate\Http\Request;

class FinancialRecordController extends Controller
{
    public function store(Request $request, Operation $operation)
    {
        $record = $operation->records()->create([
            'transaction_date' => now()->toDateString(),
            'status' => 'pending',
        ]);

        return response()->json($record);
    }

    public function update(Request $request, FinancialRecord $record)
    {
        $validated = $request->validate([
            'dollar_amount' => 'nullable|numeric',
            'transaction_date' => 'nullable|date',
            'exchange_rate' => 'nullable|numeric',
            'rmb_amount' => 'nullable|numeric',
            'shop_payment' => 'nullable|numeric',
            'shop_details' => 'nullable|string',
            'purchase_amount' => 'nullable|numeric',
            'status' => 'nullable|string',
        ]);

        $record->update($validated);

        return response()->json($record);
    }
}
