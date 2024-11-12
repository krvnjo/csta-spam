<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
