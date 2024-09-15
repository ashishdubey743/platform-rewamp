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
        if (! Schema::hasTable('custom_certificates')) {
            Schema::create('custom_certificates', function (Blueprint $table) {
                $table->id();
                $table->string('path')->default('certificatemultimedia');
                $table->string('recipient_type')->nullable();
                $table->foreignId('user_id');
                $table->integer('status')->default(0);
                $table->boolean('sent')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_certificates');
    }
};
