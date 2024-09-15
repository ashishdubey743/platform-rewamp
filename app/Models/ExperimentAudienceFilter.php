<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperimentAudienceFilter extends Model
{
    /**
     * @var mixed
     */
    protected $fillable = [
        'experiment_id',
        'filter_name',
        'data_type',
        'relation',
        'value',
        'values',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'values' => 'array',
    ];
}
