<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AccountTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$accountTypes = array(
    		array(
	            'name' => 'Bank',
	            'min_code' => 10000,
	            'max_code' => 14999,  
        	),
        	array(
	            'name' => 'Accounts Recievable',
	            'min_code' => 15000,
	            'max_code' => 17999,  
        	),
        	array(
	            'name' => 'Other Current Asset',
	            'min_code' => 18000,
	            'max_code' => 19999,  
        	),
        	array(
	            'name' => 'Fixed Asset',
	            'min_code' => 20000,
	            'max_code' => 24999,  
        	),
        	array(
	            'name' => 'Other Asset',
	            'min_code' => 25000,
	            'max_code' => 29999,  
        	),
        	array(
	            'name' => 'Account Payable',
	            'min_code' => 30000,
	            'max_code' => 34999,  
        	),
        	array(
	            'name' => 'Other Current Liability',
	            'min_code' => 35000,
	            'max_code' => 37999,  
        	),
        	array(
	            'name' => 'Long Term Liability',
	            'min_code' => 38000,
	            'max_code' => 30999,  
        	),
        	array(
	            'name' => 'Equity',
	            'min_code' => 40000,
	            'max_code' => 49999,  
        	),
        	array(
	            'name' => 'Income',
	            'min_code' => 50000,
	            'max_code' => 54999,  
        	),
        	array(
	            'name' => 'Other Income',
	            'min_code' => 55000,
	            'max_code' => 59999,  
        	),
        	array(
	            'name' => 'Cost of Good Sold',
	            'min_code' => 60000,
	            'max_code' => 69999,  
        	),
        	array(
	            'name' => 'Expense',
	            'min_code' => 70000,
	            'max_code' => 74999,  
        	),
        	array(
	            'name' => 'Other Expense',
	            'min_code' => 75000,
	            'max_code' => 79999,  
        	)
    	);

    	foreach ($accountTypes as $key => $accountType) {
    		DB::table('account_types')->insert([
    			'name' => $accountType['name'],
	            'min_code' => $accountType['min_code'],
	            'max_code' => $accountType['min_code'], 
	            'created_at'=> Carbon::now(), 
	            'updated_at'=> Carbon::now(),
    		]);
    	}
       
    }
}
