<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ContentStreamPacket extends Pivot
{
    protected $table = 'content_stream_packet';

    public $incrementing = true;
}
