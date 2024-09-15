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
        if (! Schema::hasTable('multimedia_report_cards')) {
            Schema::create('multimedia_report_cards', function (Blueprint $table) {
                $table->id();
                $table->text('file_name');
                $table->string('path')->default('reportcardmultimedia');
                $table->string('group_name')->nullable();
                $table->text('response_rate')->nullable();
                $table->string('recipient_type', 30);
                $table->foreignId('groups_id')->nullable()->index();
                $table->string('mime_type', 255);
                $table->text('note')->nullable();
                $table->string('date_range', 50);
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
        Schema::dropIfExists('multimedia_report_cards');
    }
};
