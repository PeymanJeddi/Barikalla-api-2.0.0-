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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->boolean('is_admin')->default(0);
            $table->string('username')->nullable()->unique();
            $table->string('nickname')->nullable();
            $table->string('referral_username')->nullable();
            $table->timestamp('birthday')->nullable();
            $table->string('gender')->comment('male|female|other')->nullable();
            $table->string('national_id')->nullable();
            $table->string('address')->nullable();
            $table->string('postalcode')->nullable();
            $table->string('mobile', 11)->unique();
            $table->string('fix_phone_number')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('is_active')->default(0);
            $table->string('uuid')->nullable()->unique();
            $table->string('status')->comment('incomplete|pending|rejected|verified')->default('incomplete');
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
