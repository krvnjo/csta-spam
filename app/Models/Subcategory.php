<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use SoftDeletes;

    protected $table = 'subcategories';

    protected $fillable = [
        'name',
        'is_active',
    ];

    public function brands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class, 'brand_subcategories', 'subcateg_id', 'brand_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_subcategories', 'subcateg_id', 'categ_id');
    }
}
