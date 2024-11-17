<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowingItem extends Model
{
    protected $table = 'request_items';

    protected $fillable = [
        'borrow_id',
        'parent_id',
        'child_id',
        'quantity',
    ];

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class, 'borrow_id');
    }

    public function property()
    {
        return $this->belongsTo(PropertyParent::class, 'parent_id');
    }
}
