<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MasterTypesTableSeeder::class);
        $this->call(ItemTypesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(BranchesTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        /*Accounting system seeder*/
        $this->call(AccountTypesTableSeeder::class);
        $this->call(TransactionTypesTableSeeder::class);
    }

}
