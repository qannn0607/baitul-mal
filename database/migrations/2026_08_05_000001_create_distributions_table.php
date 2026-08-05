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
        Schema::create('distributions', function (Blueprint $table) {
            $table->id();
            $table->string('program_name'); // Nama Program Penyaluran (cth: Sembako Dhuafa, Beasiswa Santri)
            $table->enum('asnaf', [
                'Fakir',
                'Miskin',
                'Amil',
                'Muallaf',
                'Riqab',
                'Gharim',
                'Fisabilillah',
                'Ibnu Sabil',
            ]);
            $table->string('recipient_name'); // Nama Penerima Manfaat / Mustahik / Lembaga
            $table->decimal('amount', 15, 2); // Nominal Dana Disalurkan
            $table->date('distribution_date'); // Tanggal Penyaluran
            $table->text('notes')->nullable(); // Catatan / Keterangan
            $table->foreignId('distributed_by')->nullable()->constrained('users')->nullOnDelete(); // Amil/Admin penginput
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributions');
    }
};
