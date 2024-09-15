<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorksheetAOI extends Model
{
    use SoftDeletes;

    protected $table = 'worksheets_aoi';

    protected $fillable = [
        'worksheet_id', 'regions_of_interest', 'score',
    ];

    protected $spatialFields = [
        'regions_of_interest',
    ];

    public function worksheet(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Worksheet::class, 'worksheet_id');
    }

    public function worksheetTrainingMediaAoi(): HasMany
    {
        return $this->hasMany(\App\Models\WorksheetTrainingMediaAOI::class, 'worksheet_aoi_id', 'id');
    }
}
