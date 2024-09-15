<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('organization_vnumber')) {
            Schema::create('organization_vnumber', function (Blueprint $table) {
                $table->id();
                $table->foreignId('organizations_id')->onDelete('cascade');
                $table->foreignId('vnumber')->onDelete('cascade');
                $table->timestamps();
                $table->string('role');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_vnumber');
    }
};
