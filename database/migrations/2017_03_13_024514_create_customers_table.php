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
            $table->string('first_name',35);
            $table->string('last_name',35);
            $table->string('sex',35);
            $table->date('dob');
            $table->string('tel',200)->nullable();
            $table->string('email',200)->nullable();
            $table->string('relative_contact',200)->nullable();
            $table->string('relative_tel',200)->nullable();
            $table->string('detail',200)->nullable();
            $table->string('address',200)->nullable();
            $table->boolean('enabled');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
