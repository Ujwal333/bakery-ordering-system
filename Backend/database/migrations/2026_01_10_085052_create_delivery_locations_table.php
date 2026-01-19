<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('delivery_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_id')->constrained()->onDelete('cascade');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->integer('speed')->nullable(); // Optional: capture speed in km/h
            $table->integer('heading')->nullable(); // Optional: capture direction (0-360)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('delivery_locations');
    }
};
