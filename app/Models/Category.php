<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'is_active'
    ];

    public function propertyParent(): HasMany
    {
        return $this->hasMany(PropertyParent::class, 'categ_id', 'id');
    }
}
