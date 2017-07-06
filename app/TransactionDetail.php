<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id', 'account_id', 'item_id', 'item_description', 'price', 'amount', 'debit', 'credit', 'memo', 'status', 'created_by', 'updated_by'

    ];

    /**
     * Get the transaction that owns the transaction detail.
     */
    public function transaction()
    {
        return $this->belongsTo('App\Transaction');
    }

    /**
     * Get the account that owns the transaction detail.
     */
    public function account()
    {
        return $this->belongsTo('App\Account');
    }
}
