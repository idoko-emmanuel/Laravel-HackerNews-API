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
        Schema::create('hacker_jobs', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('by')->unsigned();
            $table->integer('score');
            $table->text('text');
            $table->integer('time');
            $table->string('title');
            $table->text('url')->nullable();
            $table->boolean('deleted')->default(false);
            $table->boolean('dead')->default(false);
            $table->timestamps();
            $table->foreign('by')->references('id')->on('authors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hacker_jobs');
    }
};
