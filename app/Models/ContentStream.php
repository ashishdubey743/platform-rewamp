<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentStream extends Model
{
    use SoftDeletes;

    protected $table = 'content_stream';

    protected $fillable = [
        'id', 'title',
    ];

    public function ContentPackets(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\ContentPacket::class, 'content_stream_packet', 'content_stream_id', 'content_packet_id')
            ->withTimestamps()->withPivot('default_choice', 'id');
    }
}
