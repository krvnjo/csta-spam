<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    protected $table = 'accesses';

    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];
}
