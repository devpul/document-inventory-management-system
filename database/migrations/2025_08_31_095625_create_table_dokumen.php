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
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->unsignedBigInteger('kategori_id');
            $table->foreign('kategori_id')->references('id')->on('kategori_dokumen')->onDelete('cascade');

            $table->string('nomor_dokumen')->nullable();

            $table->string('nama_dokumen');

            $table->string('keyword');

            $table->text('deskripsi')->nullable();

            $table->date('tanggal_terbit');

            $table->enum('status', ['dibagikan', 'draf'])->default('draf');

            $table->string('file_attachment');

            // $table->timestamps();

            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
