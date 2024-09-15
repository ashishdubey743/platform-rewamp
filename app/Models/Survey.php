<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Survey extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'organizations_id', 'org_name', 'groups_id', 'grp_name', 'link', 'survey_type',
    ];

    public function Group(): BelongsTo
    {
        return $this->belongsTo('App\Group', 'groups_id');
    }

    public function Records(): HasMany
    {
        return $this->hasMany(\App\Models\SurveyRecord::class, 'surveys_id');
    }

    public function GetURL($multimedia_location)
    {
        return Storage::disk('s3')->temporaryUrl('enrollmentforms/'.$multimedia_location, now()->addDay());
    }
}
