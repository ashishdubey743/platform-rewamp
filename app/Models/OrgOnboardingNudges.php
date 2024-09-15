<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrgOnboardingNudges extends Model
{
    use SoftDeletes;

    protected $table = 'org_onboarding_nudges';

    protected $fillable = [
        'organizations_id', 'nudge_text', 'nudge_media', 'scheduled_time', 'day', 'enrollment_form', 'nudge_poll', 'nudge_worksheet',
    ];
}
