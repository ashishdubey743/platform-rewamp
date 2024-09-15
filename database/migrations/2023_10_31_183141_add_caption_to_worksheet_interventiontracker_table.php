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
        if (Schema::hasTable('worksheet_interventiontracker')) {
            Schema::table('worksheet_interventiontracker', function (Blueprint $table) {
                $table->text('caption')->nullable()->after('ws_store');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('worksheet_interventiontracker')) {
            Schema::table('worksheet_interventiontracker', function (Blueprint $table) {
                $table->dropColumn('caption');
            });
        }
    }
};
