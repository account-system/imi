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
                'min_code'  =>  11000,
                'max_code'  =>  11999,
                'name'      =>  'Bank',
            ),
            array(
                'min_code'  =>  12000,
                'max_code'  =>  12999,
                'name'      =>  'Accounts Receivable',
            ),
            array(
                'min_code'  =>  13000,
                'max_code'  =>  13999,
                'name'      =>  'Other Current Asset',    
            ),
            array(
                'min_code'  =>  14000,
                'max_code'  =>  14999,
                'name'      =>  'Fixed Asset',
            ),
            array(
                'min_code'  =>  15000,
                'max_code'  =>  15999,
                'name'      =>  'Other Asset',
            ),
    		array(
                'min_code'  =>  21000,
                'max_code'  =>  21999,
	            'name'	    =>	'Accounts Payable',	
        	),
            array(
                'min_code'  =>  22000,
                'max_code'  =>  22999,
                'name'      =>  'Other Current Liability',
            ),
            array(
                'min_code'  =>  23000,
                'max_code'  =>  23999,
                'name'  =>  'Long Term Liability', 
            ),
            array(
                'min_code'  =>  30000,
                'max_code'  =>  39999, 
                'name'      =>  'Equity',
            ),
            array(
                'min_code'  =>  50000,
                'max_code'  =>  59999,
                'name'      =>  'Income',
            ),
            array(
                'min_code'  =>  60000,
                'max_code'  =>  69999,
                'name'      =>  'Cost of Goods Sold',
            ),
            array(
                'min_code'  =>  70000,
                'max_code'  =>  79999,
                'name'      =>  'Expense',
            ),
            array(
                'min_code'  =>  80000,
                'max_code'  =>  89999,
                'name'      =>  'Other Income',
            ),
        	array(
                'min_code'  =>  90000,
                'max_code'  =>  99999,
	            'name' 	   => 	'Other Expense',
        	)	
    	);

    	DB::table('account_types')->insert($accountTypes);
       
    }
}
