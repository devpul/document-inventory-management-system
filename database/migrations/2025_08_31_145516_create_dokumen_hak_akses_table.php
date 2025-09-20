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
        Schema::create('dokumen_hak_akses', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('dokumen_id');
            $table->foreign('dokumen_id')->references('id')->on('dokumen')->onDelete('cascade');
            
            $table->unsignedBigInteger('hak_akses_id');
            $table->foreign('hak_akses_id')->references('id')->on('hak_akses')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_hak_akses');
    }
};
