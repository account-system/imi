<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MasterTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $masterTypes = array(
    		array(
	            'name' => 'customer_types',
        	),
        	array(
	            'name' => 'employee_types',
        	),
        	array(
	            'name' => 'doctor_types',
        	),
        	array(
	            'name' => 'supplier_types',
        	),
        	array(
	            'name' => 'categories',
        	),
            array(
                'name' => 'countries',
            ),
            array(
                'name' => 'cities',
            ),
            array(
                'name' => 'measures',
            ),
            array(
                'name' => 'item_types',
            )
    	);

    	DB::table('master_types')->insert($masterTypes);
    }
}
