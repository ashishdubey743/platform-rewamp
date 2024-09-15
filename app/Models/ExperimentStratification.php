<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperimentStratification extends Model
{
    /**
     * @var mixed
     */
    protected $fillable = [
        'experiment_id',
        'strata_group',
    ];
}
