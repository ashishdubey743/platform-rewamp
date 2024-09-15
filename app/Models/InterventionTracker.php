<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterventionTracker extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'message_text',
        'user_id', 'target_group',
        'intervention_type', 'internal_notes', 'status', 'scheduled_time', 'source_activity', 'multimedia',
        'description', 'multimedia_caption', 'cancelled', 'eta', 'reply_to',
    ];

    protected $casts = [
        'cancelled' => 'boolean',
        'target_group' => 'boolean',
        'source_activity' => 'boolean',
        'scheduled_time' => 'datetime',
    ];

    public function administrator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function Messages(): HasMany
    {
        return $this->hasMany(\App\Models\InterventionMessage::class, 'intervention_trackers_id');
    }

    public function Jobs(): HasMany
    {
        return $this->hasMany(\App\Models\WAJob::class, 'intervention_trackers_id');
    }

    public function Media(): HasMany
    {
        return $this->hasMany(\App\Models\MediaInterventionTracker::class, 'intervention_trackers_id');
    }

    public function ContentStreamTracker(): BelongsTo
    {
        return $this->belongsTo(\App\Models\ContentStreamTracker::class, 'content_stream_tracker_id');
    }

    public function Activity(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Activity::class, 'activity_interventiontracker', 'intervention_trackers_id', 'activity_id')
            ->withPivot('language', 'caption')->withTimestamps();
    }

    public function Organizations(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Organization::class, 'interventiontracker_organization', 'intervention_trackers_id', 'organizations_id')->withTimestamps();

    }

    public function Worksheet(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Worksheet::class, 'worksheet_interventiontracker', 'intervention_trackers_id', 'worksheet_id')
            ->withPivot('ws_store', 'caption')->withTimestamps();
    }

    public function Poll(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Poll::class, 'poll_interventiontracker', 'intervention_trackers_id', 'poll_id')
            ->withTimestamps();
    }

    public function mediaInterventionTracker(): HasMany
    {
        return $this->hasMany(\App\Models\MediaInterventionTracker::class, 'intervention_trackers_id', 'id');
    }

    public function msgCount(): HasOne
    {
        return $this->hasOne(\App\Models\InterventionMessage::class, 'intervention_trackers_id')
            ->selectRaw('intervention_trackers_id, count(*) as aggregate')
            ->groupBy('intervention_trackers_id');
    }

    public function getmsgCountAttribute()
    {
        // if relation is not loaded already, let's do it first
        if (! array_key_exists('msgCount', $this->relations)) {
            $this->load('msgCount');
        }

        $related = $this->getRelation('msgCount');

        // then return the count directly
        return ($related) ? (int) $related->aggregate : 0;
    }

    public function sumCount(): HasOne
    {
        return $this->hasOne(\App\Models\InterventionMessage::class, 'intervention_trackers_id')
            ->selectRaw('intervention_trackers_id, sum(sent) as aggregate')
            ->groupBy('intervention_trackers_id');
    }

    public function getsumCountAttribute()
    {
        // if relation is not loaded already, let's do it first
        if (! array_key_exists('sumCount', $this->relations)) {
            $this->load('sumCount');
        }

        $related = $this->getRelation('sumCount');

        // then return the count directly
        return ($related) ? (int) $related->aggregate : 0;
    }

    public function deliverCount(): HasOne
    {
        return $this->hasOne(\App\Models\InterventionMessage::class, 'intervention_trackers_id')
            ->selectRaw('intervention_trackers_id, sum(delivered) as aggregate')
            ->groupBy('intervention_trackers_id');
    }

    public function getdeliverCountAttribute()
    {
        // if relation is not loaded already, let's do it first
        if (! array_key_exists('deliverCount', $this->relations)) {
            $this->load('deliverCount');
        }

        $related = $this->getRelation('deliverCount');

        // then return the count directly
        return ($related) ? (int) $related->aggregate : 0;
    }

    public function jobCount(): HasOne
    {
        return $this->hasOne(\App\Models\WAJob::class, 'intervention_trackers_id')
            ->selectRaw('intervention_trackers_id, count(*) as aggregate')
            ->groupBy('intervention_trackers_id');
    }

    public function getjobCountAttribute()
    {
        // if relation is not loaded already, let's do it first
        if (! array_key_exists('jobCount', $this->relations)) {
            $this->load('jobCount');
        }

        $related = $this->getRelation('jobCount');

        // then return the count directly
        return ($related) ? (int) $related->aggregate : 0;
    }

    public function jobSuccCount(): HasOne
    {
        return $this->hasOne(\App\Models\WAJob::class, 'intervention_trackers_id')
            ->selectRaw('intervention_trackers_id, count(distinct case when w_a_jobs.status="success" then w_a_jobs.id else Null end) as aggregate')
            ->groupBy('intervention_trackers_id');
    }

    public function getjobSuccCountAttribute()
    {
        // if relation is not loaded already, let's do it first
        if (! array_key_exists('jobSuccCount', $this->relations)) {
            $this->load('jobSuccCount');
        }

        $related = $this->getRelation('jobSuccCount');

        // then return the count directly
        return ($related) ? (int) $related->aggregate : 0;
    }

    public function jobFailCount(): HasOne
    {
        return $this->hasOne(\App\Models\WAJob::class, 'intervention_trackers_id')
            ->selectRaw('intervention_trackers_id, count(distinct case when w_a_jobs.status="failed" then w_a_jobs.id else Null end) as aggregate')
            ->groupBy('intervention_trackers_id');
    }

    public function getjobFailCountAttribute()
    {
        // if relation is not loaded already, let's do it first
        if (! array_key_exists('jobFailCount', $this->relations)) {
            $this->load('jobFailCount');
        }

        $related = $this->getRelation('jobFailCount');

        // then return the count directly
        return ($related) ? (int) $related->aggregate : 0;
    }
}
