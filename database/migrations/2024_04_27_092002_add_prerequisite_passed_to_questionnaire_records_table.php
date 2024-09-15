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
        if (Schema::hasTable('questionnaire_records')) {
            Schema::table('questionnaire_records', function (Blueprint $table) {
                $table->boolean('prerequisite_passed')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('questionnaire_records')) {
            Schema::table('questionnaire_records', function (Blueprint $table) {
                $table->dropColumn('prerequisite_passed');
            });
        }
    }
};
