<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Add 'dine-in' to delivery_type enum
        DB::statement("SET SQL_MODE=''");
        DB::statement("ALTER TABLE orders MODIFY COLUMN delivery_type ENUM('pickup', 'delivery', 'dine-in') DEFAULT 'delivery'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN delivery_type ENUM('pickup', 'delivery') DEFAULT 'delivery'");
    }
};
