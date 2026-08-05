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
        Schema::create('mustahik_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('applicant_name');
            $table->string('nik', 16);
            $table->string('phone');
            $table->text('address');
            $table->string('asnaf_category');
            $table->string('program_type');
            $table->decimal('amount_requested', 15, 2);
            $table->text('reason');
            $table->string('sktm_proof_image')->nullable();
            $table->string('status')->default('Menunggu Verifikasi');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mustahik_applications');
    }
};
