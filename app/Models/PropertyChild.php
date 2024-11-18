<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class PropertyChild extends Model
{
    protected $table = 'property_children';

    protected $fillable = [
        'prop_id',
        'prop_code',
        'serial_num',
        'type_id',
        'acq_date',
        'warranty_date',
        'stock_date',
        'inventory_date',
        'dept_id',
        'desig_id',
        'condi_id',
        'status_id',
        'ticket_id',
        'remarks',
        'is_active'
    ];
    protected $casts = [
        'inventory_date' => 'datetime',
    ];

    public function acquisition(): BelongsTo
    {
        return $this->belongsTo(Acquisition::class, 'type_id', 'id');
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Condition::class, 'condi_id', 'id');
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class, 'desig_id', 'id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'dept_id', 'id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(PropertyParent::class, 'prop_id');
    }

    public function ticket(): HasOneThrough
    {
        return $this->hasOneThrough(
            MaintenanceTicket::class,
            MaintenanceTicketItem::class,
            'item_id',     // Foreign key on the pivot table
            'id',          // Foreign key on the tickets table
            'id',          // Local key on the items table
            'ticket_id'    // Local key on the pivot table
        );
    }
}
