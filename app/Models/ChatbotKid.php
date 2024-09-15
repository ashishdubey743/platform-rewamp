<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatbotKid extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'gender', 'chatbot_response_id', 'age', 'birthday', 'grade', 'created_at', 'updated_at',
    ];
}
