<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property mixed $id
 * @property mixed|string $name
 * @property mixed|int $dept_id
 * @property mixed|int $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Designation extends Model
{
    use SoftDeletes;

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
