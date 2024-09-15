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
        if (! Schema::hasTable('activity_learning_domain_new')) {
            Schema::create('activity_learning_domain_new', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('learning_domain_id');
                $table->unsignedBigInteger('activity_id');
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
        Schema::dropIfExists('activity_learning_domain_new');
    }
};
