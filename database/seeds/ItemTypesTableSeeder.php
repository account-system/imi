<?php

use Illuminate\Database\Seeder;

class ItemTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itemTypes = array(
    		array(
    			'master_type_id' => 9,
	            'name' => 'Inventory',
        	),
        	array(
        		'master_type_id' => 9,
	            'name' => 'Service',
        	)
    	);

    	DB::table('master_details')->insert($itemTypes);
    }
}
