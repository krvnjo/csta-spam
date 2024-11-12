<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acquisition extends Model
{
    protected $table = 'acquisitions';

    protected $fillable = [
        'name',
        'is_active'
    ];
}
