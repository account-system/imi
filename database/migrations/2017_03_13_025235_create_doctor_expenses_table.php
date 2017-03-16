<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->date('expense_date');
            $table->integer('invoice_no');
            $table->string('labo',35)->nullable;
            $table->integer('doctor_id');
            $table->integer('cusotmer_id');
            $table->string('description',200);
            $table->integer('qty');
            $table->integer('price');
            $table->integer('amount');
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
        Schema::dropIfExists('doctor_expenses');
    }
}
