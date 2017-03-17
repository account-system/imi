<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type',200);
            $table->string('name',35);
            $table->string('sex',35);
            $table->integer('indentity_card');
            $table->integer('phone');
            $table->integer('basic_salary');
            $table->date('dob');
            $table->string('position',200);
            $table->integer('spouse');
            $table->integer('minor');
            $table->date('start_contract');
            $table->date('start_work');
            $table->date('end_contract');
            $table->string('address',200);
            $table->string('note',200)->nullable();
            $table->boolean('status');
            $table->date('modifies_date');
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
        Schema::dropIfExists('staff_lists');
    }
}
