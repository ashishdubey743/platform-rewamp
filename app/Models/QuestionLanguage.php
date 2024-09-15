<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionLanguage extends Model
{
    protected $table = 'question_language';

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'questions_id', 'language', 'question_text', 'question_voicenote', 'question_options', 'answer', 'question_media'
    ];

    protected $appends = ['answer_chosen_array'];

    public function getAnswerChosenArrayAttribute()
    {
        return explode(';', $this->attributes['answer']);
    }
}
