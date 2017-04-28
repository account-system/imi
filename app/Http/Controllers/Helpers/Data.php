<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Helpers\Role;
use Illuminate\Support\Facades\Auth;

class Data
{
  	/*Default password*/
  	const DEFAULT_PASSWORD = '123456';

   	/*Role data source*/
    const ROLE = Array(
                  array('value'=>'Accountant','text'=>'Accountant'), 
                  array('value'=>'Administrator','text'=>'Administrator'), 
                  array('value'=>'Receptionist','text'=>'Receptionist')
                );

}
