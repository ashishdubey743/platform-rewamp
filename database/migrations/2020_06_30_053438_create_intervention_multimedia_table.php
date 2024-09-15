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
        if (! Schema::hasTable('intervention_multimedia')) {
            Schema::create('intervention_multimedia', function (Blueprint $table) {
                $table->id();
                $table->string('type');
                $table->boolean('youtube')->default(false);
                $table->boolean('cloud')->default(true);
                $table->text('location')->nullable();
                $table->text('mime_type')->nullable();
                $table->boolean('link')->default(false);
                $table->foreignId('intervention_id');
                $table->boolean('activity')->default(false);
                $table->timestamps();
                $table->softDeletes();
                $table->unsignedBigInteger('duration')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intervention_multimedia');
    }
};
