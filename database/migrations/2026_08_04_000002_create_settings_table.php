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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('qris_image')->nullable();
            $table->unsignedBigInteger('nisab_gold_price')->default(1400000); // Rp 1.400.000 / gram
            $table->unsignedBigInteger('zakat_fitrah_nominal')->default(45000); // Rp 45.000 / jiwa
            $table->text('announcement_banner')->nullable();
            $table->json('bank_accounts')->nullable();
            $table->string('org_name')->default('Baitul Maal Amil Zakat');
            $table->text('org_description')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('contact_address')->nullable();
            $table->text('footer_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
