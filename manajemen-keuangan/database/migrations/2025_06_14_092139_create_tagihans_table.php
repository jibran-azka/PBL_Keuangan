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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('account_id');
            $table->string('nama');
            $table->string('no_tujuan'); // baru
            $table->decimal('nominal', 15, 2);
            $table->date('tanggal_transfer'); // ganti dari tanggal_jatuh_tempo
            $table->string('metode'); // baru
            $table->string('tujuan'); // baru
            $table->enum('status', ['terjadwal', 'menunggu bayar', 'sudah dipotong', 'gagal - saldo tidak cukup'])->default('terjadwal');
            $table->timestamps();

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
