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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', '36')->unique();
            $table->string('title');
            $table->text('body'); // Use 'text' instead of 'string' for longer announcements
            $table->text('content')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->boolean('is_active')->default(true); // Quick toggle for visibility
            $table->unsignedBigInteger('written_by'); // Better to use user ID (foreign key)
            $table->string('written_by_uuid')->nullable();
            $table->boolean('is_approved')->default(false); // Quick toggle for visibility
            $table->unsignedBigInteger('approved_at')->nullable(); // Better to use user ID (foreign key)
            $table->unsignedBigInteger('approved_by')->nullable(); // Better to use user ID (foreign key)
            $table->string('approved_by_uuid')->nullable();

            // Optional: Add foreign key constraint if using users table
            $table->foreign('written_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
