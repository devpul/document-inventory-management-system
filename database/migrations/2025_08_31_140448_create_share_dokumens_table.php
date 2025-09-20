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
        Schema::create('share_dokumen', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('dokumen_id');
            $table->foreign('dokumen_id')->references('id')->on('dokumen')->onDelete('cascade');

            $table->unsignedBigInteger('dibagikan_oleh_id');
            $table->foreign('dibagikan_oleh_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('email_tujuan');

            $table->string('link_token')->unique()->nullable();

            $table->string('expired_at')->nullable();

            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('share_dokumen');
    }
};
