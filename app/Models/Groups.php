<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Groups extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'vnumber', 'region', 'active', 'language', 'user_id', 'sync_date', 'type', 'whatsapp_id',
        'organization_id', 'admin_right', 'send_right', 'verified', 'schools_id', 'class', 'section', 'participants', 'invite_link', 'tr_status', 'onboarded', 'onboarded_date', 'hall_of_fame_2', 'hall_of_fame_5',
        'sunset_tag', 'tr_date', 'special_notes', 'onboarding_end_date',
    ];

    protected $casts = [
        'active' => 'boolean',
        'admin_right' => 'boolean',
        'onboarded' => 'boolean',
        'send_right' => 'boolean',
        'verified' => 'boolean',
        'sync_date' => 'datetime',
        'onboarded_date' => 'datetime',
    ];

    public function SentInterventions(): HasMany
    {
        return $this->hasMany(\App\Models\Intervention::class, 'groups_id');
    }

    public function SentMessages(): HasManyThrough
    {

        return $this->hasManyThrough(
            \App\Models\InterventionMessage::class,
            \App\Models\Intervention::class,
            'groups_id', // Foreign key on users table...
            'interventions_id'
        );
    }

    public function administrator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function Organization(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Organization::class);
    }

    public function School(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Schools::class, 'schools_id');
    }

    public function GroupsModerators(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Moderator::class, 'group_moderator')
            ->withTimestamps()->withPivot('main', 'added');
    }

    public function GroupsNumbers(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\VNumbers::class, 'group_vnumber', 'groups_id', 'vnumber')
            ->withTimestamps()->withPivot('role', 'admin', 'added');
    }

    public function GroupsFamilies(): HasMany
    {
        return $this->hasMany(\App\Models\Guardian::class);
    }

    public function GroupsFamiliesKids(): HasManyThrough
    {
        return $this->hasManyThrough(\App\Models\Kid::class, \App\Models\Guardian::class);
    }

    public function GroupIntervention(): HasMany
    {
        return $this->hasMany(\App\Models\Intervention::class);
    }

    public function GroupsSurvey(): HasOne
    {
        return $this->hasOne(\App\Models\Survey::class);
    }

    public function GroupsSent(): HasMany
    {
        return $this->hasMany(\App\Models\Intervention::class, 'groups_id');
    }

    public function GroupsInteractions(): HasMany
    {
        return $this->hasMany(\App\Models\Interaction::class, 'groups_id');
    }

    public function msgCount(): HasOne
    {
        return $this->hasOne(\App\Models\Intervention::class, 'groups_id')
            ->selectRaw('groups_id, count(*) as aggregate')
            ->groupBy('groups_id');
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

    public function engCount(): HasOne
    {
        return $this->hasOne(\App\Models\Interaction::class, 'groups_id')
            ->selectRaw('groups_id, count(*) as aggregate')
            ->groupBy('groups_id');
    }

    public function getengCountAttribute()
    {
        // if relation is not loaded already, let's do it first
        if (! array_key_exists('engCount', $this->relations)) {
            $this->load('engCount');
        }

        $related = $this->getRelation('engCount');

        // then return the count directly
        return ($related) ? (int) $related->aggregate : 0;
    }

    public function getRawMessageCount()
    {
        return $this->SentMessages()->count();
    }

    public function getSentCount()
    {
        return $this->SentMessages()->sum('sent');
    }

    public function getDeliverCount()
    {
        return $this->SentMessages()->sum('delivered');
    }
}
