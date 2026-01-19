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
        Schema::create('help_contents', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('faq'); // faq, help_card
            $table->string('title');
            $table->text('content');
            $table->string('icon')->nullable(); // For help cards
            $table->string('category')->nullable(); // ordering, delivery, payments, etc.
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('help_contents');
    }
};
