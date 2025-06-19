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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // <-- WAJIB
            $table->unsignedBigInteger('account_id'); // relasi ke akun
            $table->string('nama');
            $table->decimal('nominal', 15, 2);
            $table->date('tanggal_jatuh_tempo');
            $table->enum('status', ['aktif', 'sudah dipotong'])->default('aktif');
            $table->timestamps();

            // foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
