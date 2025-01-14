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
        if (! Schema::hasTable('invites')) {
            Schema::create('invites', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('email')->unique();
                $table->unsignedBigInteger('role_id');
                $table->string('token', 20)->unique();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invites');
    }
};
