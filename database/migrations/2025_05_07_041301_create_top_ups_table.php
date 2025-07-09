<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopUpsTable extends Migration
{
    public function up()
    {
        Schema::create('top_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');
            $table->integer('amount');
            $table->string('transaction_id')->nullable(); // dari Midtrans
            $table->string('status')->default('pending'); // pending, success, failed
            $table->timestamps();
        });
    }



    public function down()
    {
        Schema::dropIfExists('top_ups');
    }
}
