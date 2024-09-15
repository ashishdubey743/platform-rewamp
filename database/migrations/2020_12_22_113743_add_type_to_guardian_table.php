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
                $table->string('type', 255)->nullable()->after('language');
                $table->string('address', 255)->nullable()->after('type');
                $table->timestamp('best_time')->nullable()->after('address');
                $table->string('details', 255)->nullable()->after('best_time');
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
                $table->dropColumn(['type', 'address', 'details', 'best_time']);
            });
        }
    }
};
