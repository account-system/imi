<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('customer_type_id')->unsigned();

            $table->integer('branch_id')->unsigned();

            $table->string('customer_name',60)->nullable();

            $table->enum('gender',['Male','Female'])->default('Male');

            $table->date('date_of_birth')->nullable()->default(null);

            $table->string('phone',30)->nullable()->default(null);

            $table->string('email',60)->nullable()->default(null);

            $table->string('relative_contact',60)->nullable()->default(null);

            $table->string('relative_phone',30)->nullable()->default(null);

            $table->string('country_id',10)->nullable()->default(null);

            $table->string('city_id',10)->nullable()->default(null);

            $table->string('region',30)->nullable()->default(null);

            $table->string('postal_code',30)->nullable()->default(null);

            $table->string('address',200)->nullable()->default(null);

            $table->string('detail',200)->nullable()->default(null);

            $table->enum('status',['Enabled','Disabled'])->default('Enabled');

            $table->integer('created_by')->unsigned()->nullable()->default(null);

            $table->integer('updated_by')->unsigned()->nullable()->default(null);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
