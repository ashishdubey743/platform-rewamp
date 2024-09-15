<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Intervention extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'message_text', 'language',
        'user_id', 'target_group', 'guardian_id',
        'groups_id', 'direct', 'intervention_type', 'internal_notes', 'source_activity', 'scheduled_time',
        'content_stream_tracker_id',
    ];

    protected $casts = [
        'direct' => 'boolean',
        'target_group' => 'boolean',
        'source_activity' => 'boolean',
        'scheduled_time' => 'datetime',
    ];

    public function administrator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function Multimedia(): HasMany
    {
        return $this->hasMany(\App\Models\InterventionMultimedia::class);
    }

    public function Messages(): HasMany
    {
        return $this->hasMany(\App\Models\InterventionMessage::class, 'interventions_id');
    }

    public function SentFamily(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Guardian::class, 'guardian_id');
    }

    public function SentGroup(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Groups::class, 'groups_id');
    }

    public function Responses(): HasMany
    {
        return $this->hasMany(\App\Models\Interaction::class, 'interventions_id');
    }

    public function Activity(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Activity::class)->withPivot('language');
    }

    public function Worksheet(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Worksheet::class, 'worksheet_intervention', 'intervention_id', 'worksheet_id')
            ->withPivot('ws_store')->withTimestamps();
    }

    public function Poll(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Poll::class, 'poll_interventions', 'intervention_id', 'poll_id')
            ->withPivot('scan')->withTimestamps();
    }

    public function sentSum()
    {
        return $this->Messages()->sum('sent');
    }

    public function messageCount()
    {
        return $this->Messages()->count();
    }

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Activity::class, 'activity_intervention', 'intervention_id', 'activity_id');
    }
}
