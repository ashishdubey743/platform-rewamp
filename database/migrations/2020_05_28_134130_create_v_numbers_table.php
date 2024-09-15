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
        if (! Schema::hasTable('v_numbers')) {
            Schema::create('v_numbers', function (Blueprint $table) {
                $table->string('vnumber');
                $table->primary('vnumber');
                $table->timestamps();
                $table->timestamp('block_date')->nullable();
                $table->timestamp('deactive_date')->nullable();
                $table->boolean('active')->default(true);
                $table->boolean('blocked')->default(false);
                $table->boolean('initialize')->default(false);
                $table->string('type')->nullable();
                $table->string('API_Token')->nullable()->unique();
                $table->string('API_InstanceID')->nullable()->unique();
                $table->text('API_Url')->nullable();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_numbers');
    }
};
