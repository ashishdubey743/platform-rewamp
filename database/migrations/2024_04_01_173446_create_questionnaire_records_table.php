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
        if (! Schema::hasTable('questionnaire_records')) {
            Schema::create('questionnaire_records', function (Blueprint $table) {
                $table->id();
                $table->tinyInteger('visit')->default(1);
                $table->tinyInteger('start')->default(0);
                $table->tinyInteger('submit')->default(0);
                $table->string('cookie_id')->nullable()->index(); // Indexed
                $table->string('filled_phone')->nullable()->unique()->index(); //Unique indexed
                $table->string('language')->nullable();
                $table->foreignId('trainings_id')->nullable()->index(); // foreign key, indexed
                $table->foreignId('questionnaires_id')->index(); // foreign key, indexed
                $table->timestamp('last_visit')->index(); // indexed
                $table->timestamps(); // `created_at` and `updated_at`
                $table->softDeletes(); // `deleted_at`
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaire_records');
    }
};
