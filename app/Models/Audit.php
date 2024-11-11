<?php

namespace App\Models;

use Spatie\Activitylog\Models\Activity;

class Audit extends Activity
{
    protected $table = 'audits';

    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'event',
        'causer_type',
        'causer_id',
        'properties',
        'batch_uuid',
    ];
}
