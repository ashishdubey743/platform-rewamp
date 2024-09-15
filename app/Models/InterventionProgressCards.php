<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterventionProgressCards extends Model
{
    protected $fillable = [
        'multimedia_report_card_id', 'intervention_id', 'intervention_multimedia_id', 'vnumber',
    ];
}
