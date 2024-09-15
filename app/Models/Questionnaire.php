<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Questionnaire extends Model
{
    use SoftDeletes;

    /**
     * @var mixed
     */
    protected $fillable = [
        'name', 'type', 'user_id', 'is_correctible',
    ];

    public function TrainingsAssociated(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Training::class, 'questionnaire_training', 'questionnaires_id', 'trainings_id')
            ->withTimestamps()->withPivot('order', 'editable', 'show_score');
    }

    public function Answers(): HasMany
    {
        return $this->hasMany(\App\Models\QuestionnaireAnswer::class);
    }

    public function Records(): HasMany
    {
        return $this->hasMany(\App\Models\QuestionnaireRecords::class);
    }

    public function EnquiriesStructure(): HasMany
    {
        return $this->hasMany(\App\Models\QuestionnaireEnquiry::class, 'questionnaires_id');
    }
}
