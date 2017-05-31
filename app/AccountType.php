<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    /**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
	    
	];

	/**
     * Get accounts belong to account type.
     */
    public function accounts()
    {
        return $this->hasMany('App\account');
    }

}
