<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor_type_id')->unsigned();
            $table->integer('branch_id')->unsigned();
            $table->string('company_name',60)->nullable();
            $table->string('contact_name',60)->nullable()->default(null);
            $table->string('cantact_title',60)->nullable()->default(null);
            $table->string('phone',30)->nullable()->default(null);
            $table->string('email',30)->nullable()->default(null);
            $table->integer('country_id')->unsigned()->nullable()->default(null);
            $table->integer('city_id')->unsigned()->nullable()->default(null);
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
        Schema::dropIfExists('vendors');
    }
}
