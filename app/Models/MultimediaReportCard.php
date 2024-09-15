<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MultimediaReportCard extends Model
{
    protected $fillable = [
        'file_name', 'path', 'group_name', 'date_range', 'response_rate', 'note', 'recipient_type', 'groups_id', 'mime_type',
    ];

    public function GetURL($path, $multimedia_location)
    {
        return Storage::disk('s3')->temporaryUrl($path.'/'.$multimedia_location, now()->addDay());
    }
}
