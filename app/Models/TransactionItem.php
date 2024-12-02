<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $table = 'transaction_items';

    protected $fillable = [
        'transaction_id',
        'parent_id',
        'quantity',
    ];

    /**
     * Relationship with the parent transaction.
     */
    public function itemTransactions()
    {
        return $this->belongsTo(ItemTransaction::class, 'transaction_id');
    }

    /**
     * Relationship with the parent property (consumable item).
     */
    public function property()
    {
        return $this->belongsTo(PropertyParent::class, 'parent_id');
    }
}
