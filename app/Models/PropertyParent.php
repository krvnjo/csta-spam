<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyParent extends Model
{
    use SoftDeletes;

    protected $table = 'property_parents';

    protected $fillable = [
        'name',
        'specification',
        'description',
        'image',
        'quantity',
        'brand_id',
        'subcateg_id',
        'purchase_price',
        'residual_value',
        'useful_life',
        'unit_id',
        'is_consumable',
        'is_active'
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categ_id');
    }

    public function propertyChildren(): HasMany
    {
        return $this->hasMany(PropertyChild::class, 'prop_id', 'id');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class, 'subcateg_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
