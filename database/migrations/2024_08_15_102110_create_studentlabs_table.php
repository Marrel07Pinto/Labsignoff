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
        Schema::create('studentlabs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('users_id')->unsigned();
            $table->bigInteger('labs_id')->unsigned();
            $table->string('s_seat')->nullable();
            $table->bigInteger('queries_id')->unsigned()->nullable();
            $table->bigInteger('signs_id')->unsigned()->nullable();
            
            
            $table->foreign('users_id')->references('id')->on('users')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('labs_id')->references('id')->on('labs')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('queries_id')->references('id')->on('queries')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('signs_id')->references('id')->on('signs')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('s_seat')->references('seat_num')->on('seats')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studentlabs');
    }
};
