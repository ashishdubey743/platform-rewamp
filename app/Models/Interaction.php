<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'downloaded', 'interventions_id', 'whatsapp_uid', 'guardian_phone', 'groups_id', 'sent_time', 'organization_id',
        'multimedia_type', 'multimedia_location', 'message_type', 'moderator_phone', 'from_parent', 'text', 'duration',
    ];

    protected $casts = [
        'downloaded' => 'boolean',
        'from_parent' => 'boolean',
        'sent_time' => 'datetime',
    ];

    public function LinkedIntervention(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Intervention::class, 'interventions_id');
    }

    public function ReceivedFamily(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Guardian::class, 'guardian_phone');
    }

    public function ReceivedGroup(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Groups::class, 'groups_id');
    }

    public function ReceivedOrg(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Organization::class, 'organization_id');
    }

    public function ReceivedModerator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Moderator::class, 'moderator_phone');
    }
}
