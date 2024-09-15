<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Kalnoy\Nestedset\NodeTrait;

class Moderator extends Model
{
    use HasFactory;
    use NodeTrait, SoftDeletes;

    protected $fillable = [
        'name', 'phone', 'active', 'reviewed', 'image', 'role', 'user_id', 'date_left', 'e_role', 'e_Identifiers', 'block', 'awc_code',
    ];

    protected $casts = [
        'active' => 'boolean',
        'date_left' => 'datetime',
    ];

    public function administrator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function GroupsManaged(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Groups::class, 'group_moderator')
            ->withTimestamps()->withPivot('main', 'added');
    }

    public function SchoolsAffiliated(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Schools::class, 'moderator_school', 'moderator_id', 'schools_id')
            ->withTimestamps()
            ->withPivot('is_primary');
    }

    public function OrgsHandled(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Organization::class, 'organization_moderator', 'moderator_id', 'organizations_id')
            ->withTimestamps();
    }

    public function getBasicURL($image = null)
    {
        $imagePath = 'moderatorsimages/';
        if ($image !== null) {
            $imagePath .= $image;
        } else {
            $imagePath .= $this->image;
        }

        // This folder is private. So, we need to create a temporary URL to be shared. Direct URL can't be accessed.
        // This temporary URL will expire after 24 hours.
        return Storage::disk('s3')->temporaryUrl($imagePath, now()->addDay());
    }
}
