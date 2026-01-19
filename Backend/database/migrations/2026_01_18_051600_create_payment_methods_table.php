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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "eSewa", "Khalti", "Cash on Delivery"
            $table->string('code')->unique(); // e.g., "esewa", "khalti", "cod"
            $table->string('display_name'); // e.g., "eSewa Payment"
            $table->text('description')->nullable();
            $table->string('logo_url')->nullable(); // Payment provider logo
            $table->string('qr_code_path')->nullable(); // QR code image path
            $table->string('account_number')->nullable(); // Account/Phone number
            $table->string('account_name')->nullable(); // Account holder name
            $table->text('instructions')->nullable(); // Payment instructions
            $table->boolean('is_active')->default(true);
            $table->boolean('requires_verification')->default(false); // Manual verification needed
            $table->integer('sort_order')->default(0); // Display order
            $table->decimal('extra_charge', 10, 2)->default(0); // Additional charge (e.g., COD fee)
            $table->string('extra_charge_type')->default('fixed'); // 'fixed' or 'percentage'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
