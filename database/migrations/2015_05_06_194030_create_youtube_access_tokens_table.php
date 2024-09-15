<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('youtube_access_tokens')) {
            Schema::create('youtube_access_tokens', function (Blueprint $table) {
                $table->increments('id');
                $table->text('access_token');
                $table->timestamp('created_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('youtube_access_tokens');
    }
};
