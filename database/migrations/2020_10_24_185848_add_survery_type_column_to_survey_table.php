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
        if (Schema::hasTable('surveys')) {
            Schema::table('surveys', function (Blueprint $table) {
                $table->string('survey_type', 50)->default('Parent')->after('link');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('surveys')) {
            Schema::table('surveys', function (Blueprint $table) {
                $table->dropColumn('survey_type');
            });
        }
    }
};
