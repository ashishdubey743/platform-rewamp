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
                $table->dropUnique('questionnaire_records_filled_phone_unique');
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
                $table->unique('filled_phone', 'questionnaire_records_filled_phone_unique');
            });
        }
    }
};
