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
        Schema::create('pollopts', function (Blueprint $table) {
            $table->integer('id')->unique(); 
            $table->integer('by')->unsigned();
            $table->foreign('by')->references('id')->on('authors')->onDelete('cascade');
            $table->integer('poll_id');
            $table->integer('score');
            $table->text('text');
            $table->integer('time');
            $table->timestamps();

            $table->foreign('poll_id')->references('id')->on('polls');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pollopts');
    }
};
