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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('lab');
            $table->integer('f_understanding');
            $table->string('f_confusing');
            $table->text('f_interesting');
            $table->text('f_engaging');
            $table->string('f_important');
            $table->integer('f_overall');
            $table->integer('f_difficulty');
            


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
