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
        Schema::create('operations', function (Blueprint $col) {
            $col->id();
            $col->string('name');
            $col->string('status')->default('pending'); // pending, completed, delayed
            $col->date('operation_date')->nullable();
            $col->integer('record_count')->default(0); // number of sub-transactions
            $col->decimal('total_dollar', 15, 2)->default(0);
            $col->decimal('total_rmb', 15, 2)->default(0);
            $col->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operations');
    }
};
