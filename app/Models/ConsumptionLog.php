<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsumptionLog extends Model
{
    protected $table = 'consumption_logs';

    protected $fillable = [
        'transaction_number',
        'consume_id',
        'consumed_by',
        'dept_id',
        'quantity_consumed',
        'consumed_at',
        'purpose',
        'remarks',
    ];

    public function consumable(): BelongsTo
    {
        return $this->belongsTo(PropertyConsumable::class, 'consume_id', 'id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
