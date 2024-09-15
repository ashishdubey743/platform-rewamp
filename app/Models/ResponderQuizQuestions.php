<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResponderQuizQuestions extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'quiz_id', 'question_id', 'guardian', 'phone', 'responded', 'correct', 'option_chosen', 'kid_id', 'created_at', 'updated_at',
        'responder_quizzes_id'
    ];

    protected $appends = ['option_chosen_array'];

    public function getOptionChosenArrayAttribute()
    {
        return explode(';', $this->attributes['option_chosen']);
    }
}
