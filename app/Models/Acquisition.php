<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Acquisition extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'acquisitions';

    protected $fillable = [
        'name'
    ];
    public function property_children(): HasMany {
        return $this->hasMany(PropertyChild::class, 'acqui_id');
    }
}
