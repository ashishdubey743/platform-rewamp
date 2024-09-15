<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $table = 'maintenance';

    protected $fillable = [
        'remark', 'instant', 'action', 'finished', 'on_start_notification', 'on_end_notification', 'start_time', 'end_time',
    ];
}
