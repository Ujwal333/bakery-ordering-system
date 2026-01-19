<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','confirmed','preparing','ready','with_logistic','out_for_delivery','delivered','cancelled') DEFAULT 'pending'");
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_status ENUM('pending','paid','completed','failed','refunded') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert to original (approximate)
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','confirmed','preparing','out_for_delivery','delivered','cancelled') DEFAULT 'pending'");
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_status ENUM('pending','completed','failed','refunded') DEFAULT 'pending'");
    }
};
