<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Progress extends Model
{
    protected $table = 'progresses';

    protected $fillable = [
        'name',
        'badge_id',
        'legend_id',
        'is_active'
    ];

    public function badge(): HasOne
    {
        return $this->hasOne(Color::class, 'id', 'badge_id');
    }

    public function legend(): HasOne
    {
        return $this->hasOne(Color::class, 'id', 'legend_id');
    }
}
