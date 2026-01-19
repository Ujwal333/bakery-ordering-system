<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add table number for dine-in orders
            if (!Schema::hasColumn('orders', 'table_number')) {
                $table->integer('table_number')->nullable()->after('delivery_type');
            }
            
            // Add order source to distinguish web vs walk-in
            if (!Schema::hasColumn('orders', 'order_source')) {
                $table->enum('order_source', ['web', 'walk-in', 'phone'])->default('web')->after('table_number');
            }
        });

        // Create table_reservations table for tracking table status
        if (!Schema::hasTable('table_reservations')) {
            Schema::create('table_reservations', function (Blueprint $table) {
                $table->id();
                $table->integer('table_number');
                $table->enum('status', ['available', 'occupied', 'reserved'])->default('available');
                $table->foreignId('current_order_id')->nullable()->constrained('orders')->onDelete('set null');
                $table->timestamp('occupied_at')->nullable();
                $table->timestamp('available_at')->nullable();
                $table->timestamps();
                
                $table->index('table_number');
                $table->index('status');
            });
        }
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['table_number', 'order_source']);
        });
        
        Schema::dropIfExists('table_reservations');
    }
};
