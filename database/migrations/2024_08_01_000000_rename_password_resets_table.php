<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the 'password_reset' table exists and 'password_reset_tokens' does not exist
        if (Schema::hasTable('password_resets') && !Schema::hasTable('password_reset_tokens')) {
            Schema::rename('password_resets', 'password_reset_tokens');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if 'password_reset_tokens' exists before renaming it back
        if (Schema::hasTable('password_reset_tokens') && !Schema::hasTable('password_resets')) {
            Schema::rename('password_reset_tokens', 'password_resets');
        }
    }
};
