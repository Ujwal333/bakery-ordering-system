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
            $table->string('reference_number')->unique();
            $table->string('cake_name')->nullable();
            $table->string('size');
            $table->decimal('size_price', 10, 2);
            $table->string('flavor');
            $table->decimal('flavor_price', 10, 2);
            $table->string('frosting');
            $table->decimal('frosting_price', 10, 2);
            $table->json('decorations')->nullable();
            $table->decimal('decorations_price', 10, 2)->default(0);
            $table->text('custom_message')->nullable();
            $table->string('image_path')->nullable();
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->date('delivery_date');
            $table->time('delivery_time')->nullable();
            $table->softDeletes();
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
