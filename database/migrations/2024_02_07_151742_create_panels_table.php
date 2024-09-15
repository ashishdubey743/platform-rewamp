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
        if (! Schema::hasTable('panels')) {
            Schema::create('panels', function (Blueprint $table) {
                $table->id();
                $table->string('panel_name');
                $table->string('graph_header')->nullable();
                $table->string('panel_type')->default('graph');
                $table->string('graph_type');
                $table->smallInteger('complexity')->default(1);
                $table->text('footnote')->nullable();
                $table->string('size');
                $table->string('html_div_id');
                $table->binary('thumbnail')->nullable();
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
        Schema::dropIfExists('panels');
    }
};
