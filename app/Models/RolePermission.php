<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RolePermission extends Model
{
    protected $table = 'role_permissions';

    protected $fillable = [
        'role_id',
        'perm_id',
        'access_id',
    ];

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'perm_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function access(): BelongsTo
    {
        return $this->belongsTo(Access::class, 'access_id');
    }
}
