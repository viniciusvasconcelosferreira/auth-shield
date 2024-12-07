<?php

namespace App\Modules\Permission\Models;

use App\Modules\Groups\Models\Groups;
use App\Modules\Role\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'label'
    ];

    public function group(): BelongsToMany
    {
        return $this->belongsToMany(Groups::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permissions_roles');
    }
}
