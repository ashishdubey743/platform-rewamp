<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataExport extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['status', 'jfname', 'message', 'input', 'user_id',
        'end_time', 'start_time', 'url',
    ];

    protected $casts = [
        'end_time' => 'datetime',
        'start_time' => 'datetime',
    ];

    public function JobOwner()
    {
        return $this->BelongsTo(\App\Models\User::class, 'user_id');
    }
}
