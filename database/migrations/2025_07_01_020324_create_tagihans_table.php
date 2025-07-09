<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->decimal('nominal', 15, 2);
            $table->foreignId('account_id')->nullable()->constrained()->nullOnDelete();
            $table->date('tanggal_transfer');
            $table->string('status')->default('belum dibayar');
            $table->string('metode')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('no_tujuan')->nullable();
            $table->boolean('sudah_dikirim')->default(false); // boleh tetap disimpan untuk legacy
            $table->string('pengingat_terakhir')->nullable(); // 'H-1' atau 'H'
            $table->timestamp('tanggal_dikirim')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
