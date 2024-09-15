<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guardian extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'mother_name', 'phone', 'father_name', 'active', 'added', 'language', 'user_id', 'date_left', 'groups_id', 'previous_group_ids', 'region', 'type', 'address', 'best_time', 'details',
    ];

    protected $casts = [
        'active' => 'boolean',
        'added' => 'boolean',
        'date_left' => 'datetime',
    ];

    public function administrator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function GroupParticipant(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Groups::class, 'groups_id');
    }

    public function Children(): HasMany
    {
        return $this->hasMany(\App\Models\Kid::class);
    }

    public function Responses(): HasMany
    {
        return $this->hasMany(\App\Models\Interaction::class, 'guardian_phone', 'phone');
    }

    public function SurveyAttempt(): HasMany
    {
        return $this->hasMany(\App\Models\SurveyRecord::class, 'guardian_phone');
    }
}
