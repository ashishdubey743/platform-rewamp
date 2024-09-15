<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class VNumbers extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'vnumber', 'active', 'blocked', 'deactive_date', 'block_date', 'initialize', 'type',
        'API_Token', 'API_InstanceID', 'API_Url',
    ];

    protected $casts = [
        'active' => 'boolean',
        'initialized' => 'boolean',
        'block_date' => 'datetime',
        'deactive_date' => 'datetime',
    ];

    protected $table = 'v_numbers';

    protected $primaryKey = 'vnumber';

    public $incrementing = false;

    protected $keyType = 'string';

    public function GroupsHandled(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Groups::class, 'group_vnumber', 'vnumber', 'groups_id')
            ->withTimestamps()->withPivot('role', 'admin', 'added');
    }

    public function OrgsHandled(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Organization::class, 'organization_vnumber', 'vnumber', 'organizations_id')
            ->withTimestamps()->withPivot('role');
    }

    public function Sessions(): HasMany
    {
        return $this->hasMany(\App\Models\WhatsappChatApi::class);
    }

    public function LinkedJobs(): HasMany
    {
        return $this->hasMany(\App\Models\WAJob::class, 'vnumber');
    }

    public function MessageAttempts(): HasMany
    {
        return $this->hasMany(\App\Models\InterventionMessage::class, 'vnumber');
    }

    public function latestStatus(): HasOne
    {
        return $this->hasOne(\App\Models\WhatsappChatApi::class, 'vnumber')->latest();
    }

    public function getStatuses(): HasOne
    {
        return $this->hasOne(\App\Models\WhatsappChatApi::class, 'vnumber')->latest()->groupBy('accountStatus')->limit(5);
    }

    public function VnumberBillings(): HasOne
    {
        return $this->hasOne(\App\Models\VNumberBilling::class, 'vnumber', 'vnumber');
    }

    public function WAJobsLatest(): HasMany
    {
        return $this->hasMany(WAJob::class, 'vnumber', 'vnumber')->limit(15)->latest();
    }
}
