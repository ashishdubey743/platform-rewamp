<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poll extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'poll_name', 'org_type', 'poll_tag', 'poll_question', 'number_of_options', 'response_type',
    ];

    public function Options(): HasMany
    {
        return $this->hasMany(\App\Models\PollOption::class);
    }

    public function InterventionTracker(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\InterventionTracker::class, 'poll_interventiontracker', 'poll_id', 'intervention_trackers_id')
            ->withTimestamps();
    }

    public function Intervention(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Intervention::class, 'poll_interventions', 'poll_id', 'intervention_id')
            ->withPivot('scan')->withTimestamps();
    }

    public function Responses(): BelongsToMany
    {
        return $this->belongsToMany(PollResponse::class, 'poll_interventions', 'poll_id', 'poll_interventions.id', 'id', 'polls_intervention_id')->where('active', 1)->withTimestamps();
    }
}
