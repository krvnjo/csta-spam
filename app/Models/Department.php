<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'name',
        'code',
        'is_active',
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

    public function consumptionLogs(): HasMany
    {
        return $this->hasMany(ConsumptionLog::class, 'dept_id');
    }
}
