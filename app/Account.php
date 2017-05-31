<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
     /**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
	    
	];

	/**
     * Get account type that owns the account.
     */
    public function accountType()
    {
        return $this->belongsTo('App\AccountType');
    }
}
