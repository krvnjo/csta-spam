<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $table = 'brands';

    protected $fillable = [
        'name',
        'is_active',
    ];

    public function propertyParent(): HasMany
    {
        return $this->hasMany(PropertyParent::class, 'brand_id', 'id');
    }
}
