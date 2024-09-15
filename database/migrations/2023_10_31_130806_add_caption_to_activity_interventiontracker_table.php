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
        if (Schema::hasTable('activity_interventiontracker')) {
            Schema::table('activity_interventiontracker', function (Blueprint $table) {
                $table->text('caption')->nullable()->after('language');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('activity_interventiontracker')) {
            Schema::table('activity_interventiontracker', function (Blueprint $table) {
                $table->dropColumn('caption');
            });
        }
    }
};
