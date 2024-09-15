<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class youtube extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'activity_multimedia_id', 'channel_name', 'video_id', 'title', 'description', 'tags', 'category_id', 'thumbnail', 'visibility', 'publish_time',
    ];

    public function activityMultimedia(): BelongsTo
    {
        return $this->belongsTo(\App\Models\ActivityMultimedia::class);
    }

    public function playlistManaged(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\youtube::class, 'youtube_playlist', 'youtube_id', 'playlist_id')->withTimestamps();
    }
}
