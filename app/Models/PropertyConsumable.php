<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyConsumable extends Model
{
    use SoftDeletes;

    protected $table = 'property_consumables';

    protected $fillable = [
        'prop_id',
        'prop_code',
        'serial_num',
        'type_id',
        'acq_date',
        'warranty_date',
        'stock_date',
        'dept_id',
        'desig_id',
        'status_id',
        'condi_id',
        'remarks'
    ];
}
