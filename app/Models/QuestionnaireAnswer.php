<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionnaireAnswer extends Model
{
    protected $fillable = [
        'response', 'questionnaire_enquiries_id', 'questionnaires_id', 'questionnaire_records_id',
    ];

    public function Questionnaire(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Questionnaire::class, 'questionnaires_id');
    }

    public function Enquiry(): BelongsTo
    {
        return $this->belongsTo(\App\Models\QuestionnaireEnquiry::class, 'questionnaire_enquiries_id');
    }

    public function Records(): BelongsTo
    {
        return $this->belongsTo(\App\Models\QuestionnaireRecords::class, 'questionnaire_records_id');
    }
}
