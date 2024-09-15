<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed $id
 * @property mixed|string $name
 * @property mixed|string $description
 * @property int $color_id
 * @property mixed|int $is_active
 */
class Status extends Model
{
    use SoftDeletes;

    protected $table = 'statuses';

    protected $fillable = [
        'name',
        'description',
        'color_id',
        'is_active'
    ];

    public function color(): HasOne
    {
        return $this->hasOne(Color::class, 'id', 'color_id');
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(PropertyParent::class);
    }

    public function propertyChildren(): HasMany
    {
        return $this->hasMany(PropertyChild::class, 'status_id', 'id');
    }
}
