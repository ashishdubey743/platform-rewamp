<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterventionMessage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sent', 'delivered', 'interventions_id', 'whatsapp_mid', 'intervention_multimedia_id', 'sent_time',
        'delivery_time', 'delivery_message', 'retry_count', 'vnumber', 'w_a_jobs_id', 'intervention_trackers_id', 'cancelled',
        'content_stream_packet_id', 'reply_to',
    ];

    protected $casts = [
        'sent' => 'boolean',
        'delivered' => 'boolean',
        'cancelled' => 'boolean',
        'sent_time' => 'datetime',
        'delivered_time' => 'datetime',
    ];

    public function LinkedIntervention(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Intervention::class, 'interventions_id');
    }

    public function LinkedJob(): BelongsTo
    {
        return $this->belongsTo(\App\Models\WAJob::class, 'w_a_jobs_id');
    }

    public function LinkedMultimedia(): BelongsTo
    {
        return $this->belongsTo(\App\Models\InterventionMultimedia::class, 'intervention_multimedia_id');
    }

    public function FromPhone(): BelongsTo
    {
        return $this->belongsTo(\App\Models\VNumbers::class, 'vnumber');
    }
}
