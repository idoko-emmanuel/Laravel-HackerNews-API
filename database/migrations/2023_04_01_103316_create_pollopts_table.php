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
            $table->string('by')->unsigned();
            $table->foreign('by')->references('id')->on('authors')->onDelete('cascade');
            $table->integer('poll_id');
            $table->integer('score')->default(0);
            $table->text('text')->nullable();
            $table->integer('time')->default(0);
            $table->boolean('deleted')->default(false);
            $table->boolean('dead')->default(false);
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
