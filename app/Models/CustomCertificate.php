<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class CustomCertificate extends Model
{
    protected $fillable = ['path', 'recipient_type', 'user_id', 'sent', 'status'];

    public function administrator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function GetURL()
    {
        return Storage::disk('s3')->temporaryUrl('complmultimedia/'.$this->path, now()->addDay());
    }
}
