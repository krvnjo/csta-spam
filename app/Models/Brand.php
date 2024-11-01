<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

    protected $table = 'brands';

    protected $fillable = [
        'name',
        'is_active',
        'is_deleted'
    ];

    public function subcategories(): BelongsToMany
    {
        return $this->belongsToMany(Subcategory::class, 'brand_subcategories', 'brand_id', 'subcateg_id');
    }
}
