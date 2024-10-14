<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function subcategories(): BelongsToMany
    {
        return $this->belongsToMany(Subcategory::class, 'category_subcategories', 'categ_id', 'subcateg_id');
    }

    public function property(): HasMany
    {
        return $this->hasMany(PropertyParent::class, 'subcateg_id');
    }
}
