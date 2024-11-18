<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Borrowing extends Model
{
    protected $table = 'borrowings';

    protected $fillable = [
        'borrow_num',
        'requester_id',
        'status',
        'remarks',
        'borrow_date',
    ];

    public function requester()
    {
        return $this->belongsTo(Requester::class, 'requester_id');
    }

    public function requestItems()
    {
        return $this->hasMany(BorrowingItem::class, 'borrow_id');
    }

    public function progress(): HasOne
    {
        return $this->HasOne(Progress::class, 'id', 'prog_id');
    }

}
