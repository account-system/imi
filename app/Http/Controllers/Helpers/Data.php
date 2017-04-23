<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Helpers\Role;
use Illuminate\Support\Facades\Auth;

class Data
{
  	/*Default password*/
  	const DEFAULT_PASSWORD = '123456';

   	/*role data source*/
   	public static function role()
   	{
        if (Auth::user()->role == Role::OWNER) 
        {
            return array(array('value'=>'Accountant','text'=>'Accountant'), array('value'=>'Administrator','text'=>'Administrator'), array('value'=>'Receptionist','text'=>'Receptionist'), array('value'=>'Owner','text'=>'Owner'));
        }else{
            return array(array('value'=>'Accountant','text'=>'Accountant'), array('value'=>'Administrator','text'=>'Administrator'), array('value'=>'Receptionist','text'=>'Receptionist'));
        }
   	}
}
