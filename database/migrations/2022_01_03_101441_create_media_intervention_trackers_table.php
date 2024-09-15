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
        if (! Schema::hasTable('media_intervention_trackers')) {
            Schema::create('media_intervention_trackers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('intervention_trackers_id')->onDelete('cascade');
                $table->timestamp('scheduled_time')->nullable();
                $table->longText('media_type')->nullable();
                $table->integer('status')->default(0);
                $table->foreignId('user_id');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_intervention_trackers');
    }
};
