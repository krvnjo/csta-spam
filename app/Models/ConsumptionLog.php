<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsumptionLog extends Model
{
    use SoftDeletes;

    protected $table = 'consumption_logs';

    protected $fillable = [
        'consume_id',
        'consumed_by',
        'dept_id',
        'quantity_consumed',
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
}
