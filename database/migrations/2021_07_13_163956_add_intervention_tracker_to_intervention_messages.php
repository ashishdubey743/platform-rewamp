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
        if (Schema::hasTable('intervention_messages')) {
            Schema::table('intervention_messages', function (Blueprint $table) {
                $table->boolean('cancelled')->default(false);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('intervention_messages')) {
            Schema::table('intervention_messages', function (Blueprint $table) {
                $table->dropColumn('cancelled');
            });
        }
    }
};
