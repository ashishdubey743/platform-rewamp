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
        if (! Schema::hasTable('organization_moderator')) {
            Schema::create('organization_moderator', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('organizations_id');
                $table->unsignedBigInteger('moderator_id');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();

                $table->unique(['organizations_id', 'moderator_id'], 'idx_org_id_moderator_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_moderator');
    }
};
