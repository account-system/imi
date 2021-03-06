<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name',60);
            $table->string('contact_name',60);
            $table->string('contact_title',60);
            $table->integer('supplier_type_id')->unsigned();
            $table->enum('gender',['Male','Female']);
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
        Schema::dropIfExists('suppliers');
    }
}
