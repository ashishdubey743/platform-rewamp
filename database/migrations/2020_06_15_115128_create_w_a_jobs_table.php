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
        if (! Schema::hasTable('w_a_jobs')) {
            Schema::create('w_a_jobs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('vnumber')->nullable();
                $table->foreignId('user_id');
                $table->string('status')->nullable();
                $table->string('action');
                $table->string('jfname')->nullable();
                $table->string('input')->nullable();
                $table->text('message')->nullable();
                $table->text('url')->nullable();
                $table->timestamp('completed_time')->nullable();
                $table->timestamp('start_time')->nullable();
                $table->timestamp('ETA')->nullable();
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
        Schema::dropIfExists('w_a_jobs');
    }
};
