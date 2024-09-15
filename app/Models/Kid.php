<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Kid extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'preschool_age', 'preschool_attend',
        'birthday', 'guardian_id', 'preschool_private', 'gender', 'image',
    ];

    protected $casts = [
        'preschool_attend' => 'boolean',
        'birthday' => 'date',
        'preschool_age' => 'boolean',
        'preschool_private' => 'boolean',
    ];

    public function Parents(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Guardian::class);
    }

    public function GetURL()
    {
        return Storage::disk('s3')->temporaryUrl('enrollmentforms/children/'.$this->image, now()->addDay());
    }

    public function getBasicURL($image = null)
    {
        $imagePath = 'kidsimages/';
        if ($image !== null) {
            $imagePath .= $image;
        } else {
            $imagePath .= $this->image;
        }

        // This folder is private. So, we need to create a temporary URL to be shared. Direct URL can't be accessed.
        // This temporary URL will expire after 24 hours.
        return Storage::disk('s3')->temporaryUrl($imagePath, now()->addDay());
    }

    public function getBirthdayAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('Y-m-d');
        }

        return null;
    }
}
