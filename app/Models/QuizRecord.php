<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizRecord extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'quiz_id', 'groups_id', 'visit', 'submit', 'success', 'guardian_phone',
        'moderator_phone', 'created_at', 'updated_at', 'responder_quiz_id'
    ];

    protected $casts = [
        'visit' => 'boolean',
        'submit' => 'boolean',
        'success' => 'boolean',
    ];

    public function Parent(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Guardian::class, 'guardian_phone');
    }

    public function Moderator()
    {
        return $this->belongsTo(\App\Models\Moderator::class, 'moderator_phone');
    }
}
