<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LearningDomain extends Model
{
    protected $table = 'learning_domains';

    protected $fillable = [
        'learning_domain', 'sub_domain', 'tag',
    ];

    public function Activities(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Activity::class);
    }

    public function LDomains(): HasMany
    {
        return $this->hasMany(\App\Models\Question::class, 'learning_domain_id');

    }
}
