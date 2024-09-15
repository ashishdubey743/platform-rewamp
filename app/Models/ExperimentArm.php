<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ExperimentArm extends Model
{
    use SoftDeletes;

    /**
     * @var mixed
     */
    protected $fillable = [
        'experiment_id',
        'arm_id',
        'arm_name',
    ];

    public static function boot(): void
    {
        parent::boot();
        self::creating(function ($model) {
            $model->arm_id = Str::uuid();
        });
    }
}
