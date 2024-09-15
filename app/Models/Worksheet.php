<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Worksheet extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'description', 'grade', 'raw_ws_media', 'solved_ws_media', 'activity_id',
        'difficulty_level', 'training_status', 'qr_code', 'instruction_message', 'instruction_media',
        'vernacular_title', 'language', 'worksheet_domain', 'institution_type', 'sending_on'
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Activity::class);
    }

    public function worksheetAoi(): HasMany
    {
        return $this->hasMany(\App\Models\WorksheetAOI::class, 'worksheet_id', 'id');
    }

    public function worksheetTrainings(): HasMany
    {
        return $this->hasMany(\App\Models\WorksheetTraining::class, 'worksheet_id', 'id');
    }

    public function worksheetTrainingMediaAoi(): HasMany
    {
        return $this->hasMany(\App\Models\WorksheetTrainingMediaAOI::class, 'worksheet_id', 'id');
    }

    public function mediaInterventionTracker(): HasMany
    {
        return $this->hasMany(\App\Models\MediaInterventionTracker::class, 'worksheet_id', 'id');
    }

    public function Intervention(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Intervention::class, 'worksheet_intervention', 'worksheet_id', 'intervention_id')
            ->withPivot('ws_store')->withTimestamps();
    }

    public function LearningDomainNew(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\LearningDomainNew::class, 'worksheets_learning_domain',
            'worksheets_id', 'learning_domain_id');
    }

    public function ContentPacketDays(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\ContentPacketDay::class, 'content_packet_day_worksheets', 'worksheet_id', 'content_packet_day_id')->withTimestamps()->withPivot('type');
    }

    public function InterventionTracker(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\InterventionTracker::class, 'worksheet_interventiontracker', 'worksheet_id', 'intervention_trackers_id')
            ->withPivot('ws_store', 'caption')->withTimestamps();
    }

    public function getURL($image = null)
    {
        $types = ['raw', 'solved', 'instructions'];
        $blobURL = [];
        foreach ($types as $type) {
            $imageName = '';
            $imagePath = '';
            if ($image !== null) {
                $imageName = $image;
            } else {
                if ($type === 'raw') {
                    $imageName = $this->raw_ws_media;
                } elseif ($type === 'solved') {
                    $imageName = $this->solved_ws_media;
                } else {
                    $imageName = $this->instruction_media;
                }
            }
            if ($type !== 'instructions') {
                if (! empty($imageName)) {
                    $imagePath = '/worksheets/'.$type.'/'.$imageName;
                }
            } else {
                if (! empty($imageName)) {
                    $imageMimeType = $this->getMimeType($imageName);
                    $imageMediaType = getMultimediaType($imageMimeType);
                    $imagePath = '/worksheets/'.$type.'/'.$imageMediaType.'/'.$imageName;
                }
            }

            if (! empty($imagePath)) {
                $blobURL[] = Storage::disk('s3')->url(env('AWS_BUCKET').$imagePath);
            } else {
                $blobURL[] = null;
            }
        }

        return $blobURL;
    }

    public function getMimeType($filename)
    {

        $mime_types = [
            //text
            'txt' => 'text/plain',

            // images
            'png' => 'image/png',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',

            // audio/video
            'mp4' => 'video/mp4',
            'm4a' => 'video/m4a',
            'm4v' => 'video/m4v',
            'mov' => 'video/quicktime',
            'aac' => 'audio/x-hx-aac-adts',
            'ogg' => 'audio/ogg',
            'mpeg' => 'audio/mpeg',
            'mp3' => 'audio/mp3',
            'wav' => 'audio/x-wav',

        ];

        $ext = explode('.', $filename);
        $ext = strtolower(end($ext));

        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }

        return 'application/octet-stream';
    }
}
