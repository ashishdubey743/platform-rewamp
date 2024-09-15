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
        if (! Schema::hasTable('organizations')) {
            Schema::create('organizations', function (Blueprint $table) {
                $table->id();
                $table->timestamp('start_date')->nullable();
                $table->timestamp('end_date')->nullable();
                $table->boolean('active');
                $table->string('name')->unique()->index();
                $table->string('institution_type');
                $table->string('moderator_type');
                $table->string('district')->nullable();
                $table->string('state')->nullable();
                $table->string('organization_type', 45)->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->string('group_name_prefix')->nullable();
                $table->string('schedule_name')->nullable();
                $table->unsignedBigInteger('urbanization')->nullable();
                $table->string('class_type', 45)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
