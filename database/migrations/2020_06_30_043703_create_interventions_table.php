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
        if (! Schema::hasTable('interventions')) {
            Schema::create('interventions', function (Blueprint $table) {
                $table->id();
                $table->longText('message_text')->nullable();
                $table->string('language');
                $table->foreignId('user_id');
                $table->boolean('target_group')->default(true);
                $table->boolean('source_activity')->default(false);
                $table->foreignId('guardian_id')->nullable();
                $table->foreignId('groups_id')->nullable();
                $table->boolean('direct')->default(true);
                $table->string('intervention_type')->nullable();
                $table->text('internal_notes')->nullable();
                $table->timestamp('scheduled_time')->nullable();
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
        Schema::dropIfExists('interventions');
    }
};
