<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'user_name',
        'pass_hash',
        'lname',
        'fname',
        'mname',
        'dept_id',
        'email',
        'phone_num',
        'user_image',
        'is_active'
    ];

    public function department(): HasOne
    {
        return $this->hasOne(Department::class, 'id', 'dept_id');
    }

    public function hasPermission($permissionName, $actions): bool
    {
        $role = $this->roles()->first();

        if (!$this->hasPermissionTo($permissionName) || !$role) {
            return false;
        }

        foreach ($actions as $action) {
            if ($role->permissions()->where('name', $permissionName)->where('can_' . $action, 1)->exists()) {
                return true;
            }
        }

        return false;
    }
}
