<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentPacketDayWorksheets extends Pivot
{
    use SoftDeletes;

    protected $table = 'content_packet_day_worksheets';

    public $incrementing = true;

    public function packetDayWorksheetsPolls(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Poll::class, 'content_packet_activities_worksheets_polls', 'content_packet_day_worksheet_id', 'poll_id', 'id')->withTimestamps()->withPivot('id', 'delay', 'reply', 'language');
    }

    public function packetDayWorksheetToNudgeQALanguage($nudgesOfTheDay = []): HasMany
    {
        return $this->hasMany(NudgeQALanguage::class, 'content_packet_day_worksheets_id', 'id')
            ->whereIn('id', $nudgesOfTheDay);
    }
}
