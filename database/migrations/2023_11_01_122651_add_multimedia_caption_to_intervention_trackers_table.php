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
        if (Schema::hasTable('intervention_trackers')) {
            Schema::table('intervention_trackers', function (Blueprint $table) {
                $table->text('multimedia_caption')->nullable()->after('description');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('intervention_trackers')) {
            Schema::table('intervention_trackers', function (Blueprint $table) {
                $table->dropColumn('multimedia_caption');
            });
        }
    }
};
