<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentPacketActivitiesWorksheetsPolls extends Pivot
{
    use SoftDeletes;

    protected $table = 'content_packet_activities_worksheets_polls';

    public $incrementing = true;

    protected $fillable = [
        'content_packet_day_activity_id', 'content_packet_day_worksheet_id',
        'poll_id', 'delay', 'reply', 'language',
    ];
}
