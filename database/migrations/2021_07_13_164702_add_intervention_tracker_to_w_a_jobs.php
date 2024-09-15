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
        if (Schema::hasTable('w_a_jobs')) {
            Schema::table('w_a_jobs', function (Blueprint $table) {
                $table->foreignId('intervention_trackers_id')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('w_a_jobs')) {
            Schema::table('w_a_jobs', function (Blueprint $table) {
                $table->dropColumn('intervention_trackers_id');
            });
        }
    }
};
