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
        if (! Schema::hasTable('review_moderators_images')) {
            Schema::create('review_moderators_images', function (Blueprint $table) {
                $table->id();
                $table->foreignId('moderator_id')->references('id')->on('moderators')->onDelete('cascade');
                $table->string('image', 255);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_moderators_images');
    }
};
