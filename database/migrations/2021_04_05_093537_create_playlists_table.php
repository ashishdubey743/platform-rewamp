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
        if (! Schema::hasTable('playlists')) {
            Schema::create('playlists', function (Blueprint $table) {
                $table->id();
                $table->string('channel_name')->nullable();
                $table->string('channel_id')->nullable();
                $table->string('name')->nullable();
                $table->string('playlistId')->unique()->nullable();
                $table->string('language')->nullable();
                $table->string('description', 512)->nullable();
                $table->string('visibility')->nullable();
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
        Schema::dropIfExists('playlists');
    }
};
