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
        if (! Schema::hasTable('questionnaire_answers')) {
            Schema::create('questionnaire_answers', function (Blueprint $table) {
                $table->id();
                $table->string('response', 255);
                $table->foreignId('questionnaires_id')->index();
                $table->foreignId('questionnaire_enquiries_id')->index();
                $table->foreignId('questionnaire_records_id')->index();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaire_answers');
    }
};
