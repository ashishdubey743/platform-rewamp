<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VNumberBilling extends Model
{
    use SoftDeletes;

    protected $table = 'vnumber_billings';

    protected $fillable = [
        'vnumber', 'date',
    ];

    public function Vnumber(): BelongsTo
    {
        return $this->belongsTo(\App\Models\VNumbers::class, 'vnumber', 'vnumber');
    }
}
