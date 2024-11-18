<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MaintenanceTicket extends Model
{
    protected $table = 'maintenance_tickets';

    protected $fillable = [
        'ticket_num',
        'name',
        'description',
        'cost',
        'prog_id',
        'started_at',
        'completed_at',
        'remarks',
    ];

    public function progress(): HasOne
    {
        return $this->hasOne(Progress::class, 'id', 'prog_id');
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(PropertyChild::class, 'maintenance_ticket_items', 'ticket_id', 'item_id');
    }
}
