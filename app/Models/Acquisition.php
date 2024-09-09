<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed $id
 * @property mixed|string $name
 * @property mixed|int $is_active
 */
class Acquisition extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'acquisitions';

    protected $fillable = [
        'name'
    ];

    public function property_children(): HasMany {
        return $this->hasMany(PropertyChild::class, 'acqui_id');
    }
}
