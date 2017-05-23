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
                'name'  =>  'Bank',
            ),
            array(
                'name' =>   'Accounts receivalbe',
            ),
            array(
                'name'  =>  'Other Current Asset',    
            ),
            array(
                'name'  =>  'Fixed Asset',
            ),
            array(
                'name'  =>  'Other Asset',
            ),
    		array(
	            'name'	=>	'Accounts Payable',	
        	),
            array(
                'name'  =>  'Other Current Liability',
            ),
            array(
                'name'  =>  'Long Term Liability', 
            ),
            array( 
                'name'  =>  'Equity',
            ),
            array(
                'name'  =>  'Income',
            ),
            array(
                'name'  =>  'Cost of Goods Sold',
            ),
            array(
                'name'  =>  'Expense',
            ),
            array(
                'name'  =>  'Other Income',
            ),
        	array(
	            'name' 	=> 	'Other Expense',
        	)	
    	);

    	DB::table('account_types')->insert($accountTypes);
       
    }
}
