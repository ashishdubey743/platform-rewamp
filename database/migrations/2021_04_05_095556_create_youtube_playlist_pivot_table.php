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
        if (! Schema::hasTable('youtube_playlist')) {
            Schema::create('youtube_playlist', function (Blueprint $table) {
                $table->foreignId('youtube_id')->onDelete('cascade');
                $table->foreignId('playlist_id')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('youtube_playlist');
    }
};
