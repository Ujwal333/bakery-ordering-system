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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'delivery_province')) {
                $table->string('delivery_province')->nullable();
            }
            if (!Schema::hasColumn('orders', 'delivery_district')) {
                $table->string('delivery_district')->nullable();
            }
            if (!Schema::hasColumn('orders', 'delivery_area')) {
                $table->string('delivery_area')->nullable();
            }
            if (!Schema::hasColumn('orders', 'delivery_street')) {
                $table->string('delivery_street')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['delivery_province', 'delivery_district', 'delivery_area', 'delivery_street']);
        });
    }
};
