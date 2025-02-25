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
            $table->string('s_seat')->nullable();
            $table->string('s_clink')->nullable();
            $table->string('s_img')->nullable();
            $table->text('s_description');
            $table->text('s_state')->nullable();
            $table->string('s_resolved_by')->nullable();
            $table->string('s_result')->nullable();
            $table->text('s_reason')->nullable();
            $table->string('marks')->nullable();
            $table->string('lab');
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users')
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
