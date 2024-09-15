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
                $table->boolean('reviewed')->after('organization_id')->default(false);
                $table->string('image')->after('reviewed')->nullable();
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
                $table->dropColumn(['reviewed', 'image']);
            });
        }
    }
};
