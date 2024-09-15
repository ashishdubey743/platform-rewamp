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
        if (! Schema::hasTable('questionnaire_training')) {
            Schema::create('questionnaire_training', function (Blueprint $table) {
                $table->id();
                $table->foreignId('questionnaires_id');
                $table->foreignId('trainings_id');
                $table->tinyInteger('editable')->default(0);
                $table->integer('order');
                $table->tinyInteger('has_prerequisite')->default(0);
                $table->string('pre_req_correct_answer', 45)->nullable();
                $table->tinyInteger('show_score')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaire_training');
    }
};
