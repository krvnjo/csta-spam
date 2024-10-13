<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategorySubcategory extends Model
{
    protected $table = 'category_subcategories';

    protected $fillable = [
        'categ_id',
        'subcateg_id'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categ_id');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class, 'subcateg_id');
    }
}
