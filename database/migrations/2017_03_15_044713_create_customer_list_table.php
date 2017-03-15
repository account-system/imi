<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customerid',200);
            $table->string('customer_type_id',200);
            $table->string('barcode',200),->nullable();
            $table->string('country_id',200);
            $table->string('fname',200);
            $table->string('lname',200);
            $table->string('sex',200);
            $table->data('dob',200);
            $table->string('tel',200);
            $table->string('relative_contact',200)->nullable();
            $table->string('relative_tel',200)->nullable();
            $table->string('email',200);
            $table->string('address',200)->nullable();
            $table->integer('numbervisit',200)->nullable();
            $table->string('nextappoinment',200)->nullable();
            $table->string('medicalhistory',200)->nullable();
            $table->string('familyhistory',200)->nullable();
            $table->boolean('default');
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
        Schema::dropIfExists('customer_list');
    }
}
