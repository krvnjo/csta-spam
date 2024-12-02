<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemTransaction extends Model
{
    protected $table = 'item_transactions';

    protected $fillable = [
        'transaction_num',
        'requester_id',
        'received_by',
        'remarks',
        'transaction_date',
    ];

    /**
     * Relationship with the Requester.
     */
    public function requester()
    {
        return $this->belongsTo(Requester::class);
    }

    /**
     * Relationship with the transaction items.
     */
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id');
    }
}
