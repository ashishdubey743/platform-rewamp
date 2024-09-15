<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title', 'activity_description', 'activity_type', 'demo_type', 'difficulty_level', 'impact_timeline', 'group_size',
        'audience', 'required_materials', 'response_type', 'activity_domain', 'institution_type', 'call_to_action', 'activity_time',
        'independent_engagement', 'play_type', 'thematic_alignment',
    ];

    public function Multimedia(): HasMany
    {
        return $this->hasMany(\App\Models\ActivityMultimedia::class);
    }

    public function Questions(): HasMany
    {
        return $this->hasMany(\App\Models\Question::class, 'activities_id', 'id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function LearningDomain(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\LearningDomain::class);
    }

    public function LearningDomainNew(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\LearningDomainNew::class, 'activity_learning_domain_new',
            'activity_id', 'learning_domain_id');
    }

    public function Intervention(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Intervention::class)->latest()->limit(100);
    }

    public function interventions(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Intervention::class, 'activity_intervention', 'activity_id', 'intervention_id');
    }

    public function ContentPacketDays(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\ContentPacketDay::class, 'content_packet_day_activities', 'activity_id', 'content_packet_day_id')->withTimestamps()->withPivot('type');
    }

    public function worksheet(): HasMany
    {
        return $this->hasMany(\App\Models\Worksheet::class);
    }

    public function InterventionTracker(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\InterventionTracker::class, 'activity_interventiontracker', 'activity_id', 'intervention_trackers_id')
            ->withPivot('language', 'caption')->withTimestamps();
    }
}
