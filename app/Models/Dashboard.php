<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dashboard extends Model
{
    protected $table = 'dashboards';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class, 'dash_id', 'id');
    }

    public function propertyOverview()
    {
        return $this->hasOne(PropertyOverviewController::class); // Adjust based on your relationship type
    }
}
