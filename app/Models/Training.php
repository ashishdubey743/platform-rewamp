<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'level', 'attendance', 'logo', 'start_date', 'end_date', 'user_id',
    ];

    public function questionnaireAssociated(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Questionnaire::class, 'questionnaire_training', 'trainings_id', 'questionnaires_id')
            ->withTimestamps()->withPivot('order', 'editable', 'has_prerequisite', 'pre_req_correct_answer', 'show_score');
    }
}
