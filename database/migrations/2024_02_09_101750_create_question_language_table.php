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
        if (! Schema::hasTable('question_language')) {
            Schema::create('question_language', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('questions_id');
                $table->string('language');
                $table->timestamps();
                $table->softDeletes();
                $table->text('question_text')->nullable();
                $table->string('question_voicenote')->nullable();
                $table->string('question_options')->nullable();
                // Index
                $table->index('questions_id', 'idx_questions_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_language');
    }
};
