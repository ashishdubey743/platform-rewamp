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
        if (! Schema::hasTable('polls')) {
            Schema::create('polls', function (Blueprint $table) {
                $table->id();
                $table->string('poll_name');
                $table->string('org_type')->nullable();
                $table->string('poll_tag');
                $table->string('poll_question');
                $table->bigInteger('number_of_options');
                $table->string('response_type');
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
        Schema::dropIfExists('polls');
    }
};
