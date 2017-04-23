<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = array(
    		array(
    			'master_type_id' => 6,
	            'name' => 'Cambodia',
        	),
        	array(
        		'master_type_id' => 6,
	            'name' => 'Thailand',
        	)
    	);

    	foreach ($countries as $key => $country) {
    		DB::table('master_details')->insert([
    			'master_type_id' 	=> 	$country['master_type_id'],
    			'name' 				=> 	$country['name'],
	            'created_at'		=> 	Carbon::now(), 
	            'updated_at'		=> 	Carbon::now(),
    		]);
    	}
    }
}
