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
        if (! Schema::hasTable('questionnaires')) {
            Schema::create('questionnaires', function (Blueprint $table) {
                $table->id(); // This creates a bigint unsigned NOT NULL AUTO_INCREMENT `id`
                $table->string('name')->unique(); // varchar(255) and unique
                $table->string('type'); // varchar(255)
                $table->foreignId('user_id')->default(1); // foreign key NOT NULL DEFAULT '1'
                $table->tinyInteger('is_correctible')->default(0); // tinyint(1) DEFAULT '0'
                $table->timestamps(); // This creates `created_at` and `updated_at` timestamps
                $table->softDeletes(); // This creates `deleted_at` timestamp for soft deletes
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaires');
    }
};
