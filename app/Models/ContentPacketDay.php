<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentPacketDay extends Model
{
    use SoftDeletes;

    protected $table = 'content_packet_day';

    protected $fillable = [
        'day', 'content_packet_id',
    ];

    public function packetDayActivities(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Activity::class, \App\Models\ContentPacketDayActivities::class, 'content_packet_day_id', 'activity_id', 'id')->withTimestamps()->withPivot('id', 'type');
    }

    public function packetDayWorksheets(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Worksheet::class, \App\Models\ContentPacketDayWorksheets::class, 'content_packet_day_id', 'worksheet_id', 'id')->withTimestamps()->withPivot('id', 'type');
    }

    public function packetDayNudges(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\NudgeQALanguage::class, \App\Models\ContentPacketDayNudges::class, 'content_packet_day_id', 'nudge_qa_language_id', 'id')->withTimestamps()->withPivot('id');
    }
}
