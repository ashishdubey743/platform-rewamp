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
        if (! Schema::hasTable('interactions')) {
            Schema::create('interactions', function (Blueprint $table) {
                $table->id();
                $table->boolean('downloaded')->default(false);
                $table->foreignId('interventions_id')->nullable()->index();
                $table->string('whatsapp_uid')->unique()->nullable();
                $table->string('guardian_phone')->nullable()->index();
                $table->foreignId('groups_id')->nullable()->index();
                $table->string('moderator_phone')->nullable()->index();
                $table->foreign('guardian_phone')->references('phone')->on('guardians');
                $table->timestamp('sent_time');
                $table->string('multimedia_type')->nullable();
                $table->string('multimedia_location')->nullable();
                $table->foreignId('organization_id')->nullable()->index();
                $table->string('message_type')->nullable();
                $table->boolean('from_parent')->default(true);
                $table->foreign('moderator_phone')->references('phone')->on('moderators');
                $table->longText('text')->nullable();
                $table->unsignedBigInteger('duration')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interactions');
    }
};
