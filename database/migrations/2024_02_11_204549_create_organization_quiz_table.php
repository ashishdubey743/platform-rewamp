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
        if (! Schema::hasTable('organization_quiz')) {
            Schema::create('organization_quiz', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('organizations_id');
                $table->unsignedBigInteger('quizzes_id');
                $table->timestamps();
                $table->softDeletes();
                // Indexes
                $table->index('organizations_id', 'idx_organizations_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_quiz');
    }
};
