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
        if (! Schema::hasTable('data_exports')) {
            Schema::create('data_exports', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id');
                $table->string('status')->nullable();
                $table->string('jfname')->nullable();
                $table->string('input')->nullable();
                $table->text('message')->nullable();
                $table->text('url')->nullable();
                $table->timestamp('end_time')->nullable();
                $table->timestamp('start_time')->nullable();
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
        Schema::dropIfExists('data_exports');
    }
};
