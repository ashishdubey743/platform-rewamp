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
                $table->boolean('reviewed')->after('name')->default(false);
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
                $table->dropColumn('reviewed');
            });
        }
    }
};
