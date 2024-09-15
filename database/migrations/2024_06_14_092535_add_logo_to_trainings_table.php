<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('trainings')) {
            Schema::table('trainings', function (Blueprint $table) {
                $table->string('logo')->after('attendance')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('trainings')) {
            Schema::table('trainings', function (Blueprint $table) {
                $table->dropColumn('logo');
            });
        }
    }
};
