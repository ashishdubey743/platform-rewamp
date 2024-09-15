<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LearningDomainNew extends Model
{
    use HasFactory;

    protected $table = 'learning_domains_new';

    protected $fillable = [
        'learning_domain', 'sub_domain', 'sub_sub_domain', 'learning_outcome', 'tag', 'pre_requisite', 'type',
    ];

    public function Activities(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Activity::class, 'activity_learning_domain_new',
            'learning_domain_id', 'activity_id');
    }
}
