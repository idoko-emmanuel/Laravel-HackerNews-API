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
        Schema::create('comments', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->text('text')->nullable();
            $table->string('by')->unsigned();
            $table->integer('points')->default(0);
            $table->foreign('by')->references('id')->on('authors')->onDelete('cascade');
            $table->Morphs('commentable');
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
        Schema::dropIfExists('comments');
    }
};
