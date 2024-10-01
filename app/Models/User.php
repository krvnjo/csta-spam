<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, SoftDeletes;

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
}
