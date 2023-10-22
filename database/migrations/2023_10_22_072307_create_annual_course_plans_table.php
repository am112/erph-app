<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('annual_course_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained('semesters')->cascadeOnDelete();
            $table->unsignedBigInteger('month_id')->nullable();
            $table->unsignedBigInteger('pillar_id')->nullable();
            $table->text('description')->nullable();            
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('annual_course', function(Blueprint $table){
            $table->foreignId('annual_id')->constrained('annual_course_plans')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->string('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annual_course');
        Schema::dropIfExists('annual_course_plans');
    }
};
