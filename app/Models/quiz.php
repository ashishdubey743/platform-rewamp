<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quiz_name', 'description', 'difficulty_level', 'chatbot_num', 'creator', 'grade',
        'activated_at', 'deactivated_at', 'logo_location', 'poster_location', 'type'
    ];

    protected $casts = [
        'deactivated_at' => 'datetime',
        'activated_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'creator');
    }

    public function OrganizationAssociated(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Organization::class, 'organization_quiz', 'quizzes_id', 'organizations_id')
            ->withTimestamps()->withPivot('quizzes_id');
    }

    public function ContentStreamPacketAssociated(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\ContentStreamPacket::class, 'quiz_content_stream_packet', 'quizzes_id', 'content_stream_packet_id')
            ->withTimestamps()->withPivot('quizzes_id');
    }

    public function ContentPacketsAssociated(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\ContentPacket::class, 'quiz_content_packet', 'quizzes_id', 'content_packet_id')
            ->withTimestamps();
    }

    public function QuestionsAssociated(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Question::class, 'quiz_questions', 'quizzes_id', 'questions_id')
            ->withTimestamps()->withPivot('quizzes_id', 'questions_id');
    }

    public function Responses(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\ResponderQuiz::class, 'responder_quizzes', 'quizzes_id', 'chatbot_responder')
            ->withTimestamps()->withPivot('score', 'completed', 'kids_id');
    }

    public function qResponses(): HasMany
    {
        return $this->hasMany(\App\Models\ResponderQuiz::class, 'quizzes_id');
    }

    public function QuizCompletionMultimedia()
    {
        return $this->hasMany(QuizCompletionMultimedia::class);
    }
}
