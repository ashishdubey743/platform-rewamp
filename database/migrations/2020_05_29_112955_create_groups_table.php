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
        if (! Schema::hasTable('groups')) {
            Schema::create('groups', function (Blueprint $table) {
                $table->id();
                $table->timestamp('sync_date')->nullable();
                $table->string('name')->index();
                $table->foreignId('user_id')->default(1);
                $table->string('region')->nullable();
                $table->foreignId('organization_id');
                $table->string('language')->nullable();
                $table->string('type');
                $table->string('whatsapp_id')->unique()->nullable();
                $table->boolean('active')->default(true);
                $table->boolean('admin_right')->default(false);
                $table->boolean('verified')->default(false);
                $table->boolean('send_right')->default(true);
                $table->timestamps();
                $table->softDeletes();
                $table->tinyInteger('onboarded')->default(0);
                $table->dateTime('onboarded_date')->nullable();
                $table->dateTime('onboarding_end_date')->nullable();
                $table->string('tr_status')->nullable();
                $table->tinyInteger('hall_of_fame_2')->default(0);
                $table->tinyInteger('hall_of_fame_5')->default(0);
                $table->string('sunset_tag')->nullable();
                $table->dateTime('tr_date')->nullable();
                $table->string('special_notes')->nullable();
                $table->index('whatsapp_id', 'group_whatsapp_id_index');
                $table->index('organization_id', 'idx_groups_organization_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
