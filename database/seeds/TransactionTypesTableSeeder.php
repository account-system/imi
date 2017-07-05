<?php

use Illuminate\Database\Seeder;

class TransactionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactionTypes = array(
    		array(
	            'name' => 'Invoice',
        	),
        	array(
	            'name' => 'Payment',
        	),
        	array(
	            'name' => 'Estimate',
        	),
        	array(
	            'name' => 'Sales Receipt',
        	),
        	array(
	            'name' => 'Credit Note',
        	),
        	array(
	            'name' => 'Charge',
        	),
        	array(
	            'name' => 'Time Charge',
        	),
             array(
                'name' => 'Check',
            ),
            array(
                'name' => 'Deposit',
            ),
            array(
                'name' => 'Transfer',
            ),
        	array(
	            'name' => 'Journal Entry',
        	),
            array(
                'name' => 'Inventory Qty Adjust',
            )
    	);

    	DB::table('transaction_types')->insert($transactionTypes);
    }
}
