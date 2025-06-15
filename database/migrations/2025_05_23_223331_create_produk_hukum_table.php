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
        Schema::create('ProdukHukum', function (Blueprint $table) {
            $table->id();
            $table->string('no_peraturan'); // e.g. PERBUP NOMOR 1 TAHUN 2025
            $table->string('judul'); // e.g. Pengalokasian Bagian ...
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_penetapan'); // e.g. 2025-01-10
            $table->date('tanggal_diundangkan'); // e.g. 2025-01-13
            $table->string('no_lembaran_daerah'); // e.g. TAHUN 2025 NOMOR 1
            $table->string('file_produk_hukum'); // e.g. 16491642833PERBUP_NOMOR_1_-_2025.pdf
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ProdukHukum');
    }
};
