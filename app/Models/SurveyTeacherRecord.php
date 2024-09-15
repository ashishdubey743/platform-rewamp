<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyTeacherRecord extends Model
{
    use SoftDeletes;

    protected $table = 'survey_teacher_records';

    protected $fillable = [
        'surveys_id', 'teacher_phone', 'visit', 'submit', 'success',
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

    public function Teacher(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Moderator::class, 'teacher_phone');
    }
}
