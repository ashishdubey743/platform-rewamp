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
        if (Schema::hasTable('guardians')) {
            Schema::table('guardians', function (Blueprint $table) {
                $table->string('previous_group_ids', 255)->after('groups_id')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('guardians')) {
            Schema::table('guardians', function (Blueprint $table) {
                $table->dropColumn('previous_group_ids');
            });
        }
    }
};
