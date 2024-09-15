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
        if (! Schema::hasTable('questionnaire_enquiries')) {
            Schema::create('questionnaire_enquiries', function (Blueprint $table) {
                $table->id();
                $table->tinyInteger('mandatory')->default(1);
                $table->tinyInteger('page_break')->default(0);
                $table->string('skip_logic', 255)->nullable();
                $table->tinyInteger('count_score')->default(0);
                $table->string('type', 255)->nullable();
                $table->integer('order');
                $table->string('validate_type', 255)->nullable();

                // Use foreignId for a concise foreign key definition
                $table->foreignId('questionnaires_id')->index();

                $table->string('correct_answer', 45)->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaire_enquiries');
    }
};
