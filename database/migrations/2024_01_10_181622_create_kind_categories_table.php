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
        Schema::create('kind_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('key')->unique();
            $table->string('label_key')->default('کد یکتا');
            $table->string('label_value_1')->nullable();
            $table->string('label_value_2')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('kind_categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kind_categories');
    }
};
