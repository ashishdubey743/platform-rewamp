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
        if (Schema::hasTable('moderators')) {
            Schema::table('moderators', function (Blueprint $table) {
                $table->string('block')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('moderators')) {
            Schema::table('moderators', function (Blueprint $table) {
                $table->dropColumn('block');
            });
        }
    }
};
