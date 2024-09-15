<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $fillable = [
        'email',
        'token',
        'role_id',
    ];

    public $timestamps = true;
}
