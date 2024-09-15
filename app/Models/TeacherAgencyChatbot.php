<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherAgencyChatbot extends Model
{
    use SoftDeletes;

    protected $table = 'teacher_agency_chatbot';

    protected $fillable = [
        'phone', 'content_stream_tracker_id', 'groups_id',
    ];

    public function Responses(): HasMany
    {
        return $this->hasMany(\App\Models\TeacherAgencyChatbotResponses::class, 'teacher_agency_chatbot_id');
    }
}
