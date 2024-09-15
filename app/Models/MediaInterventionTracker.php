<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaInterventionTracker extends Model
{
    protected $table = 'media_interventiontracker';

    protected $fillable = [
        'media_type', 'intervention_trackers_id', 'worksheet_id', 'folder_name', 'status', 'schedule_time',
    ];

    protected $casts = [
        'scheduled_time' => 'datetime',
    ];

    public function worksheet(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Worksheet::class, 'worksheet_id');
    }

    public function interventionTracker(): BelongsTo
    {
        return $this->belongsTo(\App\Models\InterventionTracker::class, 'intervention_trackers_id');
    }
}
