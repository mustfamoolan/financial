<?php

namespace App\Http\Controllers;

use App\Models\FinancialRecord;
use App\Models\Operation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the list of all operations (Bento Cards) with REAL AGGREGATES.
     */
    public function index()
    {
        $operations = Operation::withCount('records')
            ->withSum('records as total_dollar', 'dollar_amount')
            ->withSum('records as total_rmb', 'rmb_amount')
            ->orderBy('id', 'desc')
            ->get();

        return view('operations', compact('operations'));
    }

    /**
     * Store a new operation with custom Name and Date.
     */
    public function storeOperation(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'operation_date' => 'required|date',
        ]);

        $operation = Operation::create([
            'name' => $validated['name'],
            'status' => 'pending',
            'operation_date' => $validated['operation_date'],
        ]);

        // Add virtual fields for the UI to handle immediately
        $operation->records_count = 0;
        $operation->total_dollar = 0;
        $operation->total_rmb = 0;

        return response()->json($operation);
    }

    /**
     * Display the detailed ledger for a specific operation.
     */
    public function show(Operation $operation)
    {
        $records = $operation->records()->orderBy('id', 'desc')->get();
        
        $stats = [
            'total_dollar' => $records->sum('dollar_amount'),
            'total_rmb' => $records->sum('rmb_amount'),
            'total_payments' => $records->sum('shop_payment'),
            'remaining' => $records->sum('rmb_amount') - $records->sum('shop_payment'),
        ];

        return view('dashboard', compact('operation', 'records', 'stats'));
    }
}
