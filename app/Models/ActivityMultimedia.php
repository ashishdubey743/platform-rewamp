<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ActivityMultimedia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'internal', 'activity_id', 'multimedia_location', 'external_source', 'type', 'language',
        'subscript_location', 'mime_type', 'title', 'audio_type', 'activity_format', 'gender_children',
        'gender_facilitator', 'gender_rl', 'religion_children', 'notes', 'duration',
    ];

    public function youtube(): HasOne
    {
        return $this->hasOne(\App\Models\youtube::class, 'activity_multimedia_id');
    }

    public function GetURL($fileType = null, $fileName = null)
    {
        if ($fileName === null || $fileType === null) {
            $fileName = $this->multimedia_location;
            $fileType = $this->type;
        }

        $filePath = 'activitymultimedia/'.$fileType.'/'.urlencode($fileName);

        return Storage::disk('s3')->url(env('AWS_BUCKET').'/'.$filePath);
    }

    public function getBasicURL()
    {
        return $this->GetURL($this->type, $this->multimedia_location);
    }
}
