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
        Schema::create('student_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained('semesters')->cascadeOnDelete();
            $table->unsignedBigInteger('month_id');
            $table->integer('male_four')->nullable();
            $table->integer('female_four')->nullable();
            $table->integer('male_five')->nullable();
            $table->integer('female_five')->nullable();
            $table->integer('male_six')->nullable();
            $table->integer('female_six')->nullable();

            $table->integer('melayu')->nullable();
            $table->integer('cina')->nullable();
            $table->integer('india')->nullable();
            $table->integer('others')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_statistics');
    }
};
