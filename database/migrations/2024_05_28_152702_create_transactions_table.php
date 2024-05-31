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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('streamer_id')->nullable();
            $table->integer('amount')->nullable();
            $table->string('fullname')->nullable();
            $table->bigInteger('order_id')->unique()->nullable();
            $table->string('mobile', 11);
            $table->text('description')->nullable();
            $table->boolean('is_paid')->default(0);
            $table->string('type')->comment('donate|charge|subscription');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
