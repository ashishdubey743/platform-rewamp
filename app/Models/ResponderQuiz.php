<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResponderQuiz extends Model
{
    protected $table = 'responder_quizzes';

    use SoftDeletes;

    protected $fillable = [
        'quiz_id', 'phone', 'guardian', 'score', 'completed', 'created_at', 'updated_at',
        'chatbot_responder', 'kid_id', 'no_of_attempts', 'last_sent_msg_id', 'msg_status',
        'language', 'activity_requested', 'no_of_reminders', 'last_reminder_sent', 'offline',
    ];

    public function ResponderQuizQuestions()
    {
        return $this->hasMany(\App\Models\ResponderQuizQuestions::class, 'responder_quizzes_id');
    }
}
