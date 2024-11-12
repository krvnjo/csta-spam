<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements CanResetPassword
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'user_name',
        'pass_hash',
        'name',
        'lname',
        'fname',
        'mname',
        'role_id',
        'dept_id',
        'email',
        'phone_num',
        'last_login',
        'user_image',
        'is_active'
    ];

    public function department(): HasOne
    {
        return $this->hasOne(Department::class, 'id', 'dept_id');
    }

    public function role(): HasOne
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
}
