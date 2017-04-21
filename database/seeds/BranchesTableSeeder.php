<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branches = array(
    		array(
	            'name' 		=> 'IDC Phnom Penh',
	            'phone' 	=> '(855)23 212-909, (855)12 66-55-33 (Emergency), (855)16 55-33-66, (855)16 22-99-55, (855)11 55-33-66',
	            'email' 	=> 'info@imiclinic.com',
	            'website' 	=> 'imiclinic.com',
	            'country_id'=> 1,
	            'city_id'	=> 22,
	            'address'	=> 'No. 193, St. 208, Sangkat Boeung Raing, Khan Daun Penh, 12211 Phnom Penh',
        	),
        	array(
	            'name' 		=> 'IDC Siem Reap',
	            'phone' 	=> '(855)63 76 76 18, (855)99 395 682',
	            'email' 	=> 'idc@imiclinic.com',
	            'website' 	=> 'imiclinic.com',
	            'country_id'=> 1,
	            'city_id'	=> 3,
	            'address'	=> 'No. 545, National Road 6A, Siem Reap',
        	)
    	);

    	foreach ($branches as $key => $branch) {
    		DB::table('branches')->insert([
    			'name' 			=> 	$branch['name'],
    			'phone' 		=> 	$branch['phone'],
    			'email' 		=> 	$branch['email'],
    			'website' 		=> 	$branch['website'],
    			'country_id' 	=> 	$branch['country_id'],
    			'city_id' 		=> 	$branch['city_id'],
    			'address' 		=> 	$branch['address'],
	            'created_at'		=> 	Carbon::now(), 
	            'updated_at'		=> 	Carbon::now(),
    		]);
    	}
    }
}
