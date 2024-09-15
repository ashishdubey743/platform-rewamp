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
        if (! Schema::hasTable('moderators')) {
            Schema::create('moderators', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('phone')->unique()->index();
                $table->timestamp('date_left')->nullable();
                $table->string('name')->index()->nullable();
                $table->foreignId('user_id')->default(1);
                $table->foreignId('organization_id')->index();
                $table->string('role')->nullable();
                $table->boolean('active');
                $table->string('e_role')->nullable();
                $table->string('e_Identifiers')->nullable();
                $table->softDeletes();
                $table->nestedSet();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moderators');
    }
};
