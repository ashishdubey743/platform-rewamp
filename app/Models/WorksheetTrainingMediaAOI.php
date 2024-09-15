<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorksheetTrainingMediaAOI extends Model
{
    use SoftDeletes;

    protected $table = 'worksheets_training_media_aoi';

    protected $fillable = [
        'worksheet_aoi_id', 'worksheet_id', 'worksheet_training_id', 'solved_training_media', 'manual_training_status', 'labelling_status', 'score',
    ];

    public function worksheet(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Worksheet::class, 'worksheet_id');
    }

    public function WorksheetAOI(): BelongsTo
    {
        return $this->belongsTo(\App\Models\WorksheetAOI::class, 'worksheet_aoi_id');
    }

    public function WorksheetTraining(): BelongsTo
    {
        return $this->belongsTo(\App\Models\WorksheetTraining::class, 'worksheet_training_id');
    }
}
