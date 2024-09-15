<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Panel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'panels';

    protected $fillable = [
        'panel_name', 'graph_header', 'panel_type', 'graph_type', 'footnote', 'size', 'html_div_id', 'thumbnail',
    ];

    public function Dashboards(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Dashboard::class, 'dashboard_panel', 'panel_id', 'dashboard_id')
            ->withTimestamps()->withPivot('is_default');
    }
}
