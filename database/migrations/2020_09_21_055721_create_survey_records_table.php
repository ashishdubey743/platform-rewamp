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
        if (! Schema::hasTable('survey_records')) {
            Schema::create('survey_records', function (Blueprint $table) {
                $table->id();
                $table->foreignId('surveys_id');
                $table->string('guardian_phone')->nullable()->index();
                $table->foreign('guardian_phone')->references('phone')->on('guardians');
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
        Schema::dropIfExists('survey_records');
    }
};
