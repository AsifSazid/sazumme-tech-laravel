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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', '36')->unique();
            $table->string('title');
            $table->string('announcement_for');
            $table->text('body'); // Use 'text' instead of 'string' for longer announcements
            $table->unsignedBigInteger('created_by'); // Better to use user ID (foreign key)
            $table->timestamp('starts_at')->nullable(); // When the announcement should start showing
            $table->timestamp('ends_at')->nullable();   // When to stop showing
            $table->boolean('is_active')->default(true); // Quick toggle for visibility
            $table->timestamps();
            $table->softDeletes();
        
            // Optional: Add foreign key constraint if using users table
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
