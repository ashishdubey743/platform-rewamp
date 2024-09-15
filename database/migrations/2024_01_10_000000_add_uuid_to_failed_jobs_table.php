<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('failed_jobs')) {
            // Check if the uuid column already exists before adding it
            if (!Schema::hasColumn('failed_jobs', 'uuid')) {
                Schema::table('failed_jobs', function (Blueprint $table) {
                    $table->string('uuid')->after('id')->nullable()->unique();
                });

                // Assign UUID values to existing rows where uuid is null
                DB::table('failed_jobs')->whereNull('uuid')->cursor()->each(function ($job) {
                    DB::table('failed_jobs')
                        ->where('id', $job->id)
                        ->update(['uuid' => (string) Str::uuid()]);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('failed_jobs')) {
            if (Schema::hasColumn('failed_jobs', 'uuid')) {
                Schema::table('failed_jobs', function (Blueprint $table) {
                    $table->dropColumn('uuid');
                });
            }
        }
    }
};
