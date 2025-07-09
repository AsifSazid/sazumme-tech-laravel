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
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->date('visit_date');
            $table->string('visit_from')->nullable();     // facebook, youtube, linkedin je jayga theke link e dhukche
            $table->string('country')->nullable();      // geo
            $table->string('browser')->nullable();      // user agent
            $table->string('device')->nullable();       // optional
            $table->timestamps();
    
            $table->unique(['ip_address', 'visit_date']); // prevent duplicate
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
