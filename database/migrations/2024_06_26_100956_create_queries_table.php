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
            $table->string('q_seat')->nullable();
            $table->string('q_img')->nullable();
            $table->text('q_query');
            $table->text('q_state')->nullable();
            $table->string('resolved_by')->nullable();
            $table->string('solution')->nullable();
            $table->string('lab');
            
            $table->foreign('users_id')->references('id')->on('users')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
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
