<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperimentTrackingMetric extends Model
{
    /**
     * @var mixed
     */
    protected $fillable = [
        'experiment_id',
        'tracking_metric',
    ];
}
