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
                'class' =>  'Assets',   
                'name'  =>  'Current Asset',
            ),
            array(
                'class' =>  'Assets',  
                'name' =>   'Fixed Asset',
            ),
            array(
                'class' =>  'Assets',
                'name'  =>  'Inventory Asset',    
            ),
            array(
                'class' =>  'Assets', 
                'name'  =>  'Non-current Asset',
            ),
            array(
                'class' =>  'Assets',  
                'name'  =>  'Prepayment',
            ),
    		array(
    			'class'	=>	'Bank',	
	            'name'	=>	'Bank',	
        	),
            array(
                'class' =>  'Equity', 
                'name'  =>  'Equity',
            ),
            array(
                'class' =>  'Expenses',
                'name'  =>  'Depreciation', 
            ),
            array(
                'class' =>  'Expenses',  
                'name'  =>  'Direct Costs',
            ),
            array(
                'class' =>  'Expenses',  
                'name'  =>  'Expense',
            ),
            array(
                'class' =>  'Expenses',
                'name'  =>  'Overhead',
            ),
            array(
                'class' =>  'Expenses',
                'name'  =>  'Superannuation Expense',
            ),
            array(
                'class' =>  'Expenses',
                'name'  =>  'Wages Expense',
            ),
        	array(
        		'class'	=>	'Liabilities',
	            'name' 	=> 	'Current Liability',
        	),
        	array(
        		'class'	=>	'Liabilities',
	            'name' 	=> 	'Liability',
        	),
            array(
                'class' =>  'Liabilities',
                'name'  =>  'Non-current Liability',
            ),
            array(
                'class' =>  'Liabilities',
                'name'  =>  'PAYG Liability', 
            ),
            array(
                'class' =>  'Liabilities',
                'name'  =>  'Superannuation Liability',
            ),
            array(
                'class' =>  'Liabilities',
                'name'  =>  'Wages Payable Liability',
            ),
        	array(
        		'class'	=>	'Revenue',
	            'name' 	=> 'Other Income',
        	),
        	array(
        		'class'	=>	'Revenue',
	            'name' 	=> 	'Revenue',
        	),
        	array(
        		'class'	=>	'Revenue',
	            'name' 	=> 	'Sale',
        	)
        	
    	);

    	DB::table('account_types')->insert($accountTypes);
       
    }
}
