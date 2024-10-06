<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use SoftDeletes;

    protected $table = 'permissions';

    protected $fillable = [
        'name',
        'guard_name',
        'is_active'
    ];
}
