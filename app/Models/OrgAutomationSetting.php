<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrgAutomationSetting extends Model
{
    use SoftDeletes;

    protected $table = 'org_automation_settings';

    protected $fillable = [
        'organizations_id', 'automation_feature', 'active', 'execution_day', 'sending_day',
        'sending_time', 'frequency', 'start_date', 'last_run_date',
    ];
}
