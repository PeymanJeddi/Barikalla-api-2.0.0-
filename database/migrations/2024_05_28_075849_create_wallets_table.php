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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->integer('credit')->default(0);
            $table->string('shaba')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_card_number')->nullable();
            $table->boolean('is_automatic_checkout')->default(0);
            $table->string('automatic_checkout_cycle')->nullable()->comment('daily|weekly|monthly');
            $table->string('automatic_checkout_min_amount')->nullable();
            $table->string('automatic_checkout_max_amount')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
