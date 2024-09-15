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
        if (! Schema::hasTable('user_dashboard_panels')) {
            Schema::create('user_dashboard_panels', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_dashboard_id');
                $table->unsignedBigInteger('dashboard_panel_id');
                $table->integer('display_order');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_dashboard_panels');
    }
};
