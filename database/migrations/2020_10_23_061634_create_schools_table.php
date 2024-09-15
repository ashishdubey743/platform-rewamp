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
        if (! Schema::hasTable('schools')) {
            Schema::create('schools', function (Blueprint $table) {
                $table->id();
                $table->timestamp('date_left')->nullable();
                $table->string('name')->index()->nullable();
                $table->foreignId('user_id')->default(1);
                $table->foreignId('organization_id')->index();
                $table->boolean('active')->default(1);
                $table->string('e_Identifiers')->nullable()->unique();
                $table->string('type')->nullable();
                $table->string('block')->nullable();
                $table->integer('enrollment')->nullable();
                $table->softDeletes();
                $table->timestamps();
                $table->string('district')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
