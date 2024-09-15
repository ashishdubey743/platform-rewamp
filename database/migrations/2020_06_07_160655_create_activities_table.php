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
        if (! Schema::hasTable('activities')) {
            Schema::create('activities', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->foreignId('user_id')->default(1);
                $table->text('activity_description');
                $table->string('activity_type');
                $table->string('demo_type');
                $table->string('difficulty_level');
                $table->string('impact_timeline');
                $table->string('group_size');
                $table->string('audience');
                $table->string('required_materials');
                $table->string('response_type');
                $table->string('activity_domain')->nullable();
                $table->string('institution_type')->nullable();
                $table->string('call_to_action')->nullable();
                $table->string('activity_time')->nullable();
                $table->tinyInteger('independent_engagement')->nullable();
                $table->text('play_type');
                $table->text('thematic_alignment');
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
        Schema::dropIfExists('activities');
    }
};
