<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetupServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setup_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type',200);
            $table->integer('customer_type_id');
            $table->string('service_name',40);
            $table->string('normal')->nullable;
            $table->integer('unit');
            $table->integer('price');
            $table->string('detail',200)->nullable;
            $table->boolean('status');
            $table->integer('create_by')->nullable;
            $table->integer('update_by')->nullable;
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
        Schema::dropIfExists('setup_services');
    }
}
