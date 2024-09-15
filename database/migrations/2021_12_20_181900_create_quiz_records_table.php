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
        if (! Schema::hasTable('quiz_records')) {
            Schema::create('quiz_records', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('quiz_id')->unsigned()->nullable('false');
                $table->bigInteger('groups_id')->nullable()->default(null);
                $table->string('guardian_phone')->nullable()->default(null);
                $table->boolean('visit')->default(0);
                $table->boolean('submit')->default(0);
                $table->bigInteger('responder_quiz_id')->nullable()->default(null);
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_records');
    }
};
