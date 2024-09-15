<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Experiment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var mixed
     */
    protected $fillable = [
        'experiment_uuid',
        'name',
        'hypothesis',
        'duration',
        'start_date',
        'end_date',
        'target_metric_movement',
        'confidence_level',
        'primary_tracking_metric',
        'randomization',
        'product_type',
        'user_type',
        'institution_type',
        'number_of_units',
        'user_id',
        'assignments',
        'experiment_commit_id',
        'status',
        'started_at',
        'stopped_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'organizations' => 'array',
        'assignments' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'started_at' => 'datetime',
        'stopped_at' => 'datetime',
    ];

    /* Relationships */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function arms(): HasMany
    {
        return $this->hasMany(ExperimentArm::class);
    }

    public function trackingMetrics(): HasMany
    {
        return $this->hasMany(ExperimentTrackingMetric::class);
    }

    public function strataGroups(): HasMany
    {
        return $this->hasMany(ExperimentStratification::class);
    }

    public function audienceFilters(): HasMany
    {
        return $this->hasMany(ExperimentAudienceFilter::class);
    }
}
