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
        if (! Schema::hasTable('guardians')) {
            Schema::create('guardians', function (Blueprint $table) {
                $table->id();
                $table->string('mother_name')->index()->nullable();
                $table->string('father_name')->index()->nullable();
                $table->foreignId('user_id')->default(1);
                $table->string('phone')->unique()->index();
                $table->string('region')->nullable();
                $table->string('language')->nullable();
                $table->boolean('active')->default(false);
                $table->boolean('added')->default(false);
                $table->foreignId('groups_id')->nullable();
                $table->timestamp('date_left')->nullable();
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
        Schema::dropIfExists('guardians');
    }
};
