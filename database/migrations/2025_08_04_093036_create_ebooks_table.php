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
        Schema::create('ebooks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('author')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('page_count')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by'); // Better to use user ID (foreign key)
            $table->string('created_by_uuid')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebooks');
    }
};
