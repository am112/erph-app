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
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rph_id')->constrained('rphs')->cascadeOnDelete();
            $table->date('date_at');
            $table->string('start_time');
            $table->string('end_time');
            $table->double('total_time')->nullable();
            $table->unsignedBigInteger('strategy_id')->nullable();
            $table->unsignedBigInteger('field_id')->nullable();
            $table->unsignedBigInteger('language_id')->nullable();
            $table->unsignedBigInteger('discipline_id')->nullable();
            $table->unsignedBigInteger('standard_id')->nullable();
            $table->string('objective')->nullable();
            $table->string('activity')->nullable();
            $table->string('remark')->nullable();
            $table->string('holiday')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
};
