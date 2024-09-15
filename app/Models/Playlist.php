<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Playlist extends Model
{
    protected $fillable = [
        'channel_name', 'channel_id', 'name', 'playlistId', 'language', 'description', 'visibility',
    ];

    public function youtubeVideoManaged(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Playlist::class, 'youtube_playlist', 'playlist_id', 'youtube_id')->withTimestamps();
    }
}
