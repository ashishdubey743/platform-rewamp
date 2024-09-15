<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutomatedIntervention extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'groups_id', 'guardian_phone', 'caption', 'location', 'intervention_type', 'group_message',
        'sent', 'delivered', 'sent_time', 'delivery_time', 'schedule_time', 'retry_count', 'message_id',
        'cancelled_at', 'vnumber', 'delivery_message', 'automation_tracker_id',
    ];

    public function SentGroup(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Groups::class, 'groups_id');
    }
}
