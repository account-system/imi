<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctor_type_id');
            $table->string('name',35);
            $table->string('sex',35);
            $table->string('addrress',200);
            $table->integer('phone');
            $table->integer('price');
            $table->string('type',35)->nullable;
            $table->string('detial',200)->nullable;
            $table->string('action',35)->nullable;
            $table->boolean('stutas');
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
        Schema::dropIfExists('doctor_lists');
    }
}
