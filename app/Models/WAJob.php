<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WAJob extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['status', 'action', 'jfname', 'input', 'message', 'vnumber', 'user_id',
        'completed_time', 'start_time', 'ETA', 'url', 'intervention_trackers_id',
    ];

    protected $casts = [
        'completed_time' => 'datetime',
        'start_time' => 'datetime',
        'ETA' => 'datetime',
    ];

    public function Session(): HasMany
    {
        return $this->hasMany(\App\Models\WhatsappChatApi::class, 'w_a_job_id');
    }

    public function LinkedJob()
    {
        return $this->BelongsTo(\App\Models\VNumbers::class);
    }

    public function LinkedSend(): HasMany
    {
        return $this->hasMany(\App\Models\InterventionMessage::class, 'w_a_jobs_id');
    }

    public function JobOwner()
    {
        return $this->BelongsTo(\App\Models\User::class, 'user_id');
    }
}
