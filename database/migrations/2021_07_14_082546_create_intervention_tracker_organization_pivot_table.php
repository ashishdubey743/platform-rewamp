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
        if (! Schema::hasTable('interventiontracker_organization')) {
            Schema::create('interventiontracker_organization', function (Blueprint $table) {
                $table->foreignId('organizations_id')->onDelete('cascade');
                $table->foreignId('intervention_trackers_id')->onDelete('cascade');
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
        Schema::dropIfExists('interventiontracker_organization');
    }
};
