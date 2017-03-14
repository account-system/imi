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
            $table->integer('brand_id');
            $table->integer('country_id');
            $table->string('first_name',200);
            $table->string('last_name',200);
            $table->string('sex',200);
            $table->date('dob');
            $table->string('tel',200)->nullable();
            $table->string('email',200)->nullable();
            $table->string('relative_contact',200)->nullable();
            $table->string('relative_tel',200)->nullable();
            $table->string('detail',200)->nullable();
            $table->string('address',200)->nullable();
            $table->boolean('status');
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
