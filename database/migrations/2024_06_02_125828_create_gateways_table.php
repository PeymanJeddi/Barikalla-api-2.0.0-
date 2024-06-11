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
        Schema::create('gateways', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('biography')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_payment_active')->default(0);
            $table->unsignedBigInteger('job_id')->nullable();
            $table->integer('min_donate')->default(5000);
            $table->integer('max_donate')->default(100000000);
            $table->boolean('is_donator_pay_wage')->nullable();
            $table->boolean('is_donator_pay_tax')->nullable();
            $table->enum('wage_type', ['default', 'none', 'custom'])->default('default');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('job_id')->references('id')->on('kinds')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('streamer_details');
    }
};
