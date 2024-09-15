<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class NudgeQALanguage extends Model
{
    use SoftDeletes;

    protected $table = 'nudge_qa_language';

    protected $fillable = [
        'question_text', 'question_media', 'question_voice', 'nudge_text', 'nudge_media', 'nudge_voice',
        'answer_text', 'answer_media', 'answer_voice', 'answer_delay', 'language', 'type', 'text_message',
        'content_packet_day_activities_id', 'content_packet_day_worksheets_id', 'reply_to_question',
    ];

    public function ContentPacketDays(): BelongsToMany
    {
        return $this->belongsToMany('App\ContentPacketDays', 'contentpacket_day_nudges', 'nudge_qa_language_id', 'content_packet_day_id');
    }
}
