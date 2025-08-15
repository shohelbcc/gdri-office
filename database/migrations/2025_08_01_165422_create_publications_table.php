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
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->string('authors');
            $table->year('published_year');
            $table->string('link')->nullable();
            $table->string('paper_type')->nullable();
            $table->string('slug')->unique();
            $table->foreignId('publication_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_topic_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
