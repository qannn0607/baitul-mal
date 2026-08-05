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
        Schema::create('zakat_balances', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_collected', 15, 2)->default(0);
            $table->decimal('total_distributed', 15, 2)->default(0);
            $table->decimal('current_balance', 15, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('zakat_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->nullable()->constrained('payments')->nullOnDelete();
            $table->foreignId('distribution_id')->nullable()->constrained('distributions')->nullOnDelete();
            $table->enum('type', ['credit', 'debit']); // credit = uang masuk, debit = uang keluar
            $table->decimal('amount', 15, 2);
            $table->decimal('balance_after', 15, 2);
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zakat_ledgers');
        Schema::dropIfExists('zakat_balances');
    }
};
