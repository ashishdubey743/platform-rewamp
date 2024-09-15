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
        if (! Schema::hasTable('whatsapp_chat_apis')) {
            Schema::create('whatsapp_chat_apis', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->foreignId('vnumber');
                $table->foreignId('w_a_job_id');
                $table->string('accountStatus')->nullable();
                $table->string('sub_status')->nullable();
                $table->string('qr_code')->nullable();
                $table->boolean('init')->default(false);
                $table->boolean('ban_test')->default(false);
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_chat_apis');
    }
};
