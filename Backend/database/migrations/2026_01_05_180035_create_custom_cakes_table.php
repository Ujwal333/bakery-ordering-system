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
        Schema::create('custom_cakes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('size');
            $table->decimal('size_price', 10, 2);
            $table->string('flavor');
            $table->decimal('flavor_price', 10, 2);
            $table->string('frosting');
            $table->decimal('frosting_price', 10, 2);
            $table->json('decorations');
            $table->decimal('decorations_price', 10, 2);
            $table->text('custom_message')->nullable();
            $table->json('design_details')->nullable();
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('draft');
            $table->date('delivery_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_cakes');
    }
};
