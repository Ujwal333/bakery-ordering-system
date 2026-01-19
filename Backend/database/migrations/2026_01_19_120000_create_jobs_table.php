<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type'); // Vacancy, Internship
            $table->string('department')->nullable();
            $table->string('location')->default('Kathmandu, Nepal');
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->decimal('salary_range', 10, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('deadline')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('resume_path')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('pending'); // pending, reviewed, shortlisted, rejected
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_applications');
        Schema::dropIfExists('jobs');
    }
};
