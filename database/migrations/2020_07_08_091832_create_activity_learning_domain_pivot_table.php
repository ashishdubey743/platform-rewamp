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
        if (! Schema::hasTable('activity_learning_domain')) {
            Schema::create('activity_learning_domain', function (Blueprint $table) {
                $table->id();
                $table->foreignId('learning_domain_id')->onDelete('cascade');
                $table->foreignId('activity_id')->onDelete('cascade');
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
        Schema::dropIfExists('activity_learning_domain');
    }
};
