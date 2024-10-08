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
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('telegram_id')->nullable();
            $table->string('telegram_username')->nullable();
            $table->foreignUuid('user_type_id')->constrained();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('telegram')->unique()->nullable();
            $table->string('middle_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('sms_code')->nullable();
            $table->text('sms_params_json')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->string('photo')->nullable();
            $table->string('birth_date')->nullable();
            $table->boolean('gender')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
