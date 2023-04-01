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
            $table->string('title');
            $table->text('url')->nullable();
            $table->text('text')->nullable();
            $table->integer('score')->default(0);
            $table->integer('by')->unsigned();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->enum('category', ['top', 'new', 'show', 'ask', 'best']);
            $table->foreign('by')->references('id')->on('authors')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('stories')->onDelete('cascade');
            $table->integer('time');
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
