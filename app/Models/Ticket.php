<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ticket extends Model
{
    protected $table = 'tickets';

    protected $fillable = [
        'name',
        'description',
        'total_cost',
        'prio_id',
        'prog_id',
        'remarks',
        'is_active',
    ];

    public function priority(): HasOne
    {
        return $this->HasOne(Priority::class, 'id', 'prio_id');
    }

    public function progress(): HasOne
    {
        return $this->HasOne(Progress::class, 'id', 'prog_id');
    }
}
