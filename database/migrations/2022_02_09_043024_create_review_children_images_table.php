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
        if (! Schema::hasTable('review_children_images')) {
            Schema::create('review_children_images', function (Blueprint $table) {
                $table->id();
                $table->foreignId('guardian_id')->references('id')->on('guardians')->onDelete('cascade');
                $table->foreignId('kid_id')->references('id')->on('kids')->onDelete('cascade');
                $table->string('image', 255);
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
        Schema::dropIfExists('review_children_images');
    }
};
