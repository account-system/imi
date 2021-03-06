<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('master_type_id')->unsigned();
            $table->string('name',60);
            $table->string('description',200)->nullable()->default(null);
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
        Schema::dropIfExists('master_type_detail');
    }
}
