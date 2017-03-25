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
	            'name' => 'vendor_types',
        	),
        	array(
	            'name' => 'categories',
        	),
        	array(
	            'name' => 'branches',
        	),
            array(
                'name' => 'countries',
            )

    	);

    	foreach ($masterTypes as $key => $masterType) {
    		DB::table('master_types')->insert([
    			'name' => $masterType['name'],
	            'created_at'=> Carbon::now(), 
	            'updated_at'=> Carbon::now(),
    		]);
    	}
    }
}
