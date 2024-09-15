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
        if (! Schema::hasTable('automated_interventions')) {
            Schema::create('automated_interventions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('groups_id');
                $table->bigInteger('guardian_phone')->unsigned()->nullable();
                $table->bigInteger('moderator_phone')->nullable();
                $table->string('caption')->nullable();
                $table->string('location')->nullable();
                $table->string('intervention_type')->nullable();
                $table->tinyInteger('group_message')->nullable();
                $table->tinyInteger('sent')->default(0);
                $table->tinyInteger('delivered')->default(0);
                $table->timestamp('sent_time')->nullable();
                $table->timestamp('delivery_time')->nullable();
                $table->timestamp('schedule_time')->nullable();
                $table->tinyInteger('retry_count')->unsigned()->default(0);
                $table->string('message_id')->nullable();
                $table->timestamp('cancelled_at')->nullable();
                $table->unsignedBigInteger('vnumber')->nullable();
                $table->text('delivery_message')->nullable();
                $table->unsignedBigInteger('automation_tracker_id');
                $table->timestamps();
                $table->softDeletes();
                $table->text('mime_type')->nullable();
                $table->string('type')->nullable();
                $table->tinyInteger('sent_retry')->default(0);
                // Indexes
                $table->index('automation_tracker_id', 'automation_tracker_id_index');
                $table->index('schedule_time', 'schedule_time_index');
                $table->index('guardian_phone', 'guardian_phone_index');
                $table->index('groups_id', 'groups_id_index');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('automated_interventions');
    }
};
