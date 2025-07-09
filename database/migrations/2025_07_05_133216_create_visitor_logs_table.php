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
            $table->string('uuid', '36')->unique();
            $table->string('ip_address');
            $table->dateTime('visit_date'); // full timestamp
            $table->date('visit_day');      // for uniqueness
            $table->string('visit_from')->nullable();     // facebook, youtube, linkedin je jayga theke link e dhukche
            $table->string('country')->nullable();      // geo
            $table->string('browser')->nullable();      // user agent
            $table->string('device')->nullable();       // optional

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();

            $table->unique(['ip_address', 'visit_day', 'browser'], 'visitor_unique_combination');
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
