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
            $table->string('name',60)->nullable();
            $table->string('type',60)->nullable()->default(null);
            $table->string('barcode',60)->nullable->default(null);
            $table->string('sex',10)->nullable->default(null);
            $table->string('tel',30)->nullable->default(null);
            $table->string('address',200)->nullable->default(null);
            $table->string('email',30)->nullable->default(null);
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
