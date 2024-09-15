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
        if (! Schema::hasTable('dashboard_panel')) {
            Schema::create('dashboard_panel', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('dashboard_id');
                $table->unsignedBigInteger('panel_id');
                $table->tinyInteger('is_default')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboard_panel');
    }
};
