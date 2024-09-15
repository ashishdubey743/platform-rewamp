<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class UploadTracker extends Model
{
    use SoftDeletes;

    protected $table = 'upload_trackers';

    protected $fillable = [
        'user_id', 'status', 'title', 'file_link', 'type', 'show_file', 'eta', 'cancelled',
    ];

    /**
     * Get the S3 link attribute.
     */
    protected function fileLink(): Attribute
    {
        $disk = Storage::disk('s3');

        return Attribute::make(
            get: fn ($value) => ! empty($value) && $disk->exists($value) ?
                $disk->temporaryUrl($value, now()->addHour()) : null,
        );
    }

    public function jobs(): MorphToMany
    {
        return $this->morphToMany(
            WAJob::class,
            'tracker',
            'tracker_wajobs',
            'tracker_id',
            'wajobs_id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
