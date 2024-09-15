<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionnaireEnquiry extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'mandatory', 'page_break', 'skip_logic', 'count_score', 'type', 'order', 'validate_type', 'questionnaires_id', 'correct_answer',
    ];

    protected $casts = [
        'mandatory' => 'boolean',
        'page_break' => 'boolean',
    ];

    public function Questionnaire(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Questionnaire::class, 'questionnaires_id');
    }
}
