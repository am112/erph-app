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

        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('address')->nullable();
            $table->string('region')->nullable();
            $table->string('postcode')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('parliment_id')->nullable();
            $table->unsignedBigInteger('dun_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('established_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('users', function(Blueprint $table){
            $table->foreignId('school_id')->nullable()->after('password')->constrained('schools')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function(Blueprint $table){
            $table->dropForeign(['school_id']);
        });
        Schema::dropIfExists('schools');
    }
};
