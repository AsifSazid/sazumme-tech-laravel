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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('purchase_id')->constrained()->onDelete('cascade');
            $table->string('purchase_title')->nullable();
            $table->string('purchase_uuid')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('payment_gateway')->nullable(); // bKash, SSL, Stripe, etc.
            $table->string('transaction_id')->nullable();
            $table->enum('status', ['initiated', 'completed', 'failed'])->default('initiated');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
