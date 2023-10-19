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
        Schema::create('kokurikulums', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_subitem')->default(false);
            $table->integer('position')->default(0);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('kokurikulum_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kokurikulum_id')->constrained('kokurikulums')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained('semesters')->cascadeOnDelete();            
            $table->date('plan_started_at')->nullable();
            $table->date('plan_ended_at')->nullable();
            $table->date('accomplished_at')->nullable();
            $table->integer('week')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kokurikulum_user');
        Schema::dropIfExists('kokurikulums');
    }
};
