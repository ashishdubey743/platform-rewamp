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
        if (! Schema::hasTable('district_organization')) {
            Schema::create('district_organization', function (Blueprint $table) {
                $table->foreignId('districts_id')->references('id')->on('districts')->onDelete('cascade');
                $table->foreignId('organizations_id')->references('id')->on('organizations')->onDelete('cascade');
                $table->primary(['districts_id', 'organizations_id']);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('district_organization');
    }
};
