<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Condition extends Model
{
    use SoftDeletes;

    protected $table = 'conditions';

    protected $fillable = [
        'name',
        'description',
        'is_active',
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
        return $this->hasMany(PropertyChild::class, 'condi_id');
    }
}
