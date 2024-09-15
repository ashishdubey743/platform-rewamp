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
        if (Schema::hasTable('groups')) {
            Schema::table('groups', function (Blueprint $table) {
                $table->foreignId('schools_id')->nullable()->onDelete('cascade')->index();
                $table->string('class')->nullable();
                $table->string('section')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('groups')) {
            Schema::table('groups', function (Blueprint $table) {
                $table->dropColumn(['schools_id', 'class', 'section']);
            });
        }
    }
};
