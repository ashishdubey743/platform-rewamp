<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReviewChildrenImage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'guardian_id', 'kid_id', 'image',
    ];
}
