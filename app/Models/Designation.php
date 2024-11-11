<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Designation extends Model
{
    protected $table = 'designations';

    protected $fillable = [
        'name',
        'dept_id',
        'is_active'
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(PropertyParent::class);
    }

    public function propertyChildren(): HasMany
    {
        return $this->hasMany(PropertyChild::class, 'desig_id');
    }
}
