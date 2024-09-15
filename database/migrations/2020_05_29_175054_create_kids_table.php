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
        if (! Schema::hasTable('kids')) {
            Schema::create('kids', function (Blueprint $table) {
                $table->id();
                $table->timestamp('birthday')->nullable();
                $table->string('name')->index()->nullable();
                $table->string('gender')->index()->nullable();
                $table->foreignId('guardian_id')->index();
                $table->boolean('preschool_attend')->default(true);
                $table->boolean('preschool_age')->default(true);
                $table->boolean('preschool_private')->default(false);
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
        Schema::dropIfExists('kids');
    }
};
