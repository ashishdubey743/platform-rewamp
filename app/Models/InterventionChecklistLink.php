<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterventionChecklistLink extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'link',
        'belonging_date',
    ];
}
