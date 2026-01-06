<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->string('size')->nullable(); // 6-inch, 8-inch, etc.
            $table->string('flavor')->nullable();
            $table->integer('serves')->nullable();
            $table->text('ingredients')->nullable();
            $table->text('allergens')->nullable();
            $table->string('image_url');
            $table->integer('rating')->default(5);
            $table->integer('stock')->default(100);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_special')->default(false);
            $table->boolean('is_available')->default(true);
            $table->json('customization_options')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
