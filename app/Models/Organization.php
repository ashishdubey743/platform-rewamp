<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'active', 'start_date', 'end_date', 'institution_type',
        'moderator_type', 'program', 'language', 'schedule_name', 'organization_type', 'urbanization',
        'group_name_prefix', 'broad_tag',
    ];

    protected $casts = [
        'active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function NumbersAssociated(): BelongsToMany
    {
        return $this->belongsToMany(VNumbers::class, 'organization_vnumber', 'organizations_id', 'vnumber')
            ->withTimestamps()->withPivot('role');
    }

    public function DistrictsServed(): BelongsToMany
    {
        return $this->belongsToMany(Districts::class, 'district_organization', 'organizations_id', 'districts_id')
            ->withTimestamps();
    }

    public function modCount(): BelongsToMany
    {
        //        return $this->hasOne('App\Models\Moderator')
        //            ->selectRaw('organization_id, count(*) as aggregate')
        //            ->groupBy('organization_id');
        return $this->belongsToMany(Moderator::class, 'organization_moderator', 'organizations_id', 'moderator_id')
            ->selectRaw('organizations_id, count(*) as aggregate')
            ->groupBy('organizations_id');
    }

    public function orgOnboardingNudges(): HasMany
    {
        return $this->hasMany(OrgOnboardingNudges::class, 'organizations_id', 'id');

    }

    public function orgAutomationSettings(): HasMany
    {
        return $this->hasMany(OrgAutomationSetting::class, 'organizations_id', 'id');
    }

    public function getmodCountAttribute()
    {
        // if relation is not loaded already, let's do it first
        if (! array_key_exists('modCount', $this->relations)) {
            $this->load('modCount');
        }

        $related = $this->getRelation('modCount')->first();

        // then return the count directly
        return ($related) ? (int) $related->aggregate : 0;
    }

    public function grpCount(): HasOne
    {
        return $this->hasOne(Groups::class)
            ->selectRaw('organization_id, count(*) as aggregate')
            ->groupBy('organization_id');
    }

    public function getgrpCountAttribute()
    {
        // if relation is not loaded already, let's do it first
        if (! array_key_exists('grpCount', $this->relations)) {
            $this->load('grpCount');
        }

        $related = $this->getRelation('grpCount');

        // then return the count directly
        return ($related) ? (int) $related->aggregate : 0;
    }

    public function trgrpCount(): HasOne
    {
        return $this->hasOne(Groups::class)
            ->selectRaw('organization_id, count(*) as aggregate')
            ->groupBy('organization_id')->where('send_right', '=', 1);
    }

    public function gettrgrpCountAttribute()
    {
        // if relation is not loaded already, let's do it first
        if (! array_key_exists('trgrpCount', $this->relations)) {
            $this->load('trgrpCount');
        }

        $related = $this->getRelation('trgrpCount');

        // then return the count directly
        return ($related) ? (int) $related->aggregate : 0;
    }

    public function GroupsOwned(): HasMany
    {
        return $this->hasMany(Groups::class, 'organization_id');
    }

    public function dashboards(): HasMany
    {
        return $this->hasMany(Dashboard::class, 'organizations_id', 'id');
    }

    public function SchoolsAdministered(): HasMany
    {
        return $this->hasMany(Schools::class, 'organization_id');
    }

    public function schlCount(): HasOne
    {
        return $this->hasOne(Schools::class)
            ->selectRaw('organization_id, count(*) as aggregate')
            ->groupBy('organization_id');
    }

    public function getschlCountAttribute()
    {
        // if relation is not loaded already, let's do it first
        if (! array_key_exists('schlCount', $this->relations)) {
            $this->load('schlCount');
        }

        $related = $this->getRelation('schlCount');

        // then return the count directly
        return ($related) ? (int) $related->aggregate : 0;
    }

    public function MsgReceived(): HasMany
    {
        return $this->hasMany(Interaction::class, 'organization_id');
    }

    public function tech_ready_groups()
    {
        return $this->GroupsOwned()->where('send_right', '=', 1);
    }

    public function QuizAssociated(): BelongsToMany
    {
        return $this->belongsToMany(quiz::class, 'organization_quiz', 'organizations_id', 'quizzes_id')
            ->withTimestamps()->withPivot('quizzes_id');
    }

    public function ModsHandled(): BelongsToMany
    {
        return $this->belongsToMany(Moderator::class, 'organization_moderator', 'organizations_id', 'moderator_id')
            ->withTimestamps();
    }
}
