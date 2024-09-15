<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionnaireRecords extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'visit', 'start', 'submit', 'cookie_id', 'language', 'filled_phone', 'last_visit', 'questionnaires_id', 'trainings_id', 'prerequisite_passed',
    ];

    protected $casts = [
        'visit' => 'boolean',
        'start' => 'boolean',
        'submit' => 'boolean',
        'last_visit' => 'datetime',
    ];

    public function Questionnaire(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Questionnaire::class, 'questionnaires_id');
    }

    public function Training(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Training::class, 'trainings_id');
    }

    public function Answers(): HasMany
    {
        return $this->hasMany(\App\Models\QuestionnaireAnswer::class, 'questionnaire_records_id');
    }
}
