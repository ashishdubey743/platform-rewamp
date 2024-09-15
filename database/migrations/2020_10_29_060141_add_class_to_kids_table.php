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
        if (Schema::hasTable('kids')) {
            Schema::table('kids', function (Blueprint $table) {
                $table->string('class', 255)->nullable()->after('preschool_private');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('kids')) {
            Schema::table('kids', function (Blueprint $table) {
                $table->dropColumn('class');
            });
        }
    }
};
