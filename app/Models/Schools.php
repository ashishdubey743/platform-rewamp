<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schools extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date_left', 'name', 'user_id', 'organization_id', 'active', 'e_Identifiers', 'type', 'block', 'district', 'enrollment',
    ];

    public function ModeratorsAffiliated(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Moderator::class, 'moderator_school', 'schools_id', 'moderator_id')
            ->withTimestamps();
    }

    public function Organization(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Organization::class);
    }

    public function administrator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function GroupsFormed(): HasMany
    {
        return $this->hasMany(\App\Models\Groups::class);
    }
}
