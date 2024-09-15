<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatbotResponses extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'phone', 'initiate', 'language_preference', 'eligible', 'school_dise_code', 'zipcode', 'actionable', 'success', 'mother_name',
        'father_name', 'name', 'relationship_to_kids', 'number_of_kids', 'step_number', 'source', 'integrated', 'latitude', 'longtitude',
        'quizbot', 'state', 'organization_id', 'district_id', 'program', 'created_at', 'updated_at', 'guardian'
    ];
}
