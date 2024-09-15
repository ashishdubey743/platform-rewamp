<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterventionChecklistDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'intervention_checklist_links_id',
        'organization_id',
        'GA_vnumber',
        'vnumber',
        'intervention_message_id',
        'content_status',
        'reschedule_type',
        'text',
        'text_type',
        'activities',
        'multimedia',
        'multimedia_type',
        'verify',
        'reschdule',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Organization::class, 'organization_id');
    }
}
