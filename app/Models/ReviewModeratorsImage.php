<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReviewModeratorsImage extends Model
{
    protected $table = 'review_moderators_images';

    use SoftDeletes;

    protected $fillable = [
        'moderator_id', 'image',
    ];
}
