<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentStreamTracker extends Model
{
    use SoftDeletes;

    protected $table = 'content_stream_tracker';

    protected $fillable = [
        'quiz_scheduled_time', 'content_stream_id', 'teacher_training_schedule_time',
        'send_teacher_content_to_moderator_groups', 'start_date', 'end_date', 'quiz_poster',
    ];

    public function TrackerActivities(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\ContentPacketDayActivities::class, 'content_stream_tracker_activities', 'content_stream_tracker_id', 'content_packet_day_activity_id')->withTimestamps()->withPivot('scheduled_time');
    }

    public function TrackerWorksheets(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\ContentPacketDayWorksheets::class, 'content_stream_tracker_worksheets', 'content_stream_tracker_id', 'content_packet_day_worksheet_id')->withTimestamps()->withPivot('scheduled_time');
    }

    public function TrackerNudges(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\ContentPacketDayNudges::class, 'content_stream_tracker_nudges', 'content_stream_tracker_id', 'contentpacket_day_nudge_id')->withTimestamps()->withPivot('schedule_time');
    }

    public function ContentStreams(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\ContentStream::class, 'contenttracker_streams', 'content_stream_tracker_id', 'content_stream_id')->withTimestamps();
    }

    public function InterventionTrackers(): HasMany
    {
        return $this->hasMany(\App\Models\InterventionTracker::class, 'content_stream_tracker_id')->orderBy('scheduled_time');
    }
}
