<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentPacket extends Model
{
    use SoftDeletes;

    protected $table = 'content_packets';

    protected $fillable = [
        'title', 'description', 'type',
    ];

    public function Questions(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Question::class, 'contentpacket_questions', 'content_packet_id', 'questions_id')
            ->withTimestamps()->withPivot('content_packet_id', 'questions_id');

    }

    public function packetDays(): HasMany
    {
        return $this->hasMany(\App\Models\ContentPacketDay::class, 'content_packet_id', 'id');

    }

    public function ContentStreams(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\ContentStream::class, 'content_stream_packet', 'content_packet_id', 'content_stream_id')->withTimestamps();
    }

    public function QuizAssociated(): BelongsToMany
    {
        return $this->belongsToMany('App\Quiz', 'quiz_content_packet', 'content_packet_id', 'quizzes_id')
            ->withTimestamps();
    }
}
