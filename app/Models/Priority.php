<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Priority extends Model
{
    use SoftDeletes;

    protected $table = 'priorities';

    protected $fillable = [
        'name',
        'description',
        'color_id',
        'is_active',
    ];
}
