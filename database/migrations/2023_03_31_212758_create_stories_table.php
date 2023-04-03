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
        Schema::create('stories', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('title')->nullable();
            $table->text('url')->nullable();
            $table->text('text')->nullable();
            $table->integer('score')->default(0);
            $table->string('by')->unsigned();
            $table->enum('category', ['top', 'new', 'show', 'ask', 'best']);
            $table->foreign('by')->references('id')->on('authors')->onDelete('cascade');
            $table->integer('time')->default(0);
            $table->integer('descendants')->nullable();
            $table->boolean('deleted')->default(false);
            $table->boolean('dead')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
