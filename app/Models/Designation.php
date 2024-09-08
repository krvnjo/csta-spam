<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Designation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'designations';

    protected $fillable = [
        'name',
        'dept_id'
    ];

    public function department(): BelongsTo {
        return $this->belongsTo(Department::class, 'dept_id', 'id');
    }

    public function property(): BelongsTo {
        return $this->belongsTo(PropertyParent::class);
    }

    public function propertyChildren(): HasMany {
        return $this->hasMany(PropertyChild::class,'desig_id');
    }
}
