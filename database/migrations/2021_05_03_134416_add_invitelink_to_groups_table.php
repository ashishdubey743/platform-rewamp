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
                $table->text('invite_link')->nullable();
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
                $table->dropColumn('invite_link');
            });
        }
    }
};
