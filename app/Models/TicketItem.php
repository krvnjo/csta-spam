<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketItem extends Model
{
    protected $table = 'ticket_items';

    protected $fillable = [
        'ticket_id',
        'item_id',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(PropertyChild::class, 'item_id');
    }
}
