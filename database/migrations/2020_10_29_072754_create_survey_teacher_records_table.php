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
        if (! Schema::hasTable('survey_teacher_records')) {
            Schema::create('survey_teacher_records', function (Blueprint $table) {
                $table->id();
                $table->foreignId('surveys_id');
                $table->string('teacher_phone')->nullable()->index();
                $table->foreign('teacher_phone')->references('phone')->on('moderators');
                $table->boolean('visit')->default(0);
                $table->boolean('submit')->default(0);
                $table->boolean('success')->default(0);
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_teacher_records');
    }
};
