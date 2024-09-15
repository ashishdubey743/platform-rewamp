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
        if (! Schema::hasTable('org_compilation_requests')) {
            Schema::create('org_compilation_requests', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('organizations_id');
                $table->bigInteger('no_of_active_groups')->default(0);
                $table->bigInteger('no_of_compilations_scheduled')->default(0);
                $table->bigInteger('no_of_compilations_sent')->default(0);
                $table->date('compilation_date')->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->date('send_date')->nullable();
                $table->unsignedBigInteger('automation_tracker_id')->nullable();
                // Indexes
                $table->index('compilation_date', 'compldate_indx');
                $table->index('organizations_id', 'orgid_indx');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_compilation_requests');
    }
};
