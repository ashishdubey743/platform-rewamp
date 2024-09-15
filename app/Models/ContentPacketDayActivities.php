<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentPacketDayActivities extends Pivot
{
    use SoftDeletes;

    protected $table = 'content_packet_day_activities';

    public $incrementing = true;

    public function packetDayActivitiesPolls(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Poll::class, 'content_packet_activities_worksheets_polls', 'content_packet_day_activity_id', 'poll_id', 'id')->withTimestamps()->withPivot('id', 'delay', 'reply', 'language');
    }

    public function packetDayActivityToNudgeQALanguage($nudgesOfTheDay = []): HasMany
    {
        return $this->hasMany(NudgeQALanguage::class, 'content_packet_day_activities_id', 'id')
            ->whereIn('id', $nudgesOfTheDay);
    }
}
