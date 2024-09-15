<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PollResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'polls_intervention_id',
        'moderator_phone',
        'guardian_phone',
        'response_option',
        'response_text',
        'whatsapp_uid',
        'org_id',
        'active',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Groups::class, 'group_id', 'id');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'org_id', 'id');
    }
}
