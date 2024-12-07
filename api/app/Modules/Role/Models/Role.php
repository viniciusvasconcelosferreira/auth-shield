<?php

namespace App\Modules\Role\Models;

use App\Modules\Permission\Models\Permission;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'label'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'roles_users');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permissions_roles');
    }
}
