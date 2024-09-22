<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'is_active'
    ];

    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class, 'categ_id');
    }

    public function property_parents(): HasMany
    {
        return $this->hasMany(PropertyParent::class, 'categ_id');
    }

    public function property(): HasMany
    {
        return $this->hasMany(PropertyParent::class, 'subcateg_id');
    }
}
