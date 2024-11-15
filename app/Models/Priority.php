<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Priority extends Model
{
    protected $table = 'priorities';

    protected $fillable = [
        'name',
        'description',
        'color_id',
        'is_active',
    ];

    public function color(): HasOne
    {
        return $this->hasOne(Color::class, 'id', 'color_id');
    }
}
