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
        Schema::create('link_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('link_id');
            $table->string('value');

            $table->primary(['center_id', 'link_id']);
            $table->foreign('center_id')->references('id')->on('centers')->cascadeOnDelete();
            $table->foreign('link_id')->references('id')->on('kinds')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link_user');
    }
};
