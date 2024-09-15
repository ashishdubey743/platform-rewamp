<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    protected $fillable = [
        'district', 'state',
    ];
}
