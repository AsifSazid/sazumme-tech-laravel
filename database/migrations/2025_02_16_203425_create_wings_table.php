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
        Schema::create('wings', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', '36')->unique();
            $table->string('title');
            $table->string('icon_code');
            $table->text('short_description');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by'); // Better to use user ID (foreign key)
            $table->boolean('is_active')->default(true); // Quick toggle for visibility
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wings');
    }
};
