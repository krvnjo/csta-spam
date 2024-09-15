<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'user_name',
        'pass_hash',
        'image',
        'lname',
        'fname',
        'mname',
        'role_id',
        'dept_id',
        'email',
        'phone',
        'is_active'
    ];

    protected $casts = [
        'last_login' => 'datetime',
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
