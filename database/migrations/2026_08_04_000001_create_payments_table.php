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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('sender_name');
            $table->string('title'); // e.g. Zakat Maal, Zakat Fitrah, Zakat Penghasilan, Donasi / Infaq
            $table->unsignedBigInteger('amount');
            $table->string('proof_image');
            $table->enum('status', ['Menunggu Verifikasi', 'Diverifikasi', 'Sudah Disalurkan', 'Ditolak'])->default('Menunggu Verifikasi');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('distributed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Performance Indexes
            $table->index(['user_id', 'status']);
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
