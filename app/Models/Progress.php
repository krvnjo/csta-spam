<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $table = 'progresses';

    protected $fillable = [
        'name',
        'badge_id',
        'legend_id',
        'is_active'
    ];
}
