<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'questions';

    protected $fillable = [
        'title', 'difficulty_level', 'learning_domain_id', 'mm_location', 'answers',
        'message_template', 'activities_id', 'question_domain', 'institution_type'
    ];

    public function Activities(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Activity::class, 'activities_id');
    }

    public function Domains(): BelongsTo
    {
        return $this->belongsTo(\App\Models\LearningDomain::class, 'learning_domain_id');
    }

    public function LearningDomainNew(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\LearningDomainNew::class, 'questions_learning_domain',
            'questions_id', 'learning_domain_id');
    }

    public function QuizAssociated(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\quiz::class, 'quiz_questions', 'questions_id', 'quizzes_id')
            ->withTimestamps()->withPivot('quizzes_id', 'questions_id');
    }

    public function Language(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\QuestionLanguage::class, 'question_language', 'questions_id', 'language')
            ->withTimestamps()->withPivot('question_text', 'question_voicenote', 'question_options');
    }

    public function qLanguage(): HasMany
    {
        return $this->hasMany(\App\Models\QuestionLanguage::class, 'questions_id');
    }
}
