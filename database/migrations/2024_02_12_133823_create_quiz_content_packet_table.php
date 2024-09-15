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
        if (! Schema::hasTable('quiz_content_packet')) {
            Schema::create('quiz_content_packet', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('quizzes_id');
                $table->unsignedBigInteger('content_packet_id');
                $table->timestamps();
                $table->softDeletes();
                // Indexes
                $table->index('content_packet_id', 'idx_content_packet_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_content_packet');
    }
};
