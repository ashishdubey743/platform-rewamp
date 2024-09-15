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
        if (! Schema::hasTable('vnumber_billings')) {
            Schema::create('vnumber_billings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('vnumber')->onDelete('cascade');
                $table->timestamp('date');
                $table->boolean('active')->default(true);
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
        Schema::dropIfExists('vnumber_billings');
    }
};
