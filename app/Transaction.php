<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * Get all transaction details belong to transaction.
     */
    public function transactionDetails()
    {
        return $this->hasMany('App\TransactionDetail');
    }
}
