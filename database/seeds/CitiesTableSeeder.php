<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = array(
    		array(
    			'master_type_id' => 7,
    			'master_detail_id' => 1,
	            'name' => 'Battambang',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Kampong Cham',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Siem Reap',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Kampong Thom',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Pursat',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Kampong Speu',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Prey Veng',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Kampong Chhnang',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Takéo',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Kampot',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Banteay Meanchey',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Kandal',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Kratié',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Koh Kong',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Svay Rieng',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Stung Treng',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Mondulkiri',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Preah Sihanouk',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Preah Vihear',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Ratanakiri',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Oddar Meanchey',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Phnom Penh',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Pailin',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Keb',
        	),
        	array(
        		'master_type_id' => 7,
        		'master_detail_id' => 1,
	            'name' => 'Tboung Khmum',
        	)
    	);

    	foreach ($cities as $key => $cities) {
    		DB::table('master_sub_details')->insert([
    			'master_type_id' 	=> 	$cities['master_type_id'],
    			'master_detail_id' 	=> 	$cities['master_detail_id'],
    			'name' 				=> 	$cities['name'],
	            'created_at'		=> 	Carbon::now(), 
	            'updated_at'		=> 	Carbon::now(),
    		]);
    	}
    }
}
