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
        if (! Schema::hasTable('youtubes')) {
            Schema::create('youtubes', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('activity_multimedia_id')->index();
                $table->foreign('activity_multimedia_id')->references('id')->on('activity_multimedia');
                $table->string('channel_name')->nullable();
                $table->string('video_id')->unique()->nullable();
                $table->string('title')->nullable();
                $table->string('description', 2048)->nullable();
                $table->string('tags')->nullable();
                $table->unsignedInteger('category_id')->nullable();
                $table->text('thumbnail')->nullable();
                $table->string('visibility')->nullable();
                $table->timestamp('publish_time')->nullable();
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
        Schema::dropIfExists('youtubes');
    }
};
