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
        Schema::table('produkhukum', function (Blueprint $table) {
            $table->string('nama_instansi')
                ->nullable()
                ->after('category_id');
        });
    }

    public function down(): void
    {
        Schema::table('produkhukum', function (Blueprint $table) {
            $table->dropColumn('nama_instansi');
        });
    }
};
