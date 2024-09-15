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
        if (! Schema::hasTable('experiment_audience_filters')) {
            Schema::create('experiment_audience_filters', function (Blueprint $table) {
                $table->id();
                $table->foreignId('experiment_id')->index();
                $table->string('filter_name');
                $table->string('data_type');
                $table->string('value')->nullable()->comment('For the single filter value');
                $table->json('values')->nullable()->comment('For the multiple filter values');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiment_audience_filters');
    }
};
