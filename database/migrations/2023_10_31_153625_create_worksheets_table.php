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
        if (! Schema::hasTable('worksheets')) {
            Schema::create('worksheets', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('worksheet_domain')->nullable();
                $table->string('institution_type')->nullable();
                $table->text('grade');
                $table->text('raw_ws_media')->nullable();
                $table->text('solved_ws_media')->nullable();
                $table->bigInteger('activity_id')->nullable();
                $table->text('difficulty_level')->nullable();
                $table->enum('training_status', ['0', '1', '2']);
                $table->tinyInteger('ocr_enabled')->default(0);
                $table->timestamps();
                $table->softDeletes();
                $table->tinyInteger('sending_on')->default(1);
                $table->tinyInteger('is_display')->nullable();
                $table->text('instruction_message')->nullable();
                $table->text('instruction_media')->nullable();
                $table->string('vernacular_title')->nullable();
                $table->string('language', 45)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worksheets');
    }
};
