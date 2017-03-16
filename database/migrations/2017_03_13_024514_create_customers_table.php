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
            $table->integer('customer_type_id');
            $table->integer('country_id');
            $table->string('first_name',35);
            $table->string('last_name',35);
            $table->string('sex',6);
            $table->date('dob');
            $table->string('tel',35)->nullable();
            $table->string('email',60)->nullable();
            $table->string('relative_contact',60)->nullable();
            $table->string('relative_tel',35)->nullable();
            $table->string('detail',200)->nullable();
            $table->string('address',200)->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
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
