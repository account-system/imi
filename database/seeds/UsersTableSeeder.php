<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username'      => 	'CST Cambodia',
            'gender'		=> 	'Male',
            'email' 		=> 	'admin@imi.com',
            'phone' 		=> 	'023 212 909',
            'password' 		=> 	bcrypt('admin'),
            'role' 			=> 	'Administrator',
            'branches' 	    => 	'[{"value":1,"text":"IDC Phnom Penh"},{"value":2,"text":"IDC Siem Reap"}]',
            'country_id'	=> 	1,
	        'city_id'		=> 	22,
	        'address'		=> 'No. 193, St. 208, Sangkat Boeung Raing, Khan Daun Penh, 12211 Phnom Penh',
            'created_at'	=> 	Carbon::now(), 
	        'updated_at'	=> 	Carbon::now(),
        ]);
    }
}
