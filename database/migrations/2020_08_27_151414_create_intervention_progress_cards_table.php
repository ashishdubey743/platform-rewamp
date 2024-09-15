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
        if (! Schema::hasTable('intervention_progress_cards')) {
            Schema::create('intervention_progress_cards', function (Blueprint $table) {
                $table->id();
                $table->foreignId('multimedia_report_card_id');
                $table->foreignId('intervention_id');
                $table->foreignId('intervention_multimedia_id');
                $table->string('vnumber', 50);
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
        Schema::dropIfExists('intervention_progress_cards');
    }
};
