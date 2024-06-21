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
        Schema::create('queries', function (Blueprint $table) {
            $table->id();
            $table->biginteger('users_id')->unsigned();
            $table->string('q_seat');
            $table->string('q_clink');
            $table->string('q_img');
            $table->string('q_description');
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('q_seat')->references('seat_num')->on('seats')
            ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queries');
    }
};
