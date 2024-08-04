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
        Schema::create('profits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->bigInteger('amount_user_paid');
            $table->bigInteger('amount_streamer_charged')->nullable();
            $table->bigInteger('amount_user_charged')->nullable();
            $table->bigInteger('tax');
            $table->bigInteger('profit');
            $table->timestamps();

            $table->foreign('payment_id')->references('id')->on('payments')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profits');
    }
};
