<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('activity_interventiontracker')) {
            Schema::create('activity_interventiontracker', function (Blueprint $table) {
                $table->id();
                $table->foreignId('activity_id')->onDelete('cascade');
                $table->foreignId('intervention_trackers_id')->onDelete('cascade');
                $table->string('language');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_interventiontracker');
    }
};
