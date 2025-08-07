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
        Schema::create('ebook_tag', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('ebook_id')->constrained()->onDelete('cascade');
            $table->string('ebook_title')->nullable();
            $table->string('ebook_uuid')->nullable();
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->string('tag_title')->nullable();
            $table->string('tag_uuid')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebook_tag');
    }
};
