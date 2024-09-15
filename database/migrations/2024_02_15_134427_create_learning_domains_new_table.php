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
        if (! Schema::hasTable('learning_domains_new')) {
            Schema::create('learning_domains_new', function (Blueprint $table) {
                $table->id();
                $table->string('learning_domain');
                $table->string('sub_domain');
                $table->string('sub_sub_domain')->nullable();
                $table->longText('learning_outcome');
                $table->string('tag')->nullable();
                $table->text('pre_requisite')->nullable();
                $table->string('type')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_domains_new');
    }
};
