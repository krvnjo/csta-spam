<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyChild extends Model
{
    use SoftDeletes;

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
        'status_id',
        'condi_id',
        'remarks',
        'is_active'
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
}
