<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identity_card',60)->nullable()->default(null);
            $table->string('first_name',30);
            $table->string('last_name',30);
            $table->string('job_title',60);
            $table->integer('employee_type_id')->unsigned();
            $table->enum('gender',['Male','Female']);
            $table->date('date_of_birth');
            $table->date('start_work')->nullable()->default(null);
            $table->date('end_work')->nullable()->default(null);
            $table->date('start_contract')->nullable()->default(null);
            $table->date('end_contract')->nullable()->default(null);
            $table->integer('spouse')->unsigned()->default(0);
            $table->integer('minor')->unsigned()->default(0);
            $table->string('phone',30);
            $table->string('email',60)->nullable()->default(null);
            $table->integer('country_id')->unsigned()->nullable()->default(null);
            $table->integer('city_id')->unsigned()->nullable()->default(null);
            $table->string('region',30)->nullable()->default(null);
            $table->string('postal_code',30)->nullable()->default(null);
            $table->string('address',200)->nullable()->default(null);
            $table->string('detail',200)->nullable()->default(null);
            $table->integer('branch_id')->unsigned();
            $table->enum('status',['Active','Inactive'])->default('Active');
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
        Schema::dropIfExists('employees');
    }
}
