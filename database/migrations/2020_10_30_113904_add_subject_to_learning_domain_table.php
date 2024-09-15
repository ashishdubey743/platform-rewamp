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
        if (Schema::hasTable('learning_domains')) {
            Schema::table('learning_domains', function (Blueprint $table) {
                $table->string('subject', 255)->nullable()->after('tag');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('learning_domains')) {
            Schema::table('learning_domains', function (Blueprint $table) {
                $table->dropColumn('subject');
            });
        }
    }
};
