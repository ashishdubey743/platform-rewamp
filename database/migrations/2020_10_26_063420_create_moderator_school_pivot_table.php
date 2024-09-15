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
        if (! Schema::hasTable('moderator_school')) {
            Schema::create('moderator_school', function (Blueprint $table) {
                $table->foreignId('moderator_id')->onDelete('cascade')->index();
                $table->foreignId('schools_id')->onDelete('cascade')->index();
                $table->primary(['moderator_id', 'schools_id']);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moderator_school');
    }
};
