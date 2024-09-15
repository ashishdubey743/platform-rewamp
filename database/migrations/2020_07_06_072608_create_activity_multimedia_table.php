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
        if (! Schema::hasTable('activity_multimedia')) {
            Schema::create('activity_multimedia', function (Blueprint $table) {
                $table->id();
                $table->string('internal');
                $table->foreignId('activity_id');
                $table->text('multimedia_location')->nullable();
                $table->string('external_source')->default('');
                $table->string('type');
                $table->string('language');
                $table->string('title')->nullable();
                $table->text('subscript_location')->nullable();
                $table->string('mime_type')->default('');
                $table->string('audio_type')->nullable();
                $table->string('activity_format')->nullable();
                $table->string('gender_children')->nullable();
                $table->string('gender_facilitator')->nullable();
                $table->string('gender_rl')->nullable();
                $table->string('religion_children')->nullable();
                $table->text('notes')->nullable();
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
        Schema::dropIfExists('activity_multimedia');
    }
};
