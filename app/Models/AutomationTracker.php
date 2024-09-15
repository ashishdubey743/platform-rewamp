<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutomationTracker extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type', 'status', 'schedule_time', 'eta', 'cancelled_at', 'message_text',
    ];

    public function AutomatedInterventions(): HasMany
    {
        return $this->hasMany(\App\Models\AutomatedIntervention::class, 'automation_tracker_id');
    }

    public function Organizations(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Organization::class, 'org_automationtrackers', 'automation_trackers_id', 'organizations_id')->withTimestamps();
    }

    public function msgCount(): HasOne
    {
        return $this->hasOne(\App\Models\AutomatedIntervention::class, 'automation_tracker_id')
            ->selectRaw('automation_tracker_id, count(*) as aggregate')
            ->groupBy('automation_tracker_id');
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

    public function organizationWiseSumCounts()
    {
        $result = $this->hasMany(\App\Models\AutomatedIntervention::class, 'automation_tracker_id')
            ->selectRaw('automation_tracker_id, organization_id, organizations.name, sum(sent) as sent, sum(delivered) as delivered, count(*) as scheduled_groups, COUNT(location) as media_processed')
            ->join('groups', 'groups.id', '=', 'automated_interventions.groups_id')
            ->join('organizations', 'organizations.id', '=', 'groups.organization_id')
            ->groupBy(['automation_tracker_id', 'organization_id']);

        return $result;
    }

    public function getsumCountAttribute()
    {
        // if relation is not loaded already, let's do it first
        if (! array_key_exists('organizationWiseSumCounts', $this->relations)) {
            $this->load('organizationWiseSumCounts');
        }

        $related = $this->getRelation('organizationWiseSumCounts');

        // then return the count directly
        return ($related) ? (int) $related->aggregate : 0;
    }
}
