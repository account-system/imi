<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
 
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'string',
        'updated_at' => 'string'
    ];

    /**
     * Get the transaction type that owns the transaction.
     */
    public function transactionType()
    {
        return $this->belongsTo('App\TransactionType');
    }

    /**
     * Get all transaction details belong to transaction.
     */
    public function transactionDetails()
    {
        return $this->hasMany('App\TransactionDetail');
    }
}
