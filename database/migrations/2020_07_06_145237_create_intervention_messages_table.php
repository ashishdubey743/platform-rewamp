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
        if (! Schema::hasTable('intervention_messages')) {
            Schema::create('intervention_messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('interventions_id')->index();
                $table->foreignId('intervention_multimedia_id')->nullable();
                $table->string('whatsapp_mid')->unique()->nullable();
                $table->text('delivery_message')->nullable();
                $table->boolean('sent')->default(false);
                $table->boolean('delivered')->default(false);
                $table->timestamp('sent_time')->nullable();
                $table->timestamp('delivery_time')->nullable();
                $table->foreignId('vnumber')->nullable();
                $table->foreignId('w_a_jobs_id')->nullable();
                $table->unsignedTinyInteger('retry_count')->default(0);
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
        Schema::dropIfExists('intervention_messages');
    }
};
