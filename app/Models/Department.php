<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $table = 'departments';

    protected $fillable = [
        'name',
        'dept_code',
        'is_active'
    ];

    public function designations(): HasMany
    {
        return $this->hasMany(Designation::class, 'dept_id', 'id');
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(PropertyParent::class);
    }

    public function propertyChildren(): BelongsTo
    {
        return $this->belongsTo(PropertyChild::class, 'dept_id', 'id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'dept_id', 'id');
    }
}
