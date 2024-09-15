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
        if (! Schema::hasTable('group_vnumber')) {
            Schema::create('group_vnumber', function (Blueprint $table) {
                $table->foreignId('groups_id')->onDelete('cascade');
                $table->foreignId('vnumber')->onDelete('cascade');
                $table->timestamps();
                $table->string('role');
                $table->boolean('admin')->default(false);
                $table->boolean('added')->default(false);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_vnumber');
    }
};
