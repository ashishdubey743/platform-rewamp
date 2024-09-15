<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class WorksheetTraining extends Model
{
    use SoftDeletes;

    protected $table = 'worksheets_training';

    protected $fillable = [
        'media_link', 'labelling_status', 'worksheet_id',
    ];

    public function worksheet(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Worksheet::class, 'worksheet_id');
    }

    public function worksheetTrainingMediaAoi(): HasMany
    {
        return $this->hasMany(\App\Models\WorksheetTrainingMediaAOI::class, 'worksheet_training_id', 'id');
    }

    public function getURL($image = null)
    {
        $imageName = '';
        if ($image !== null) {
            $imageName = $image;
        } else {
            $imageName = $this->media_link;
        }

        return Storage::disk('s3')->url(env('AWS_BUCKET').'/'.'parentinteractions/'.$imageName);
    }
}
