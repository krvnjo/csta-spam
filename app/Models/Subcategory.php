<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'subcategories';

    protected $fillable = [
        'name',
        'categ_id',
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class, 'categ_id', 'id');
    }

    public function properties(): HasMany {
        return $this->hasMany(PropertyParent::class, 'subcateg_id');
    }
}
