<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'statuses';

    protected $fillable = [
        'name',
        'description',
    ];

    public function property(): BelongsTo {
        return $this->belongsTo(PropertyParent::class);
    }

    public function propertyChildren(): HasMany {
        return $this->hasMany(PropertyChild::class,'status_id','id');
    }
}
