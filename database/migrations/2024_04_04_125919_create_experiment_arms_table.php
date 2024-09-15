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
        if (! Schema::hasTable('experiment_arms')) {
            Schema::create('experiment_arms', function (Blueprint $table) {
                $table->id();
                $table->foreignId('experiment_id')->index();
                $table->uuid('arm_id');
                $table->text('arm_name');
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
        Schema::dropIfExists('experiment_arms');
    }
};
