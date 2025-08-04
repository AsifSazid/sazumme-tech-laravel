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
        Schema::create('category_ebook', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('ebook_id')->constrained()->onDelete('cascade');
            $table->string('ebook_title')->nullable();
            $table->string('ebook_uuid')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('category_title')->nullable();
            $table->string('category_uuid')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_ebook');
    }
};
