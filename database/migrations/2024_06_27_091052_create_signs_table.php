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
        Schema::create('signs', function (Blueprint $table) {
            $table->id();
            $table->biginteger('users_id')->unsigned();
            $table->string('s_seat');
            $table->string('s_clink')->nullable();
            $table->string('s_img')->nullable();
            $table->text('s_description');
            $table->string('resolved_by')->nullable();
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('s_seat')->references('seat_num')->on('seats')
            ->onDelete('cascade')->onUpdate('cascade');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signoffs');
    }
};
