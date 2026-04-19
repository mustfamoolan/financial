<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('financial_records', function (Blueprint $col) {
            $col->id();
            $col->foreignId('operation_id')->constrained()->onDelete('cascade');
            $col->decimal('dollar_amount', 15, 2)->default(0);
            $col->date('transaction_date')->nullable();
            $col->decimal('exchange_rate', 15, 4)->default(0);
            $col->decimal('rmb_amount', 15, 2)->default(0);
            $col->decimal('shop_payment', 15, 2)->default(0);
            $col->string('shop_details')->nullable();
            $col->decimal('purchase_amount', 15, 2)->default(0);
            $col->string('status')->default('pending');
            $col->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_records');
    }
};
