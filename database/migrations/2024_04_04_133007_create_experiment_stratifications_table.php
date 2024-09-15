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
        if (! Schema::hasTable('experiment_stratifications')) {
            Schema::create('experiment_stratifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('experiment_id')->index();
                $table->string('strata_group');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiment_stratifications');
    }
};
