<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dashboard extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category', 'type', 'type_name',
    ];

    public function Panels(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Panel::class, 'dashboard_panel', 'dashboard_id', 'panel_id')
            ->withTimestamps()->withPivot(['id', 'is_default']);
    }
}
