<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable = [
        'borrow_num',
        'requester_id',
        'status',
        'remarks',
    ];

    public function requester()
    {
        return $this->belongsTo(Requester::class, 'requester_id');
    }

    public function requestItems()
    {
        return $this->hasMany(BorrowingItem::class, 'borrow_id');
    }
}
