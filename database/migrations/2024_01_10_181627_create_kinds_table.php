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
        Schema::create('kinds', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value_1');
            $table->string('value_2')->nullable();
            $table->unsignedBigInteger('kind_category_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            $table->foreign('kind_category_id')->references('id')->on('kind_categories')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('kinds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kinds');
    }
};
