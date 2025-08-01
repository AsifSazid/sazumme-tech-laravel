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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('uuid', '36')->unique();
            $table->string('email')->unique();
            $table->string('phone_no')->unique();
            $table->boolean('is_phone_verified')->default('0')->nullable();
            $table->boolean('default_password')->nullable();
            $table->boolean('has_default_password')->default('1')->nullable();
            $table->boolean('is_email_verified')->default('0')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
