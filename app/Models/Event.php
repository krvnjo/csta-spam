<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    protected $table = 'events';

    public function legend(): HasOne
    {
        return $this->hasOne(Color::class, 'id', 'legend_id');
    }
}
