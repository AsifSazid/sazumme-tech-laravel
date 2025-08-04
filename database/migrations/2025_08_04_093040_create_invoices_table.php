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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('purchase_id')->constrained()->onDelete('cascade');
            $table->string('purchase_title')->nullable();
            $table->string('purchase_uuid')->nullable();
            $table->string('invoice_number')->unique();
            $table->decimal('amount', 10, 2);
            $table->date('invoice_date');
            $table->text('billing_address')->nullable();
            $table->enum('status', ['pending', 'unpaid', 'paid', 'refunded'])->default('initiated');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
