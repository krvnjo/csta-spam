<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Condition extends Model
{
    use HasFactory, SoftDeletes;

    public function property(): BelongsTo {
        return $this->belongsTo(PropertyParent::class);
    }

    public function propertyChildren(): HasMany {
        return $this->hasMany(PropertyChild::class,'condi_id');
    }
}
