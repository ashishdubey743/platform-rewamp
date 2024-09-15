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
        if (! Schema::hasTable('intervention_trackers')) {
            Schema::create('intervention_trackers', function (Blueprint $table) {
                $table->id();
                $table->softDeletes();
                $table->longText('message_text')->nullable();
                $table->longText('multimedia')->nullable();
                $table->longText('description')->nullable();
                $table->foreignId('user_id');
                $table->boolean('target_group')->default(true);
                $table->boolean('cancelled')->default(false);
                $table->decimal('eta', 21, 3)->default(0);
                $table->boolean('source_activity')->default(false);
                $table->integer('status')->default(0);
                $table->boolean('direct')->default(true);
                $table->string('intervention_type')->nullable();
                $table->text('internal_notes')->nullable();
                $table->timestamp('scheduled_time')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intervention_trackers');
    }
};
