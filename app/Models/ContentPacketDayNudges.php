<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ContentPacketDayNudges extends Pivot
{
    protected $table = 'contentpacket_day_nudges';

    public $incrementing = true;
}
