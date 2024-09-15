<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDashboard extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'organization_id', 'dashboard_id', 'name', 'is_default', 'filter',
    ];
}
