<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDashboardPanel extends Model
{
    protected $table = 'user_dashboard_panels';

    protected $fillable = [
        'user_dashboard_id', 'dashboard_panel_id', 'display_order',
    ];
}
