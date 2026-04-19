<?php

namespace Database\Seeders;

use App\Models\FinancialRecord;
use App\Models\Operation;
use Illuminate\Database\Seeder;

class FinancialRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $op1 = Operation::create([
            'name' => 'توريد أقمشة - أكتوبر',
            'status' => 'pending',
            'operation_date' => '2023-10-12',
            'record_count' => 14,
            'total_dollar' => 45200.00,
            'total_rmb' => 329800.00,
        ]);

        $op2 = Operation::create([
            'name' => 'شحنة معدات صناعية',
            'status' => 'completed',
            'operation_date' => '2023-10-08',
            'record_count' => 3,
            'total_dollar' => 128500.00,
            'total_rmb' => 937200.00,
        ]);

        $op3 = Operation::create([
            'name' => 'رسوم استشارات دولية',
            'status' => 'delayed',
            'operation_date' => '2023-10-01',
            'record_count' => 1,
            'total_dollar' => 15000.00,
            'total_rmb' => 0.00,
        ]);

        // Seed some records for Operation 1
        FinancialRecord::create([
            'operation_id' => $op1->id,
            'dollar_amount' => 5000.00,
            'transaction_date' => '2023-10-24',
            'exchange_rate' => 7.15,
            'rmb_amount' => 35750.00,
            'shop_payment' => 12000.00,
            'shop_details' => 'مورد أقمشة - غوانزو',
            'purchase_amount' => 23000.00,
            'status' => 'completed',
        ]);

        FinancialRecord::create([
            'operation_id' => $op1->id,
            'dollar_amount' => 2500.00,
            'transaction_date' => '2023-10-22',
            'exchange_rate' => 7.12,
            'rmb_amount' => 17800.00,
            'shop_payment' => 5500.00,
            'shop_details' => 'مصنع إلكترونيات - شنجن',
            'purchase_amount' => 10000.00,
            'status' => 'completed',
        ]);
    }
}
