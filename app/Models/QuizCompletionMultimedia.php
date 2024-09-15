<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizCompletionMultimedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id', 'multimedia_location', 'mime_type', 'type', 'language',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}

