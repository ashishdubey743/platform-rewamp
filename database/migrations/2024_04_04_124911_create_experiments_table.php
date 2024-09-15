<?php

use App\Helpers\Experiment\ExperimentUtils;
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
        $dropdownSelectors = json_decode(file_get_contents(base_path('public/drop_down_selector.json')), true);

        if (! Schema::hasTable('experiments')) {
            Schema::create('experiments', function (Blueprint $table) use ($dropdownSelectors) {
                $table->id();
                $table->uuid('experiment_uuid');
                $table->string('name');
                $table->string('hypothesis');
                $table->date('start_date');
                $table->date('end_date');
                $table->integer('target_metric_movement')->nullable()->comment('In Percentage');
                $table->integer('confidence_level')->nullable()->comment('In Percentage');
                $table->string('primary_tracking_metric')->nullable();
                $table->enum('randomization', array_values($dropdownSelectors['experiments']['randomization']) ?? []);
                $table->enum('product_type', array_values($dropdownSelectors['experiments']['product_types']) ?? []);
                $table->enum('user_type', array_values($dropdownSelectors['experiments']['user_types']) ?? []);
                $table->enum('institution_type', array_values($dropdownSelectors['experiments']['institution_types']) ?? [])->nullable();
                $table->unsignedBigInteger('number_of_units')->nullable();
                $table->foreignId('user_id')->default(1);
                $table->json('assignments')->nullable();
                $table->string('experiment_commit_id')->nullable();
                $table->tinyInteger('status')->default(ExperimentUtils::DRAFT);
                $table->timestamp('started_at')->nullable();
                $table->timestamp('stopped_at')->nullable();
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
        Schema::dropIfExists('experiments');
    }
};
