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
            $table->integer('employee_type_id')->unsigned();
            $table->string('name',60)->nullable();
            $table->string('gender',10)->nullable()->default(null);
            $table->string('identity_card',30)->nullable()->default(null);
            $table->string('position',200)->nullable()->default(null);
            $table->string('phone',30)->nullable()->default(null);
            $table->string('address',200)->nullable()->default(null);
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
        Schema::dropIfExists('employees');
    }
}
