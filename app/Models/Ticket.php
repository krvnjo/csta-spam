<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ticket extends Model
{
    protected $table = 'tickets';

    protected $fillable = [
        'ticket_num',
        'name',
        'description',
        'estimated_cost',
        'prio_id',
        'prog_id',
        'approved_at',
        'started_at',
        'completed_at',
        'remarks',
    ];

    public function priority(): HasOne
    {
        return $this->HasOne(Priority::class, 'id', 'prio_id');
    }

    public function progress(): HasOne
    {
        return $this->HasOne(Progress::class, 'id', 'prog_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PropertyChild::class, 'ticket_id');
    }
}
