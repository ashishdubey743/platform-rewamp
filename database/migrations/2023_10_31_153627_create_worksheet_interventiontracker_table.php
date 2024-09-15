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
        if (! Schema::hasTable('worksheet_interventiontracker')) {
            Schema::create('worksheet_interventiontracker', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('worksheet_id')->unsigned()->nullable();
                $table->bigInteger('intervention_trackers_id')->unsigned()->nullable();
                $table->tinyInteger('ws_store')->default(0);
                $table->timestamps();
                $table->softDeletes();
                // Foreign keys
                $table->foreign('worksheet_id')->references('id')->on('worksheets')->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('intervention_trackers_id')->references('id')->on('intervention_trackers')->onDelete('set null')->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worksheet_interventiontracker');
    }
};
