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
                $table->string('org_name', 255)->nullable()->after('organizations_id');
                $table->string('grp_name', 255)->nullable()->after('groups_id');
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
                $table->dropColumn(['org_name', 'grp_name']);
            });
        }
    }
};
