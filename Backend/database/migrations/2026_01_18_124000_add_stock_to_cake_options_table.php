<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cake_options', function (Blueprint $table) {
            $table->integer('stock')->unsigned()->nullable()->default(100)->after('price');
        });
    }

    public function down()
    {
        Schema::table('cake_options', function (Blueprint $table) {
            $table->dropColumn('stock');
        });
    }
};
