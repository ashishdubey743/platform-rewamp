<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyRecord extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'surveys_id', 'cert_url', 'visit', 'submit', 'success', 'guardian_phone',
    ];

    protected $casts = [
        'visit' => 'boolean',
        'submit' => 'boolean',
        'success' => 'boolean',
    ];

    public function Records(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Survey::class, 'surveys_id');
    }

    public function Parent(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Guardian::class, 'guardian_phone');
    }
}
