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
             $table->longText('abstract')
                ->after('judul');

            $table->string('status')
                ->default('Berlaku')
                ->after('abstract');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produkhukum', function (Blueprint $table) {
            //
        });
    }
};
