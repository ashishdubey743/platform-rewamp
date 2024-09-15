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
        if (! Schema::hasTable('maintenance')) {
            Schema::create('maintenance', function (Blueprint $table) {
                $table->id();
                $table->text('remark')->nullable();
                $table->boolean('instant')->default(false);
                $table->boolean('action')->default(false);
                $table->boolean('finished')->default(false);
                $table->boolean('on_start_notification')->default(false);
                $table->boolean('on_end_notification')->default(false);
                $table->timestamp('start_time')->nullable();
                $table->timestamp('end_time')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance');
    }
};
