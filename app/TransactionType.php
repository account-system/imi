<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    /**
    * Get all transactions belong to transaction type.
    */
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
