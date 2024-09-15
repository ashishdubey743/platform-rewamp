<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherAgencyChatbotResponses extends Model
{
    use SoftDeletes;

    protected $table = 'teacher_agency_chatbot_responses';

    protected $fillable = [
        'teacher_agency_chatbot_id', 'response_type', 'response', 'content_stream_id',
    ];

    public function Responder(): BelongsTo
    {
        return $this->belongsTo(\App\Models\TeacherAgencyChatbot::class, 'teacher_agency_chatbot_id');
    }
}
