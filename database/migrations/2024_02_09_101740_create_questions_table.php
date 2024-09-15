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
        if (! Schema::hasTable('questions')) {
            Schema::create('questions', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->text('mm_location')->nullable();
                $table->string('answers');
                $table->string('difficulty_level')->nullable();
                $table->bigInteger('learning_domain_id')->unsigned()->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->string('message_template')->nullable();
                $table->bigInteger('activities_id')->unsigned()->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
