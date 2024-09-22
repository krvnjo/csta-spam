<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

    protected $table = 'brands';

    protected $fillable = [
        'name',
        'is_active',
    ];

    public function subcategories(): BelongsToMany
    {
        return $this->belongsToMany(Subcategory::class, 'brand_subcategory', 'brand_id', 'subcateg_id');
    }

    public function property_parents(): HasMany
    {
        return $this->hasMany(PropertyParent::class, 'brand_id');
    }

    public function property(): BelongsTo
    {
        return $this->BelongsTo(PropertyParent::class, 'id', 'prop_id');
    }
}
