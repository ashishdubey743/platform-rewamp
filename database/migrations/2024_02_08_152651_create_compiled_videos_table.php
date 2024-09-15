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
        if (! Schema::hasTable('compiled_videos')) {
            Schema::create('compiled_videos', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('organizations_id');
                $table->unsignedBigInteger('groups_id');
                $table->timestamp('date_from')->nullable();
                $table->timestamp('date_to')->nullable();
                $table->string('media_path', 512)->nullable();
                $table->tinyInteger('status')->default(0);
                $table->timestamps();
                $table->softDeletes();
                $table->tinyInteger('sent')->default(0);
                $table->tinyInteger('retry_count')->default(0);
                $table->unsignedBigInteger('org_compilation_request_id')->nullable();
                $table->unsignedBigInteger('automated_intervention_id')->nullable();

                // Add foreign key constraints
                $table->foreign('org_compilation_request_id')->references('id')->on('org_compilation_requests');
                $table->foreign('automated_intervention_id')->references('id')->on('automated_interventions');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compiled_videos');
    }
};
