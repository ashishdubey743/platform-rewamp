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
        if (! Schema::hasTable('group_moderator')) {
            Schema::create('group_moderator', function (Blueprint $table) {
                $table->foreignId('groups_id')->onDelete('cascade');
                $table->foreignId('moderator_id')->onDelete('cascade');
                $table->timestamps();
                $table->boolean('main')->default(false);
                $table->boolean('added')->default(false);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_moderator');
    }
};
