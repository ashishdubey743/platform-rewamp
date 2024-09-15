<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class VideoCompilation extends Model
{
    protected $table = 'compiled_videos';

    protected $fillable = [
        'organizations_id', 'groups_id', 'media_path', 'date_from', 'date_to', 'status', 'sent', 'guardians_id',
    ];

    public function SentFamily(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Guardian::class, 'guardians_id');
    }

    public function SentGroup(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Groups::class, 'groups_id');
    }

    public function Organization(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Organization::class, 'organizations_id');
    }

    public function GetURL()
    {
        return Storage::disk('s3')->temporaryUrl('complmultimedia/'.$this->media_path, now()->addDay());
    }
}
