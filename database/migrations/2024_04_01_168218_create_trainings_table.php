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
        if (! Schema::hasTable('trainings')) {
            Schema::create('trainings', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255)->unique()->index();
                $table->text('description')->nullable();
                $table->string('level', 255)->nullable();
                $table->tinyInteger('attendance')->default(0);
                $table->timestamp('start_date');
                $table->timestamp('end_date')->nullable();
                $table->foreignId('user_id')->default(1)->index();
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
        Schema::dropIfExists('trainings');
    }
};
