<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Requester extends Model
{
    protected $table = 'requesters';

    protected $fillable = [
        'req_num',
        'name',
        'lname',
        'fname',
        'mname',
        'dept_id',
        'email',
        'phone_num',
        'is_active',
    ];

    public function department(): HasOne
    {
        return $this->hasOne(Department::class, 'id', 'dept_id');
    }

    public function itemTransactions()
    {
        return $this->hasMany(ItemTransaction::class, 'requester_id');
    }
}
