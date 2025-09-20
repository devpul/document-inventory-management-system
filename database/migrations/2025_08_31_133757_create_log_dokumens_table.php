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
        Schema::create('log_dokumen', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('dokumen_id');
            $table->foreign('dokumen_id')->references('id')->on('dokumen')->onDelete('cascade');
            
            $table->timestamp('tanggal_dibagikan')->nullable();
            $table->timestamp('tanggal_dibuat')->nullable();
            $table->timestamp('tanggal_diubah')->nullable();
            $table->softDeletes('tanggal_dihapus')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_dokumen');
    }
};
