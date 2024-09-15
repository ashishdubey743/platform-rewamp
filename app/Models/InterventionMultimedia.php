<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class InterventionMultimedia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'location', 'type', 'youtube', 'intervention_id', 'duration', 'mime_type', 'cloud', 'link',
        'activity', 'caption',
    ];

    protected $casts = [
        'youtube' => 'boolean',
        'cloud' => 'boolean',
    ];

    public function LinkedIntervention(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Intervention::class, 'id');
    }

    public function GetURL()
    {
        if ($this->cloud == 1 || $this->cloud == true) {
            if (! $this->activity) {
                $container = 'interventiondata/';
            } else {
                $container = 'activitymultimedia/';
            }

            return Storage::disk('s3')->url(env('AWS_BUCKET').'/'.$container.urlencode($this->location));
        } elseif ($this->link == 1 || $this->link == true) {
            return $this->location;
        } else {
            return '#';
        }
    }

    public function downloadBlobSample()
    {
        $mt = $this->mime_type;
        $multimediaType = getMultimediaType($mt);
        $link = false;
        if ($this->link) {
            $link = true;
            $fls = $this->location;

            return [$fls, $mt, $link];
        } elseif ($this->cloud == 1 || $this->cloud == true) {
            $baseURL = env('AWS_URL').env('AWS_BUCKET');
            if ($this->type == 'GroupReportCard' || $this->type == 'SingleReportCard') {
                $fls = $baseURL.'/reportcardmultimedia/'.rawurlencode($this->location);
            } elseif ($this->type == 'ManualCertificate') {
                $fls = $baseURL.'/certificatemultimedia/'.$this->location;
            } elseif ($this->type == 'OnboardingNudges') {
                $fls = $baseURL.'/onboardingnudges/'.$multimediaType.'/'.rawurlencode($this->location);
            } elseif ($this->type == 'NudgeQA') {
                $fls = $baseURL.'/packetnudgesqa/'.$multimediaType.'/'.rawurlencode($this->location);
            } elseif ($this->type === 'CreateVideoCompilation') {
                $fls = Storage::disk('s3')->temporaryUrl('complmultimedia/'.$this->location, now()->addDay());
            } elseif ($this->type == 'Worksheet') {
                //                $fls = $baseURL . '/worksheets/raw/' .$this->location;
                $fls = Storage::disk('s3')->temporaryUrl('worksheets/raw/'.rawurlencode($this->location), now()->addDay());
            } elseif ($this->type == 'Poll') {
                $fls = $this->location;
            } elseif ($this->activity) {
                $fls = $baseURL.'/activitymultimedia/'.$this->type.'/'.rawurlencode($this->location);
            } else {
                $fls = $baseURL.'/interventiondata/'.rawurlencode($this->location);
            }

            return [$fls, $mt, $link];
        } else {
            return '';
        }
    }

    public function Messages(): HasMany
    {
        return $this->hasMany(\App\Models\InterventionMessage::class, 'inteverntion_multimedia_id');
    }
}
